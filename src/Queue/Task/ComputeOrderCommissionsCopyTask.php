<?php
declare(strict_types=1);

namespace App\Queue\Task;

use App\Dto\WooCommerce\AddressDto;
use App\Dto\WooCommerce\LineItemDto;
use App\Dto\WooCommerce\OrderDto;
use App\Dto\WooCommerce\ShippingLineDto;
use App\Dto\WooCommerce\TaxDto;
use App\Dto\WooCommerce\TaxLineDto;
use App\Model\Entity\StateOwner;
use App\Utility\CommissionUtility;
use Automattic\WooCommerce\Client;
use Cake\Core\Configure;
use Cake\Http\Exception\NotAcceptableException;
use Cake\Http\Exception\NotFoundException;
use Cake\I18n\FrozenDate;
use Cake\I18n\FrozenTime;
use Cake\Log\Log;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\ORM\TableRegistry;
use Psr\Log\LoggerInterface;
use Queue\Console\Io;
use Queue\Queue\Task;

/**
 * Compute Order Commission Task
 *
 * @property \App\Model\Table\RatesTable $Rates
 * @property \App\Model\Table\PdfsTable $Pdfs
 * @property \App\Model\Table\StateOwnersTable $StateOwners
 * @property \App\Model\Table\OperatorsTable $Operators
 * @property \App\Model\Table\UsersTable $Users
 */
class ComputeOrderCommissionsTask extends Task
{
    use LocatorAwareTrait;

    /**
     * Default locale.
     *
     * @var string
     */
    public const LOCALE = 'en_US';

    /**
     * Rates table.
     *
     * @var \App\Model\Table\RatesTable
     */
    public \Cake\ORM\Table|\App\Model\Table\RatesTable $Rates;

    /**
     * PDFs Table.
     *
     * @var \App\Model\Table\PdfsTable
     */
    public \App\Model\Table\PdfsTable|\Cake\ORM\Table $Pdfs;

    /**
     * State Owners Table.
     *
     * @var \App\Model\Table\StateOwnersTable
     */
    public \Cake\ORM\Table|\App\Model\Table\StateOwnersTable $StateOwners;

    /**
     * Operators Table.
     *
     * @var \App\Model\Table\OperatorsTable
     */
    public \App\Model\Table\OperatorsTable|\Cake\ORM\Table $Operators;

    /**
     * Users Table.
     *
     * @var \App\Model\Table\UsersTable
     */
    public \App\Model\Table\UsersTable|\Cake\ORM\Table $Users;


    /**
     * @param  \Queue\Console\Io|null  $io
     * @param  \Psr\Log\LoggerInterface|null  $logger
     */
    public function __construct(?Io $io = null, ?LoggerInterface $logger = null)
    {
        
        Log::write('debug', 'inside constructor at '.date("d-m-Y H:i:s"));
        
        parent::__construct($io, $logger);
        $this->Rates = $this->getTableLocator()->get('Rates');
        $this->Pdfs = $this->getTableLocator()->get('Pdfs');
        $this->StateOwners = $this->getTableLocator()->get('StateOwners');
        $this->Operators = $this->getTableLocator()->get('Operators');
        $this->Users = $this->getTableLocator()->get('Users');
    }

    /**
     * @param array $data The array passed to QueuedJobsTable::createJob()
     * @param int $jobId The id of the QueuedJob entity
     * @return void
     * @throws \Exception
     */
    public function run(array $data, int $jobId): void
    {
        Log::write('debug', 'started with runnign utlity at '.date("d-m-Y H:i:s"));
        
        $jobs = $this->Pdfs->PdfJobs->find()->where(['is_completed' => 0]); 
        foreach($jobs as $job){
            $jobId = $job['queued_job_id'];
            $queuedJob = $this->Pdfs->PdfJobs->QueuedJobs->find()->where(['id' => $jobId])->first();
            $data = unserialize($queuedJob->data);
            $CommissionUtility = new CommissionUtility();
            $order_id = $data['order_id'];
            $client = new Client(
                Configure::read('WooCommerce.uri'),
                Configure::read('WooCommerce.consumer_key'),
                Configure::read('WooCommerce.consumer_secret')
            );
            $order = $this->processOrder((object)$client->get('orders/' . $order_id));
            
            Log::write('debug', json_encode($order));
            
            $operator = $this->getOperator($order->customerId);
            if ($operator) {
                $date = new FrozenDate($order->dateCreated);
                $order_data = [
                    'date' => $date->format('d M Y'),
                    'order' => $order->number,
                    'name' => $operator ? $operator->full_name : $order->billing->firstName . ' ' . $order->billing->lastName,
                    'total' => $order->total,
                    'commission' => $CommissionUtility->getCommissionTotal($order_id),
                ];
    
                $pdf_group = $this->getPdfGroup($this->getStateOwner($order->customerId), $data['pdf_id']);
                $meta_data = $this->Pdfs->PdfGroups->PdfMeta->newEntity([
                    'pdf_group_id' => $pdf_group->id,
                    'name' => 'order',
                    'value' => json_encode($order_data),
                ]);
                
                Log::write('debug', json_encode($meta_data));
                
                
                $this->Pdfs->PdfGroups->PdfMeta->saveOrFail($meta_data);
    
                $job = $this->Pdfs->PdfJobs->find()->where(['queued_job_id' => $jobId])->first();
                $job = $this->Pdfs->PdfJobs->patchEntity($job, ['is_completed' => true]);
                $this->Pdfs->PdfJobs->saveOrFail($job);
    
                $related_jobs = $this->Pdfs->PdfJobs->find()->where([
                    'pdf_id' => $data['pdf_id'],
                ]);
                /** @var \App\Model\Entity\PdfJob $related_job */
                $start = true;
                $pdf = TableRegistry::getTableLocator()->get('Pdfs')->get($data['pdf_id']);
                foreach ($related_jobs as $related_job) {
                    if (!$related_job->is_completed || $pdf->is_done) {
                        $start = false;
                        break;
                    }
                }
                if ($start) {
                    $this->QueuedJobs->createJob('CreateCommissionReport', [
                        'pdf_id' => $data['pdf_id'],
                    ]);
                }
            } else {
                Log::warning("Could not find operator: Their customer id is " . $order->customerId);
            }
        }
    }

    /**
     * @param object $order
     * @return \App\Dto\WooCommerce\OrderDto
     */
    public function processOrder(object $order): OrderDto
    {
        $line_items = [];
        foreach ($order->line_items as $line_item) {
            $line_items[] = $this->processLineItem($line_item);
        }

        $tax_lines = [];
        foreach ($order->tax_lines as $tax_line) {
            $tax_lines[] = $this->processTaxLine($tax_line);
        }

        $shipping_lines = [];
        foreach ($order->shipping_lines as $shipping_line) {
            $shipping_lines[] = $this->processShippingLine($shipping_line);
        }

        $data = [
            'id' => $order->id,
            'number' => $order->number,
            'orderKey' => $order->order_key,
            'createdVia' => $order->created_via,
            'version' => $order->version,
            'status' => $order->status,
            'currency' => $order->currency,
            'dateCreated' => new FrozenTime($order->date_created),
            'dateModified' => new FrozenTime($order->date_modified),
            'discountTotal' => $order->discount_total,
            'pricesIncludeTax' => $order->prices_include_tax,
            'cartTax' => $order->cart_tax,
            'total' => $order->total,
            'customerId' => $order->customer_id,
            'customerIpAddress' => $order->customer_ip_address,
            'customerUserAgent' => $order->customer_user_agent,
            'customerNote' => $order->customer_note,
            'dateCompleted' => new FrozenTime($order->date_completed),
            'datePaid' => new FrozenTime($order->date_paid),
            'cartHash' => $order->cart_hash,
            'lineItems' => $line_items,
            'taxLines' => $tax_lines,
            'shippingLines' => $shipping_lines,
            'feeLines' => $order->fee_lines,
            'couponLines' => $order->coupon_lines,
            'refunds' => $order->refunds,
            'shippingTotal' => $order->shipping_total,
            'paymentMethod' => $order->payment_method,
            'paymentMethodTitle' => $order->payment_method_title,
            'transactionId' => $order->transaction_id,
            'billing' => new AddressDto([
                'firstName' => $order->billing->first_name,
                'lastName' => $order->billing->last_name,
                'company' => $order->billing->company,
                'addressOne' => $order->billing->address_1,
                'addressTwo' => $order->billing->address_2,
                'city' => $order->billing->city,
                'state' => $order->billing->state,
                'postcode' => $order->billing->postcode,
                'country' => $order->billing->country,
                'email' => $order->billing->email,
                'phone' => $order->billing->phone,
            ]),
            'shipping' => new AddressDto([
                'firstName' => $order->shipping->first_name,
                'lastName' => $order->shipping->last_name,
                'company' => $order->shipping->company,
                'addressOne' => $order->shipping->address_1,
                'addressTwo' => $order->shipping->address_2,
                'city' => $order->shipping->city,
                'state' => $order->shipping->state,
                'postcode' => $order->shipping->postcode,
                'country' => $order->shipping->country,
            ]),
        ];

        return new OrderDto($data);
    }

    /**
     * @param object $line_item
     * @return \App\Dto\WooCommerce\LineItemDto
     */
    public function processLineItem(object $line_item): LineItemDto
    {
        $taxes = [];
        foreach ($line_item->taxes as $tax) {
            $taxes[] = $this->processTax($tax);
        }

        return new LineItemDto([
            'id' => $line_item->id,
            'name' => $line_item->name,
            'productId' => $line_item->product_id,
            'variationId' => $line_item->variation_id,
            'quantity' => $line_item->quantity,
            'taxClass' => $line_item->tax_class,
            'subtotalTax' => floatval($line_item->subtotal_tax),
            'total' => floatval($line_item->total),
            'totalTax' => floatval($line_item->total_tax),
            'taxes' => $taxes,
            'sku' => $line_item->sku,
            'price' => floatval($line_item->price),
        ]);
    }

    /**
     * @param object $tax
     * @return \App\Dto\WooCommerce\TaxDto
     */
    public function processTax(object $tax): TaxDto
    {
        return new TaxDto([
            'id' => $tax->id,
            'total' => floatval($tax->total),
            'subtotal' => floatval($tax->subtotal),
        ]);
    }

    /**
     * @param object $tax_line
     * @return \App\Dto\WooCommerce\TaxLineDto
     */
    public function processTaxLine(object $tax_line): TaxLineDto
    {
        return new TaxLineDto([
            'id' => $tax_line->id,
            'rateCode' => $tax_line->rate_code,
            'rateId' => $tax_line->rate_id,
            'label' => $tax_line->label,
            'taxTotal' => floatval($tax_line->tax_total),
            'shippingTaxTotal' => floatval($tax_line->shipping_tax_total),
            'compound' => $tax_line->compound,
        ]);
    }

    /**
     * @param object $shipping_line
     * @return \App\Dto\WooCommerce\ShippingLineDto
     */
    public function processShippingLine(object $shipping_line): ShippingLineDto
    {
        $taxes = [];
        foreach ($shipping_line->taxes as $tax) {
            $taxes[] = $this->processTax($tax);
        }

        return new ShippingLineDto([
            'id' => $shipping_line->id,
            'methodTitle' => $shipping_line->method_title,
            'methodId' => $shipping_line->method_id,
            'total' => floatval($shipping_line->total),
            'totalTax' => floatval($shipping_line->total_tax),
            'taxes' => $taxes,
        ]);
    }

    /**
     * @param $customer_id
     * @return \App\Model\Entity\Operator|\Cake\Datasource\EntityInterface|null
     */
    public function getOperator($customer_id)
    {
        // Step 1a: Fetch the correct user.
        $users = $this->Users->find()->where(['customer_id' => $customer_id]);
        // Step 1b: Verify Result.
        if ($users->all()->isEmpty()) {
            return null;
        }

        $user = $users->first();

        try  {
            // Step 2a: Fetch the correct operator.
            $operator = $this->Operators->get($user->operator_id);
            // Step 2b: Verify Result.
            if (!$operator) {
                throw new NotFoundException("Could not find an operator entity with operator id \"$user->operator_id\".");
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return null;
        }


        return $operator;
    }

    /**
     * @param \App\Model\Entity\StateOwner $state_owner
     * @param $pdf_id
     * @return \App\Model\Entity\PdfGroup|array|\Cake\Datasource\EntityInterface|null
     */
    public function getPdfGroup(StateOwner $state_owner, $pdf_id)
    {
        $groups = $this->Pdfs->PdfGroups->find()->where([
            'pdf_id' => $pdf_id,
            'state_owner_id' => $state_owner->state_owner_id,
        ]);
        if ($groups->count()) {
            $group = $groups->first();
        } else {
            $group = $this->Pdfs->PdfGroups->newEntity([
                'pdf_id' => $pdf_id,
                'state_owner_id' => $state_owner->state_owner_id,
            ]);
        }
        $this->Pdfs->PdfGroups->saveOrFail($group);

        return $group;
    }

    /**
     * Order State Owner Fetcher
     *
     * Get The state owner associated with the order.
     * Errors out if any one of the steps finds that the entity doesn't match the expected type or if the there is no
     * returned result.
     * Requires you to fetch the `customer_id` from the order. Typically, this is done at the controller level.
     * This can be accomplished by issuing the statement `$this->request()->getData('customer_id');`.
     * Follows the following logic:
     *  1. Fetch the correct `operator`.
     *  2. Fetch the correct `state` and verify the result is present.
     *  3. Fetch the correct `stateOwner` and verify the result is present.
     *  4. Send the state owner back to the calling statement.
     *
     * @param int|string $customer_id Customer ID from the order.
     * See description for how to obtain this.
     * @return \App\Model\Entity\StateOwner|array|\Cake\Datasource\EntityInterface
     */
    public function getStateOwner($customer_id)
    {
        // Step 1: Get the correct operator.
        $operator = $this->getOperator($customer_id);

        if ($operator) {
            // Step 2: Fetch the correct state.
            $state = $this->StateOwners->States->get($operator->state_id);
        } else {
            return $this->StateOwners->find()->where(['state_owner_first_name' => 'Corporate'])->first();
        }

        if ($state->state_owner_id) {
            // Step 3: Send the state owner back to the calling statement.
            return $this->StateOwners->get($state->state_owner_id);
        } else {
            return $this->StateOwners->find()->where(['state_owner_first_name' => 'Corporate'])->first();
        }
    }

    /**
     * Format As Currency
     *
     * Format a string, integer, or float into a USD formatted string.
     * First character will be '$'.
     * The value before the decimal is annotated with commas.
     * The value after the decimal is limited to two spaces.
     * The value after the decimal will always have two digits, even if one of them is 0.
     *
     * @param string|int|float $raw_value Value to be converted into currency form.
     * @param string $currency
     * @return string Currency formatted value.
     */
    public function currency($raw_value, string $currency): string
    {
        $float_value = floatval($raw_value);
        $format = numfmt_create(self::LOCALE, 2);
        $result = numfmt_format_currency($format, $float_value, $currency);
        if ($result) {
            return $result;
        } else {
            throw new NotAcceptableException("Value $raw_value could not be converted into a currency form.");
        }
    }
}

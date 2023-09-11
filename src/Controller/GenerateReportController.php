<?php
declare(strict_types=1);
namespace App\Controller;
ini_set('max_execution_time', '36000');



use App\Mailer\OrderNotificationMailer;
use Authorization\Exception\Exception as AuthorizationException;
use Cake\Core\Configure;
use Cake\Datasource\Exception\InvalidPrimaryKeyException;
use Cake\Event\EventInterface;
use Cake\Http\Response;
use Cake\I18n\FrozenTime;
use Cake\ORM\TableRegistry;
use Cake\Console\ShellDispatcher;
use App\Queue\Task\ComputeOrderCommissionsTask;
use App\Utility\CommissionUtility;
use App\Dto\WooCommerce\AddressDto;
use App\Dto\WooCommerce\LineItemDto;
use App\Dto\WooCommerce\OrderDto;
use App\Dto\WooCommerce\ShippingLineDto;
use App\Dto\WooCommerce\TaxDto;
use App\Dto\WooCommerce\TaxLineDto;
use App\Model\Entity\StateOwner;
use Automattic\WooCommerce\Client;
use Cake\Http\Exception\NotAcceptableException;
use Cake\Http\Exception\NotFoundException;
use Cake\I18n\FrozenDate;
use Cake\Log\Log;
use Cake\ORM\Locator\LocatorAwareTrait;
use Psr\Log\LoggerInterface;
use Queue\Console\Io;
use App\Mailer\CommissionReportMailer;
use Queue\Queue\Task;
use App\Model\Entity\PdfGroup;
use Cake\Collection\Collection;
use Cake\Routing\Route\Route;
use Cake\Routing\Router;
use Cake\Utility\Security;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use Mpdf\HTMLParserMode;
use Mpdf\Mpdf;
use Mpdf\MpdfException;
use Queue\Model\QueueException;
use Cake\Http\ServerRequest;

class GenerateReportController extends AppController
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


    
    
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Woocommerce');
        $this->fetchTable('Queue.QueuedJobs');
        $this->fetchTable('Pdfs');
		$this->loadModel('Queue.QueuedJobs');     
		$this->Rates = $this->getTableLocator()->get('Rates');
        $this->Pdfs = $this->getTableLocator()->get('Pdfs');
        $this->StateOwners = $this->getTableLocator()->get('StateOwners');
        $this->Operators = $this->getTableLocator()->get('Operators');
        $this->Users = $this->getTableLocator()->get('Users');
    }
    
    public function processOrders(): void
    {       
        $this->Authorization->skipAuthorization();
        $this->autoRender = false;
        
        $values = $this->request->getData('pdf_jobs');

      foreach($values as $job){
        echo "jobid=>".$jobId = $job['queued_job_id'];
        $CommissionUtility = new CommissionUtility();
        $order_id = $job['order_id'];
        $client = new Client(
            Configure::read('WooCommerce.uri'),
            Configure::read('WooCommerce.consumer_key'),
            Configure::read('WooCommerce.consumer_secret')
        );
        $order = $this->processOrder((object)$client->get('orders/' . $order_id));
        print_r("orderid->>".$order);
        //code modified to handle customer id with 353
        if($order->billing->email){
         $email = $order->billing->email;   
        }else{
            $email = 'no_email';
        }
        
        // echo "email is".$email;
        $customerIdTest = $order->customerId;
        // if($customerIdTest == 353){
        //     $customerIdTest = 298;
        // }
        $operator = $this->getOperator($customerIdTest);
        //code modified to handle customer id with 353 ends
        echo "<operatordata\n\n";
        print_r($operator);
        echo "operator end\n\n";

        if ($operator) {
            echo "\ninside the openrator for \n".$jobId."\n";
            $date = new FrozenDate($order->dateCreated);
            $order_data = [
                'date' => $date->format('d M Y'),
                'order' => $order->number,
                'name' => $operator ? $operator->full_name : $order->billing->firstName . ' ' . $order->billing->lastName,
                'total' => $order->total,
                'commission' => $CommissionUtility->getCommissionTotal($order_id),
            ];
            $pdf_group = $this->getPdfGroup($this->getStateOwner($order->customerId), $job['pdf_id']);
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
                'pdf_id' => $job['pdf_id'],
            ]);
            
            /** @var \App\Model\Entity\PdfJob $related_job */
            $start = true;
            $pdf = TableRegistry::getTableLocator()->get('Pdfs')->get($job['pdf_id']);
        
            foreach ($related_jobs as $related_job) {
                    echo "related job";
                    print($related_job);
                    echo "pdf is done";
                    print_r($pdf);
                    // echo "hello\n";
                    // echo (!$related_job->is_completed || $pdf->is_done);
                    // echo "\n! is related => ".(!$related_job->is_completed); 
                    // echo "\nis_done=>".$pdf->is_done;
                    // echo "\n queued_job_id=>".$job['queued_job_id'];
                    // echo "\nend<br>";
                if (!$related_job->is_completed || $pdf->is_done) {
                    echo "is pdf done value is".json_encode($pdf->is_done);
                    echo "is related job completed is ".json_encode($related_job->is_completed);
                    $start = false;
                    break;
                }
            }
            if ($start) {
                echo "started creating PDF";
                $this->createPdfReport(['pdf_id' => $job['pdf_id']]);
                
            }else{
                echo "PDF not generatered";
            }
        } else {
            echo "cannot find operator". $order->customerId;
            Log::warning("Could not find operator: Their customer id is " . $order->customerId);
        }
        
       }
       echo "ended";
       echo "<br><br>";
       print_r("ended at :- ". date("Y-m-d H:i:s"));
       die();
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
            'sku' => $line_item->sku || 0,
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
        $users = $this->Users->find()->where(['customer_id' => $customer_id, "operator_id IS NOT NULL"]);
        // $users_bck = $this->Users-find()->where(['user_email' => $customer_email, "operator_id IS NOT NULL"]);
        // Step 1b: Verify Result.
        if ($users->all()->isEmpty()) {
            // if($users_bck->all()->isEmpty()){
            echo "here->not found";
            return null;
            // }
            
        }

        $user = $users->first();
        echo "\n\nusers\n\n\n";
        print_r($users->toArray());

        try  {
            // Step 2a: Fetch the correct operator.
            $operator = $this->Operators->get($user->operator_id);
            // Step 2b: Verify Result.
            if (!$operator) {
                throw new NotFoundException("Could not find an operator entity with operator id \"$user->operator_id\".");
            }
        } catch (\Exception $e) {
            echo "operator not found";
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
    
    public function createPdfReport($data){
        
        $mpdf = $this->createPdf($data);
        $path = join(DS, [ROOT, 'tmp', 'reports', 'commissions']);
        
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
        $filename = Security::randomString(8) . '.pdf';
        $full_path = $path . DS . $filename;
        try {
            $mpdf->Output($full_path);
        } catch (MpdfException $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            throw new QueueException('Could not save PDF file.');
        }

        $pdfs_table = TableRegistry::getTableLocator()->get('Pdfs');
        $pdf = $pdfs_table->get($data['pdf_id']);
        $pdf = $pdfs_table->patchEntity($pdf, ['is_done' => true]);
        $pdfs_table->saveOrFail($pdf);
        // $this->QueuedJobs->createJob('EmailCommissionReport', [
        //     'filename' => $filename,
        //     'user_id' => $pdf->user_id,
        // ]);
        
        $this->sendMail([
            'filename' => $filename,
            'user_id' => $pdf->user_id,
        ]);
        
        
        $notifications_table = TableRegistry::getTableLocator()->get('Notifications');
        $hash = Security::randomString(16);
        $attributes = [
            'hash' => $hash
        ];
        $time = new FrozenTime();
        $notification = $notifications_table->newEntity([
            'user_id' => $pdf->user_id,
            'title' => 'Commission Report Finished on ' . $time->format('j F Y') . ' at ' . $time->format("h:i a"),
            'link' => Router::url([
                'controller' => 'notifications',
                'action' => 'commissionReport',
                '?' => [
                    'filename' => $filename,
                    'hash' => $hash
                ]
            ]),
            'attributes' => json_encode($attributes),
        ]);
        $notifications_table->saveOrFail($notification); 
    }
    
    
       /**
     * PDF generator and Saver.
     *
     * @param array $data Data from task, pass directly.
     * @return \Mpdf\Mpdf Object for debugging and testing.
     */
    public function createPdf(array $data): Mpdf
    {
        $pdf_groups = TableRegistry::getTableLocator()->get('PdfGroups')->find()->where(['pdf_id' => $data['pdf_id']]);

        $html = [];
        $html[] = $this->createHeader($data);
        $html[] = "<div class='body'>";
        foreach ($pdf_groups as $pdf_group) {
            $html[] = $this->createStateOwnerGroup($pdf_group);
        }
        $html[] = "</div>";
        $html = join(PHP_EOL, $html);
        $stylesheet = file_get_contents(join(DS, [
            ROOT,
            'plugins',
            'Dashboard',
            'webroot',
            'css',
            'pdf-styles.css'
        ]));

        

        try {
            $defaultConfig = (new ConfigVariables())->getDefaults();
            $fontDirs = $defaultConfig['fontDir'];
            $defaultFontConfig = (new FontVariables())->getDefaults();
            $fontData = $defaultFontConfig['fontdata'];

            $mpdf = new Mpdf([
                'fontDir' => array_merge($fontDirs, [
                    ROOT . '/plugins/Dashboard/webroot/fonts/Roboto',
                ]),
                'fontData' => $fontData + [
                    'Roboto' => [
                        'R' => 'Roboto-Regular.ttf',
                        'B' => 'Roboto-Bold.tff',
                        'L' => 'Roboto-Light.tff',
                        'T' => 'Roboto-Thin',
                    ]
                ],
                'default_font' => 'Roboto',
            ]);

            $mpdf->WriteHTML($stylesheet, HTMLParserMode::HEADER_CSS);
            $mpdf->WriteHTML($html, HTMLParserMode::HTML_BODY);
            return $mpdf;
        } catch (MpdfException $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            throw new QueueException('Could not run the task.');
        }
    }

    /**
     * Create the header for the PDF
     *
     * Includes Logo, title, and date range for which when the report was generated.
     *
     * @param array $data Data passed to the task.
     * Best to simply pass the array.
     * @return string An HTML string of the header to be included in the PDF
     */
    public function createHeader(array $data): string
    {
        $imagePath = Configure::read('Commissions.logo.path');
        $title = __("Commission Report");
        $pdf = TableRegistry::getTableLocator()->get('Pdfs')->get($data['pdf_id']);
        $date = sprintf('%s - %s', $pdf->startDate->format('j F Y'), $pdf->endDate->format('j F Y'));

        $html = "<header class='header'>";
        $html .= "<table class='container'>";
        $html .= "<tr>";
        $html .= "<td class='logo-container'>";
        $html .= "<img class='logo' src='$imagePath' alt='Heavens Best Logo'>";
        $html .= "</td>";
        $html .= "<td>";
        $html .= "<p class='header-title'>$title</p>";
        $html .= "<p class='header-date'>$date</p>";
        $html .= "</td>";
        $html .= "</tr>";
        $html .= "</table>";
        $html .= "</header>";
        return $html;
    }

    /**
     * State Owner Group Html String Generator
     *
     * Create a html string that contains:
     *  1. Title (State Owner name and Commission Amount)
     *  2. Orders Table
     *
     * @param \App\Model\Entity\PdfGroup $pdf_group Group entity with order data and State Owner Reference.
     * @return string An HTML string to be added to the PDF.
     */
    public function createStateOwnerGroup(PdfGroup $pdf_group): string
    {
        $pdf_meta_table = TableRegistry::getTableLocator()->get('PdfMeta');
        $pdf_meta = $pdf_meta_table->find()->where(['pdf_group_id' => $pdf_group->id]);

        $state_owner = TableRegistry::getTableLocator()->get('StateOwners')->get($pdf_group->state_owner_id);
        $raw_orders = [];
        $commission = 0.00;
        /** @var \App\Model\Entity\PdfMetum $item */
        foreach ($pdf_meta as $item) {
            $order = json_decode($item->value, true);
            $commission += $order['commission'];
            $raw_orders[] = $order;
        }
        $commission = $this->currency($commission, 'USD');

        $order_collection = new Collection($raw_orders);
        $orders = $order_collection->sortBy(function ($order) {
            return $order['date'];
        }, SORT_ASC, SORT_STRING);

        $headers = ['date', 'order', 'name', 'total', 'commission'];

        $html = [];
        $html[] = "<div class='state-owner-group'>";
        $html[] = sprintf('<p class="title">%s - %s</p>', $state_owner->state_owner_first_name . " " . $state_owner->state_owner_last_name, $commission);
        $html[] = "<table>";
        $html[] = "<tr>";
        foreach ($headers as $header) {
            $html[] = sprintf("<th class='%s'>%s</th>", $header, ucfirst($header));
        }
        $html[] = "</tr>";
        $row = 0;
        foreach ($orders as $order) {
            if ($row % 2 === 0) {
                $html[] = "<tr class='data-row'>";
            } else {
                $html[] = "<tr class='data-row gray'>";
            }
            $row++;
            foreach ($order as $key => $value) {
                if ($key === 'total' || $key === 'commission') {
                    $html[] = sprintf("<td class='%s'>%s</td>", $key, $this->currency($value, 'USD'));
                } else {
                    $html[] = sprintf("<td class='%s'>%s</td>", $key, $value);
                }

            }
            $html[] = "</tr>";
        }
        $html[] = "</table>";
        $html[] = "</div>";

        return join(PHP_EOL, $html);
    }
    
    public function sendMail(array $data): void
    {
    //   $mailer = new CommissionReportMailer($data);
    //   $mailer->deliver();
    }
    
}
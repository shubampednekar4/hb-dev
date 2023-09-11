<?php
declare(strict_types=1);

namespace App\Controller\Component;

use App\Dto\WooCommerce\AddressDto;
use App\Dto\WooCommerce\LineItemDto;
use App\Dto\WooCommerce\OrderDto;
use App\Dto\WooCommerce\ShippingLineDto;
use App\Dto\WooCommerce\TaxDto;
use App\Dto\WooCommerce\TaxLineDto;
use App\Model\Entity\Operator;
use App\Model\Entity\State;
use App\Model\Entity\StateOwner;
use App\Model\Entity\User;
use Automattic\WooCommerce\Client;
use Cake\Collection\Collection;
use Cake\Controller\Component;
use Cake\Core\Configure;
use Cake\Core\Exception\CakeException;
use Cake\Http\Exception\NotFoundException;
use Cake\I18n\FrozenDate;
use Cake\I18n\FrozenTime;
use Cake\Log\Log;
use Cake\ORM\TableRegistry;
use GuzzleHttp\Client as GClient;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Woocommerce component
 *
 * @property \Automattic\WooCommerce\Client $client
 * @property array $terms
 */
class WoocommerceComponent extends Component
{
    /**
     * Commission Identifier
     */
    protected const ATTR_COMMISSION = 'Commission Category';
    /**
     * Rate value
     */
    protected const DEFAULT_RATE = '0.0';
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    /**
     * @param array $config
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->client = new Client(
            Configure::read('WooCommerce.uri'),
            Configure::read('WooCommerce.consumer_key'),
            Configure::read('WooCommerce.consumer_secret'),
            [
                'version' => Configure::read('WooCommerce.api_version'),
            ]
        );
        $this->terms = $this->getTerms();
    }

    /**
     * @return array
     */
    public function getTerms()
    {
        return $this->client->get('products/attributes/1/terms');
    }

    /**
     * Get all products.
     *
     * @param array $options
     * @return array
     */
    public function getAllProducts(array $options = []): array
    {
        return $this->client->get('products', $options);
    }

    /**
     * Create a customer on the system.
     *
     * @param array $data
     * @return mixed
     */
    public function createCustomer(array $data)
    {
        return $this->client->post('customers', $data);
    }

    /**
     * @param $customer_id
     * @return array|\stdClass
     */
    public function removeCustomer($customer_id)
    {
        return $this->client->delete("customers/$customer_id", ['force' => true]);
    }

    /**
     * Check to make sure the body is a match on the signature
     *
     * @param string|string[] $signature value of the signature being sent
     * @param string $body Body of the request from the webhook.
     * @return bool Result of the check if the hashed value of the body matches the signature.
     */
    public function validateSignature($signature, string $body): bool
    {
        $hash = hash_hmac('sha256', $body, Configure::read('WooCommerce.webhook.secret'), true);
        $result = base64_encode($hash);

        return $signature === $result;
    }

    /**
     * @param $orderItems
     * @return \Cake\Collection\Collection
     */
    public function getCommissions($orderItems): Collection
    {
        $commissions = [];
        foreach ($orderItems as $item) {
            $commissions[] = $this->computeCommission($item);
        }

        return new Collection($commissions);
    }

    /**
     * Get a list item's commission amount.
     *
     * @param array $item Line item on an order to be evaluated
     * @return float Commission from the line item.
     */
    public function computeCommission(array $item): float
    {
        $product = $this->client->get("products/$item[product_id]");
        $rate = self::DEFAULT_RATE;
        foreach ($product->attributes as $attribute) {
            if ($attribute->name === self::ATTR_COMMISSION) {
                foreach ($this->terms as $term) {
                    if ($attribute->options[0] === $term->name) {
                        $rate_obj = TableRegistry::getTableLocator()
                            ->get('Rates')
                            ->find()
                            ->where(['term_id' => $term->id])
                            ->first();
                        $rate = $rate_obj->rate_amount;
                        break;
                    }
                }
            }
            if ($rate !== self::DEFAULT_RATE) {
                break;
            }
        }

        return $item['quantity'] * $item['price'] * $rate;
    }

    /**
     * @param \Cake\I18n\FrozenTime $start_date
     * @param \Cake\I18n\FrozenTime $end_date
     * @return \App\Dto\WooCommerce\OrderDto[]
     */
    public function filterOrders(FrozenTime $start_date, FrozenTime $end_date): array
    {
        $end_date = $end_date->addHours(23);
        $end_date = $end_date->addMinutes(59);
        $end_date = $end_date->addSeconds(59);
        $pages = $this->filterOrderPages($start_date, $end_date);
        $order_data = [];
        for ($page_number = 1; $page_number <= $pages; $page_number++) {
            $raw_orders = $this->client->get('orders', [
                'after' => $start_date->toAtomString(),
                'before' => $end_date->toAtomString(),
                'page' => $page_number,
                'status' => ['completed', 'on-hold'],
            ]);
            foreach ($raw_orders as $raw_order) {
                $order_data[] = $this->processOrder($raw_order);
            }
        }

        return array_unique($order_data);
    }

    /**
     * @param \Cake\I18n\FrozenTime $start_date
     * @param \Cake\I18n\FrozenTime $end_date
     * @return int
     */
    public function filterOrderPages(FrozenTime $start_date, FrozenTime $end_date): int
    {
        $gClient = new GClient(['base_uri' => Configure::read('WooCommerce.uri')]);
        $page_limit = 10;
        try {
            $response = $gClient->request('GET', Configure::read('WooCommerce.endpoints.orders'), [
                'headers' => [
                    'Authorization' => 'Basic ' . base64_encode(Configure::read('WooCommerce.consumer_key') . ':' . Configure::read('WooCommerce.consumer_secret')),
                ],
                'query' => [
                    'per_page' => $page_limit,
                    'after' => $start_date->toIso8601String(),
                    'before' => $end_date->toIso8601String(),
                    'status' => ['completed', 'on-hold'],
                ],
                'verify' => false,
            ]);

            return intval($response->getHeader('X-WP-TotalPages')[0]);
        } catch (GuzzleException $e) {
            Log::error('Could not get total pages: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            throw new CakeException('filterCommissions failed due to WooCommerce issue, see log for more details.');
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
            'sku' => $line_item->sku?$line_item->sku: '',
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
     * @param array $commissions
     * @return float
     */
    public function totalCommissions(array $commissions): float
    {
        return 0.0;
    }

    /**
     * Make sure the status is a completed status.
     *
     * @param string $status
     * @return bool
     */
    public function isOrderCompleted(string $status): bool
    {
        return $status === 'completed';
    }

    /**
     * Order State Owner Fetcher
     *
     * Get The state owner associated with the order.
     * Errors out if any one of the steps finds that the entity doesn't match the expected type or if the there is no
     * returned result.
     * Requires you to fetch the `customer_id` from the order. Typically this is done at the controller level.
     * This can be accomplished by issuing the statement `$this->request()->getData('customer_id');`.
     * Follows the following logic:
     *  1. Fetch the correct `operator`.
     *  2. Fetch the correct `state` and verify the result is present.
     *  3. Fetch the correct `stateOwner` and verify the result is present.
     *  4. Send the state owner back to the calling statement.
     *
     * @param int|string $customer_id Customer ID from the order.
     * See description for how to obtain this.
     * @return \App\Model\Entity\StateOwner State owner entity associated with the order.
     */
    public function getStateOwner($customer_id): StateOwner
    {
        // Step 1: Get the correct operator.
        $operator = $this->getOperator($customer_id);

        // Step 2a: Fetch the correct state.
        $state = TableRegistry::getTableLocator()
            ->get('States')
            ->get($operator->state_id);
        // Step 2b: Verify Result.
        if (!$state || !($state instanceof State)) {
            throw new NotFoundException("Could not find state entity with state id \"$operator->state_id\".");
        }

        // Step 3a: Fetch the correct state owner.
        $stateOwner = TableRegistry::getTableLocator()
            ->get('StateOwners')
            ->get($state->state_owner_id);
        // Step 3b: Verify Result.
        if (!$stateOwner || !($stateOwner instanceof StateOwner)) {
            throw new NotFoundException("Could not find state owner entity with state owner id \"$state->state_owner_id\".");
        }

        // Step 4: Send the state owner back to the calling statement.
        return $stateOwner;
    }

    /**
     * @param $customer_id
     * @return \App\Model\Entity\Operator|\Cake\Datasource\EntityInterface
     */
    public function getOperator($customer_id)
    {
        // Step 1a: Fetch the correct user.
        $user = TableRegistry::getTableLocator()
            ->get('Users')
            ->find()
            ->where(['customer_id' => $customer_id])
            ->first();
        // Step 1b: Verify Result.
        if (!$user || !($user instanceof User)) {
            throw new NotFoundException("Could not find a user entity with the customer id \"$customer_id\".");
        }

        // Step 2a: Fetch the correct operator.
        $operator = TableRegistry::getTableLocator()
            ->get('Operators')
            ->get($user->operator_id);
        // Step 2b: Verify Result.
        if (!$operator || !($operator instanceof Operator)) {
            throw new NotFoundException("Could not find an operator entity with operator id \"$user->operator_id\".");
        }

        return $operator;
    }

    /**
     * @param array $products
     * @return array
     */
    public function getLineItems(array $products): array
    {
        $result = [];
        foreach ($products as $product) {
            $product['commission'] = $this->computeCommission($product);
            $result[] = $product;
        }

        return $result;
    }

    /**
     * @param array $line_items
     * @return float
     */
    public function getCommission(array $line_items): float
    {
        $total = 0.00;
        foreach ($line_items as $line_item) {
            $total += $line_item['commission'];
        }

        return $total;
    }

    public function getOrder($number)
    {
        return $this->client->get("orders/$number");
    }

    public function filterByCompleted(FrozenDate $completed)
    {
        return $this->client->get('orders', [
            'filter' => [
                'ended' => $completed->toIso8601String()
            ]
        ]);
    }

    /**
     * Check if there is already a customer with the given information in the database.
     * Will not work if the role of the user is not `customer`.
     *
     * @param array $customerData Customer data to check.
     * @return bool True if the customer exists, false otherwise.
     */
    public function noConflicts(array $customerData): bool
    {
        $emailResult = $this->client->get('customers', [
            'email' => $customerData['email']
        ]);

        if (!empty($emailResult)) {
            return false;
        }
        return true;
    }

    public function removeUser(int $customer_id)
    {
        return $this->client->delete("customers/$customer_id", ['force' => true]);
    }
}

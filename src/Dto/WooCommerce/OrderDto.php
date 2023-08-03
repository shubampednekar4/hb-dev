<?php
declare(strict_types=1);

/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace App\Dto\WooCommerce;

/**
 * WooCommerce/Order DTO
 *
 * @property int $id
 * @property string $status
 * @property string $currency
 * @property string $version
 * @property bool $pricesIncludeTax
 * @property \Cake\I18n\FrozenTime $dateCreated
 * @property \Cake\I18n\FrozenTime $dateModified
 * @property float $discountTotal
 * @property float $shippingTotal
 * @property float $cartTax
 * @property float $total
 * @property int $customerId
 * @property string $orderKey
 * @property \App\Dto\WooCommerce\AddressDto $billing
 * @property \App\Dto\WooCommerce\AddressDto $shipping
 * @property string $paymentMethod
 * @property string $paymentMethodTitle
 * @property string $transactionId
 * @property string $customerIpAddress
 * @property string $customerUserAgent
 * @property string $createdVia
 * @property string $customerNote
 * @property \Cake\I18n\FrozenTime $dateCompleted
 * @property \Cake\I18n\FrozenTime $datePaid
 * @property string $cartHash
 * @property string $number
 * @property \App\Dto\WooCommerce\LineItemDto[] $lineItems
 * @property \App\Dto\WooCommerce\TaxLineDto[] $taxLines
 * @property \App\Dto\WooCommerce\ShippingLineDto[] $shippingLines
 * @property array $feeLines
 * @property array $couponLines
 * @property array $refunds
 */
class OrderDto extends \CakeDto\Dto\AbstractDto
{
    public const FIELD_ID = 'id';
    public const FIELD_STATUS = 'status';
    public const FIELD_CURRENCY = 'currency';
    public const FIELD_VERSION = 'version';
    public const FIELD_PRICES_INCLUDE_TAX = 'pricesIncludeTax';
    public const FIELD_DATE_CREATED = 'dateCreated';
    public const FIELD_DATE_MODIFIED = 'dateModified';
    public const FIELD_DISCOUNT_TOTAL = 'discountTotal';
    public const FIELD_SHIPPING_TOTAL = 'shippingTotal';
    public const FIELD_CART_TAX = 'cartTax';
    public const FIELD_TOTAL = 'total';
    public const FIELD_CUSTOMER_ID = 'customerId';
    public const FIELD_ORDER_KEY = 'orderKey';
    public const FIELD_BILLING = 'billing';
    public const FIELD_SHIPPING = 'shipping';
    public const FIELD_PAYMENT_METHOD = 'paymentMethod';
    public const FIELD_PAYMENT_METHOD_TITLE = 'paymentMethodTitle';
    public const FIELD_TRANSACTION_ID = 'transactionId';
    public const FIELD_CUSTOMER_IP_ADDRESS = 'customerIpAddress';
    public const FIELD_CUSTOMER_USER_AGENT = 'customerUserAgent';
    public const FIELD_CREATED_VIA = 'createdVia';
    public const FIELD_CUSTOMER_NOTE = 'customerNote';
    public const FIELD_DATE_COMPLETED = 'dateCompleted';
    public const FIELD_DATE_PAID = 'datePaid';
    public const FIELD_CART_HASH = 'cartHash';
    public const FIELD_NUMBER = 'number';
    public const FIELD_LINE_ITEMS = 'lineItems';
    public const FIELD_TAX_LINES = 'taxLines';
    public const FIELD_SHIPPING_LINES = 'shippingLines';
    public const FIELD_FEE_LINES = 'feeLines';
    public const FIELD_COUPON_LINES = 'couponLines';
    public const FIELD_REFUNDS = 'refunds';

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var string
     */
    protected $currency;

    /**
     * @var string
     */
    protected $version;

    /**
     * @var bool
     */
    protected $pricesIncludeTax;

    /**
     * @var \Cake\I18n\FrozenTime
     */
    protected $dateCreated;

    /**
     * @var \Cake\I18n\FrozenTime
     */
    protected $dateModified;

    /**
     * @var float
     */
    protected $discountTotal;

    /**
     * @var float
     */
    protected $shippingTotal;

    /**
     * @var float
     */
    protected $cartTax;

    /**
     * @var float
     */
    protected $total;

    /**
     * @var int
     */
    protected $customerId;

    /**
     * @var string
     */
    protected $orderKey;

    /**
     * @var \App\Dto\WooCommerce\AddressDto
     */
    protected $billing;

    /**
     * @var \App\Dto\WooCommerce\AddressDto
     */
    protected $shipping;

    /**
     * @var string
     */
    protected $paymentMethod;

    /**
     * @var string
     */
    protected $paymentMethodTitle;

    /**
     * @var string
     */
    protected $transactionId;

    /**
     * @var string
     */
    protected $customerIpAddress;

    /**
     * @var string
     */
    protected $customerUserAgent;

    /**
     * @var string
     */
    protected $createdVia;

    /**
     * @var string
     */
    protected $customerNote;

    /**
     * @var \Cake\I18n\FrozenTime
     */
    protected $dateCompleted;

    /**
     * @var \Cake\I18n\FrozenTime
     */
    protected $datePaid;

    /**
     * @var string
     */
    protected $cartHash;

    /**
     * @var string
     */
    protected $number;

    /**
     * @var \App\Dto\WooCommerce\LineItemDto[]
     */
    protected $lineItems;

    /**
     * @var \App\Dto\WooCommerce\TaxLineDto[]
     */
    protected $taxLines;

    /**
     * @var \App\Dto\WooCommerce\ShippingLineDto[]
     */
    protected $shippingLines;

    /**
     * @var array
     */
    protected $feeLines;

    /**
     * @var array
     */
    protected $couponLines;

    /**
     * @var array
     */
    protected $refunds;

    /**
     * Some data is only for debugging for now.
     *
     * @var array
     */
    protected $_metadata = [
        'id' => [
            'name' => 'id',
            'type' => 'int',
            'required' => true,
            'defaultValue' => null,
            'dto' => null,
            'collectionType' => null,
            'associative' => false,
            'key' => null,
            'serialize' => null,
            'factory' => null,
        ],
        'status' => [
            'name' => 'status',
            'type' => 'string',
            'required' => true,
            'defaultValue' => null,
            'dto' => null,
            'collectionType' => null,
            'associative' => false,
            'key' => null,
            'serialize' => null,
            'factory' => null,
        ],
        'currency' => [
            'name' => 'currency',
            'type' => 'string',
            'required' => true,
            'defaultValue' => 'USD',
            'dto' => null,
            'collectionType' => null,
            'associative' => false,
            'key' => null,
            'serialize' => null,
            'factory' => null,
        ],
        'version' => [
            'name' => 'version',
            'type' => 'string',
            'required' => true,
            'defaultValue' => null,
            'dto' => null,
            'collectionType' => null,
            'associative' => false,
            'key' => null,
            'serialize' => null,
            'factory' => null,
        ],
        'pricesIncludeTax' => [
            'name' => 'pricesIncludeTax',
            'type' => 'bool',
            'required' => true,
            'defaultValue' => null,
            'dto' => null,
            'collectionType' => null,
            'associative' => false,
            'key' => null,
            'serialize' => null,
            'factory' => null,
        ],
        'dateCreated' => [
            'name' => 'dateCreated',
            'type' => '\Cake\I18n\FrozenTime',
            'required' => true,
            'defaultValue' => null,
            'dto' => null,
            'collectionType' => null,
            'associative' => false,
            'key' => null,
            'serialize' => null,
            'factory' => null,
            'isClass' => true,
        ],
        'dateModified' => [
            'name' => 'dateModified',
            'type' => '\Cake\I18n\FrozenTime',
            'required' => true,
            'defaultValue' => null,
            'dto' => null,
            'collectionType' => null,
            'associative' => false,
            'key' => null,
            'serialize' => null,
            'factory' => null,
            'isClass' => true,
        ],
        'discountTotal' => [
            'name' => 'discountTotal',
            'type' => 'float',
            'required' => true,
            'defaultValue' => null,
            'dto' => null,
            'collectionType' => null,
            'associative' => false,
            'key' => null,
            'serialize' => null,
            'factory' => null,
        ],
        'shippingTotal' => [
            'name' => 'shippingTotal',
            'type' => 'float',
            'required' => true,
            'defaultValue' => null,
            'dto' => null,
            'collectionType' => null,
            'associative' => false,
            'key' => null,
            'serialize' => null,
            'factory' => null,
        ],
        'cartTax' => [
            'name' => 'cartTax',
            'type' => 'float',
            'required' => true,
            'defaultValue' => null,
            'dto' => null,
            'collectionType' => null,
            'associative' => false,
            'key' => null,
            'serialize' => null,
            'factory' => null,
        ],
        'total' => [
            'name' => 'total',
            'type' => 'float',
            'required' => true,
            'defaultValue' => null,
            'dto' => null,
            'collectionType' => null,
            'associative' => false,
            'key' => null,
            'serialize' => null,
            'factory' => null,
        ],
        'customerId' => [
            'name' => 'customerId',
            'type' => 'int',
            'required' => true,
            'defaultValue' => null,
            'dto' => null,
            'collectionType' => null,
            'associative' => false,
            'key' => null,
            'serialize' => null,
            'factory' => null,
        ],
        'orderKey' => [
            'name' => 'orderKey',
            'type' => 'string',
            'required' => true,
            'defaultValue' => null,
            'dto' => null,
            'collectionType' => null,
            'associative' => false,
            'key' => null,
            'serialize' => null,
            'factory' => null,
        ],
        'billing' => [
            'name' => 'billing',
            'type' => '\App\Dto\WooCommerce\AddressDto',
            'required' => true,
            'defaultValue' => null,
            'dto' => 'WooCommerce/Address',
            'collectionType' => null,
            'associative' => false,
            'key' => null,
            'serialize' => null,
            'factory' => null,
        ],
        'shipping' => [
            'name' => 'shipping',
            'type' => '\App\Dto\WooCommerce\AddressDto',
            'required' => true,
            'defaultValue' => null,
            'dto' => 'WooCommerce/Address',
            'collectionType' => null,
            'associative' => false,
            'key' => null,
            'serialize' => null,
            'factory' => null,
        ],
        'paymentMethod' => [
            'name' => 'paymentMethod',
            'type' => 'string',
            'required' => true,
            'defaultValue' => null,
            'dto' => null,
            'collectionType' => null,
            'associative' => false,
            'key' => null,
            'serialize' => null,
            'factory' => null,
        ],
        'paymentMethodTitle' => [
            'name' => 'paymentMethodTitle',
            'type' => 'string',
            'required' => true,
            'defaultValue' => null,
            'dto' => null,
            'collectionType' => null,
            'associative' => false,
            'key' => null,
            'serialize' => null,
            'factory' => null,
        ],
        'transactionId' => [
            'name' => 'transactionId',
            'type' => 'string',
            'required' => true,
            'defaultValue' => null,
            'dto' => null,
            'collectionType' => null,
            'associative' => false,
            'key' => null,
            'serialize' => null,
            'factory' => null,
        ],
        'customerIpAddress' => [
            'name' => 'customerIpAddress',
            'type' => 'string',
            'required' => true,
            'defaultValue' => null,
            'dto' => null,
            'collectionType' => null,
            'associative' => false,
            'key' => null,
            'serialize' => null,
            'factory' => null,
        ],
        'customerUserAgent' => [
            'name' => 'customerUserAgent',
            'type' => 'string',
            'required' => true,
            'defaultValue' => null,
            'dto' => null,
            'collectionType' => null,
            'associative' => false,
            'key' => null,
            'serialize' => null,
            'factory' => null,
        ],
        'createdVia' => [
            'name' => 'createdVia',
            'type' => 'string',
            'required' => true,
            'defaultValue' => null,
            'dto' => null,
            'collectionType' => null,
            'associative' => false,
            'key' => null,
            'serialize' => null,
            'factory' => null,
        ],
        'customerNote' => [
            'name' => 'customerNote',
            'type' => 'string',
            'required' => true,
            'defaultValue' => null,
            'dto' => null,
            'collectionType' => null,
            'associative' => false,
            'key' => null,
            'serialize' => null,
            'factory' => null,
        ],
        'dateCompleted' => [
            'name' => 'dateCompleted',
            'type' => '\Cake\I18n\FrozenTime',
            'required' => true,
            'defaultValue' => null,
            'dto' => null,
            'collectionType' => null,
            'associative' => false,
            'key' => null,
            'serialize' => null,
            'factory' => null,
            'isClass' => true,
        ],
        'datePaid' => [
            'name' => 'datePaid',
            'type' => '\Cake\I18n\FrozenTime',
            'required' => true,
            'defaultValue' => null,
            'dto' => null,
            'collectionType' => null,
            'associative' => false,
            'key' => null,
            'serialize' => null,
            'factory' => null,
            'isClass' => true,
        ],
        'cartHash' => [
            'name' => 'cartHash',
            'type' => 'string',
            'required' => true,
            'defaultValue' => null,
            'dto' => null,
            'collectionType' => null,
            'associative' => false,
            'key' => null,
            'serialize' => null,
            'factory' => null,
        ],
        'number' => [
            'name' => 'number',
            'type' => 'string',
            'required' => true,
            'defaultValue' => null,
            'dto' => null,
            'collectionType' => null,
            'associative' => false,
            'key' => null,
            'serialize' => null,
            'factory' => null,
        ],
        'lineItems' => [
            'name' => 'lineItems',
            'type' => '\App\Dto\WooCommerce\LineItemDto[]',
            'required' => true,
            'defaultValue' => null,
            'dto' => null,
            'collectionType' => null,
            'associative' => false,
            'key' => null,
            'serialize' => null,
            'factory' => null,
        ],
        'taxLines' => [
            'name' => 'taxLines',
            'type' => '\App\Dto\WooCommerce\TaxLineDto[]',
            'required' => true,
            'defaultValue' => null,
            'dto' => null,
            'collectionType' => null,
            'associative' => false,
            'key' => null,
            'serialize' => null,
            'factory' => null,
        ],
        'shippingLines' => [
            'name' => 'shippingLines',
            'type' => '\App\Dto\WooCommerce\ShippingLineDto[]',
            'required' => true,
            'defaultValue' => null,
            'dto' => null,
            'collectionType' => null,
            'associative' => false,
            'key' => null,
            'serialize' => null,
            'factory' => null,
        ],
        'feeLines' => [
            'name' => 'feeLines',
            'type' => 'array',
            'required' => true,
            'defaultValue' => null,
            'dto' => null,
            'collectionType' => null,
            'associative' => false,
            'key' => null,
            'serialize' => null,
            'factory' => null,
        ],
        'couponLines' => [
            'name' => 'couponLines',
            'type' => 'array',
            'required' => true,
            'defaultValue' => null,
            'dto' => null,
            'collectionType' => null,
            'associative' => false,
            'key' => null,
            'serialize' => null,
            'factory' => null,
        ],
        'refunds' => [
            'name' => 'refunds',
            'type' => 'array',
            'required' => true,
            'defaultValue' => null,
            'dto' => null,
            'collectionType' => null,
            'associative' => false,
            'key' => null,
            'serialize' => null,
            'factory' => null,
        ],
    ];

    /**
     * @var array
     */
    protected $_keyMap = [
        'underscored' => [
            'id' => 'id',
            'status' => 'status',
            'currency' => 'currency',
            'version' => 'version',
            'prices_include_tax' => 'pricesIncludeTax',
            'date_created' => 'dateCreated',
            'date_modified' => 'dateModified',
            'discount_total' => 'discountTotal',
            'shipping_total' => 'shippingTotal',
            'cart_tax' => 'cartTax',
            'total' => 'total',
            'customer_id' => 'customerId',
            'order_key' => 'orderKey',
            'billing' => 'billing',
            'shipping' => 'shipping',
            'payment_method' => 'paymentMethod',
            'payment_method_title' => 'paymentMethodTitle',
            'transaction_id' => 'transactionId',
            'customer_ip_address' => 'customerIpAddress',
            'customer_user_agent' => 'customerUserAgent',
            'created_via' => 'createdVia',
            'customer_note' => 'customerNote',
            'date_completed' => 'dateCompleted',
            'date_paid' => 'datePaid',
            'cart_hash' => 'cartHash',
            'number' => 'number',
            'line_items' => 'lineItems',
            'tax_lines' => 'taxLines',
            'shipping_lines' => 'shippingLines',
            'fee_lines' => 'feeLines',
            'coupon_lines' => 'couponLines',
            'refunds' => 'refunds',
        ],
        'dashed' => [
            'id' => 'id',
            'status' => 'status',
            'currency' => 'currency',
            'version' => 'version',
            'prices-include-tax' => 'pricesIncludeTax',
            'date-created' => 'dateCreated',
            'date-modified' => 'dateModified',
            'discount-total' => 'discountTotal',
            'shipping-total' => 'shippingTotal',
            'cart-tax' => 'cartTax',
            'total' => 'total',
            'customer-id' => 'customerId',
            'order-key' => 'orderKey',
            'billing' => 'billing',
            'shipping' => 'shipping',
            'payment-method' => 'paymentMethod',
            'payment-method-title' => 'paymentMethodTitle',
            'transaction-id' => 'transactionId',
            'customer-ip-address' => 'customerIpAddress',
            'customer-user-agent' => 'customerUserAgent',
            'created-via' => 'createdVia',
            'customer-note' => 'customerNote',
            'date-completed' => 'dateCompleted',
            'date-paid' => 'datePaid',
            'cart-hash' => 'cartHash',
            'number' => 'number',
            'line-items' => 'lineItems',
            'tax-lines' => 'taxLines',
            'shipping-lines' => 'shippingLines',
            'fee-lines' => 'feeLines',
            'coupon-lines' => 'couponLines',
            'refunds' => 'refunds',
        ],
    ];

    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id)
    {
        $this->id = $id;
        $this->_touchedFields[self::FIELD_ID] = true;

        return $this;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function hasId(): bool
    {
        return $this->id !== null;
    }

    /**
     * @param string $status
     * @return $this
     */
    public function setStatus(string $status)
    {
        $this->status = $status;
        $this->_touchedFields[self::FIELD_STATUS] = true;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return bool
     */
    public function hasStatus(): bool
    {
        return $this->status !== null;
    }

    /**
     * @param string $currency
     * @return $this
     */
    public function setCurrency(string $currency)
    {
        $this->currency = $currency;
        $this->_touchedFields[self::FIELD_CURRENCY] = true;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $version
     * @return $this
     */
    public function setVersion(string $version)
    {
        $this->version = $version;
        $this->_touchedFields[self::FIELD_VERSION] = true;

        return $this;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @return bool
     */
    public function hasVersion(): bool
    {
        return $this->version !== null;
    }

    /**
     * @param bool $pricesIncludeTax
     * @return $this
     */
    public function setPricesIncludeTax(bool $pricesIncludeTax)
    {
        $this->pricesIncludeTax = $pricesIncludeTax;
        $this->_touchedFields[self::FIELD_PRICES_INCLUDE_TAX] = true;

        return $this;
    }

    /**
     * @return bool
     */
    public function getPricesIncludeTax(): bool
    {
        return $this->pricesIncludeTax;
    }

    /**
     * @return bool
     */
    public function hasPricesIncludeTax(): bool
    {
        return $this->pricesIncludeTax !== null;
    }

    /**
     * @param \Cake\I18n\FrozenTime $dateCreated
     * @return $this
     */
    public function setDateCreated(\Cake\I18n\FrozenTime $dateCreated)
    {
        $this->dateCreated = $dateCreated;
        $this->_touchedFields[self::FIELD_DATE_CREATED] = true;

        return $this;
    }

    /**
     * @return \Cake\I18n\FrozenTime
     */
    public function getDateCreated(): \Cake\I18n\FrozenTime
    {
        return $this->dateCreated;
    }

    /**
     * @return bool
     */
    public function hasDateCreated(): bool
    {
        return $this->dateCreated !== null;
    }

    /**
     * @param \Cake\I18n\FrozenTime $dateModified
     * @return $this
     */
    public function setDateModified(\Cake\I18n\FrozenTime $dateModified)
    {
        $this->dateModified = $dateModified;
        $this->_touchedFields[self::FIELD_DATE_MODIFIED] = true;

        return $this;
    }

    /**
     * @return \Cake\I18n\FrozenTime
     */
    public function getDateModified(): \Cake\I18n\FrozenTime
    {
        return $this->dateModified;
    }

    /**
     * @return bool
     */
    public function hasDateModified(): bool
    {
        return $this->dateModified !== null;
    }

    /**
     * @param float $discountTotal
     * @return $this
     */
    public function setDiscountTotal(float $discountTotal)
    {
        $this->discountTotal = $discountTotal;
        $this->_touchedFields[self::FIELD_DISCOUNT_TOTAL] = true;

        return $this;
    }

    /**
     * @return float
     */
    public function getDiscountTotal(): float
    {
        return $this->discountTotal;
    }

    /**
     * @return bool
     */
    public function hasDiscountTotal(): bool
    {
        return $this->discountTotal !== null;
    }

    /**
     * @param float $shippingTotal
     * @return $this
     */
    public function setShippingTotal(float $shippingTotal)
    {
        $this->shippingTotal = $shippingTotal;
        $this->_touchedFields[self::FIELD_SHIPPING_TOTAL] = true;

        return $this;
    }

    /**
     * @return float
     */
    public function getShippingTotal(): float
    {
        return $this->shippingTotal;
    }

    /**
     * @return bool
     */
    public function hasShippingTotal(): bool
    {
        return $this->shippingTotal !== null;
    }

    /**
     * @param float $cartTax
     * @return $this
     */
    public function setCartTax(float $cartTax)
    {
        $this->cartTax = $cartTax;
        $this->_touchedFields[self::FIELD_CART_TAX] = true;

        return $this;
    }

    /**
     * @return float
     */
    public function getCartTax(): float
    {
        return $this->cartTax;
    }

    /**
     * @return bool
     */
    public function hasCartTax(): bool
    {
        return $this->cartTax !== null;
    }

    /**
     * @param float $total
     * @return $this
     */
    public function setTotal(float $total)
    {
        $this->total = $total;
        $this->_touchedFields[self::FIELD_TOTAL] = true;

        return $this;
    }

    /**
     * @return float
     */
    public function getTotal(): float
    {
        return $this->total;
    }

    /**
     * @return bool
     */
    public function hasTotal(): bool
    {
        return $this->total !== null;
    }

    /**
     * @param int $customerId
     * @return $this
     */
    public function setCustomerId(int $customerId)
    {
        $this->customerId = $customerId;
        $this->_touchedFields[self::FIELD_CUSTOMER_ID] = true;

        return $this;
    }

    /**
     * @return int
     */
    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    /**
     * @return bool
     */
    public function hasCustomerId(): bool
    {
        return $this->customerId !== null;
    }

    /**
     * @param string $orderKey
     * @return $this
     */
    public function setOrderKey(string $orderKey)
    {
        $this->orderKey = $orderKey;
        $this->_touchedFields[self::FIELD_ORDER_KEY] = true;

        return $this;
    }

    /**
     * @return string
     */
    public function getOrderKey(): string
    {
        return $this->orderKey;
    }

    /**
     * @return bool
     */
    public function hasOrderKey(): bool
    {
        return $this->orderKey !== null;
    }

    /**
     * @param \App\Dto\WooCommerce\AddressDto $billing
     * @return $this
     */
    public function setBilling(\App\Dto\WooCommerce\AddressDto $billing)
    {
        $this->billing = $billing;
        $this->_touchedFields[self::FIELD_BILLING] = true;

        return $this;
    }

    /**
     * @return \App\Dto\WooCommerce\AddressDto
     */
    public function getBilling(): \App\Dto\WooCommerce\AddressDto
    {
        return $this->billing;
    }

    /**
     * @return bool
     */
    public function hasBilling(): bool
    {
        return $this->billing !== null;
    }

    /**
     * @param \App\Dto\WooCommerce\AddressDto $shipping
     * @return $this
     */
    public function setShipping(\App\Dto\WooCommerce\AddressDto $shipping)
    {
        $this->shipping = $shipping;
        $this->_touchedFields[self::FIELD_SHIPPING] = true;

        return $this;
    }

    /**
     * @return \App\Dto\WooCommerce\AddressDto
     */
    public function getShipping(): \App\Dto\WooCommerce\AddressDto
    {
        return $this->shipping;
    }

    /**
     * @return bool
     */
    public function hasShipping(): bool
    {
        return $this->shipping !== null;
    }

    /**
     * @param string $paymentMethod
     * @return $this
     */
    public function setPaymentMethod(string $paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
        $this->_touchedFields[self::FIELD_PAYMENT_METHOD] = true;

        return $this;
    }

    /**
     * @return string
     */
    public function getPaymentMethod(): string
    {
        return $this->paymentMethod;
    }

    /**
     * @return bool
     */
    public function hasPaymentMethod(): bool
    {
        return $this->paymentMethod !== null;
    }

    /**
     * @param string $paymentMethodTitle
     * @return $this
     */
    public function setPaymentMethodTitle(string $paymentMethodTitle)
    {
        $this->paymentMethodTitle = $paymentMethodTitle;
        $this->_touchedFields[self::FIELD_PAYMENT_METHOD_TITLE] = true;

        return $this;
    }

    /**
     * @return string
     */
    public function getPaymentMethodTitle(): string
    {
        return $this->paymentMethodTitle;
    }

    /**
     * @return bool
     */
    public function hasPaymentMethodTitle(): bool
    {
        return $this->paymentMethodTitle !== null;
    }

    /**
     * @param string $transactionId
     * @return $this
     */
    public function setTransactionId(string $transactionId)
    {
        $this->transactionId = $transactionId;
        $this->_touchedFields[self::FIELD_TRANSACTION_ID] = true;

        return $this;
    }

    /**
     * @return string
     */
    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    /**
     * @return bool
     */
    public function hasTransactionId(): bool
    {
        return $this->transactionId !== null;
    }

    /**
     * @param string $customerIpAddress
     * @return $this
     */
    public function setCustomerIpAddress(string $customerIpAddress)
    {
        $this->customerIpAddress = $customerIpAddress;
        $this->_touchedFields[self::FIELD_CUSTOMER_IP_ADDRESS] = true;

        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerIpAddress(): string
    {
        return $this->customerIpAddress;
    }

    /**
     * @return bool
     */
    public function hasCustomerIpAddress(): bool
    {
        return $this->customerIpAddress !== null;
    }

    /**
     * @param string $customerUserAgent
     * @return $this
     */
    public function setCustomerUserAgent(string $customerUserAgent)
    {
        $this->customerUserAgent = $customerUserAgent;
        $this->_touchedFields[self::FIELD_CUSTOMER_USER_AGENT] = true;

        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerUserAgent(): string
    {
        return $this->customerUserAgent;
    }

    /**
     * @return bool
     */
    public function hasCustomerUserAgent(): bool
    {
        return $this->customerUserAgent !== null;
    }

    /**
     * @param string $createdVia
     * @return $this
     */
    public function setCreatedVia(string $createdVia)
    {
        $this->createdVia = $createdVia;
        $this->_touchedFields[self::FIELD_CREATED_VIA] = true;

        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedVia(): string
    {
        return $this->createdVia;
    }

    /**
     * @return bool
     */
    public function hasCreatedVia(): bool
    {
        return $this->createdVia !== null;
    }

    /**
     * @param string $customerNote
     * @return $this
     */
    public function setCustomerNote(string $customerNote)
    {
        $this->customerNote = $customerNote;
        $this->_touchedFields[self::FIELD_CUSTOMER_NOTE] = true;

        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerNote(): string
    {
        return $this->customerNote;
    }

    /**
     * @return bool
     */
    public function hasCustomerNote(): bool
    {
        return $this->customerNote !== null;
    }

    /**
     * @param \Cake\I18n\FrozenTime $dateCompleted
     * @return $this
     */
    public function setDateCompleted(\Cake\I18n\FrozenTime $dateCompleted)
    {
        $this->dateCompleted = $dateCompleted;
        $this->_touchedFields[self::FIELD_DATE_COMPLETED] = true;

        return $this;
    }

    /**
     * @return \Cake\I18n\FrozenTime
     */
    public function getDateCompleted(): \Cake\I18n\FrozenTime
    {
        return $this->dateCompleted;
    }

    /**
     * @return bool
     */
    public function hasDateCompleted(): bool
    {
        return $this->dateCompleted !== null;
    }

    /**
     * @param \Cake\I18n\FrozenTime $datePaid
     * @return $this
     */
    public function setDatePaid(\Cake\I18n\FrozenTime $datePaid)
    {
        $this->datePaid = $datePaid;
        $this->_touchedFields[self::FIELD_DATE_PAID] = true;

        return $this;
    }

    /**
     * @return \Cake\I18n\FrozenTime
     */
    public function getDatePaid(): \Cake\I18n\FrozenTime
    {
        return $this->datePaid;
    }

    /**
     * @return bool
     */
    public function hasDatePaid(): bool
    {
        return $this->datePaid !== null;
    }

    /**
     * @param string $cartHash
     * @return $this
     */
    public function setCartHash(string $cartHash)
    {
        $this->cartHash = $cartHash;
        $this->_touchedFields[self::FIELD_CART_HASH] = true;

        return $this;
    }

    /**
     * @return string
     */
    public function getCartHash(): string
    {
        return $this->cartHash;
    }

    /**
     * @return bool
     */
    public function hasCartHash(): bool
    {
        return $this->cartHash !== null;
    }

    /**
     * @param string $number
     * @return $this
     */
    public function setNumber(string $number)
    {
        $this->number = $number;
        $this->_touchedFields[self::FIELD_NUMBER] = true;

        return $this;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @return bool
     */
    public function hasNumber(): bool
    {
        return $this->number !== null;
    }

    /**
     * @param \App\Dto\WooCommerce\LineItemDto[] $lineItems
     * @return $this
     */
    public function setLineItems(array $lineItems)
    {
        $this->lineItems = $lineItems;
        $this->_touchedFields[self::FIELD_LINE_ITEMS] = true;

        return $this;
    }

    /**
     * @return \App\Dto\WooCommerce\LineItemDto[]
     */
    public function getLineItems(): array
    {
        return $this->lineItems;
    }

    /**
     * @return bool
     */
    public function hasLineItems(): bool
    {
        return $this->lineItems !== null;
    }

    /**
     * @param \App\Dto\WooCommerce\TaxLineDto[] $taxLines
     * @return $this
     */
    public function setTaxLines(array $taxLines)
    {
        $this->taxLines = $taxLines;
        $this->_touchedFields[self::FIELD_TAX_LINES] = true;

        return $this;
    }

    /**
     * @return \App\Dto\WooCommerce\TaxLineDto[]
     */
    public function getTaxLines(): array
    {
        return $this->taxLines;
    }

    /**
     * @return bool
     */
    public function hasTaxLines(): bool
    {
        return $this->taxLines !== null;
    }

    /**
     * @param \App\Dto\WooCommerce\ShippingLineDto[] $shippingLines
     * @return $this
     */
    public function setShippingLines(array $shippingLines)
    {
        $this->shippingLines = $shippingLines;
        $this->_touchedFields[self::FIELD_SHIPPING_LINES] = true;

        return $this;
    }

    /**
     * @return \App\Dto\WooCommerce\ShippingLineDto[]
     */
    public function getShippingLines(): array
    {
        return $this->shippingLines;
    }

    /**
     * @return bool
     */
    public function hasShippingLines(): bool
    {
        return $this->shippingLines !== null;
    }

    /**
     * @param array $feeLines
     * @return $this
     */
    public function setFeeLines(array $feeLines)
    {
        $this->feeLines = $feeLines;
        $this->_touchedFields[self::FIELD_FEE_LINES] = true;

        return $this;
    }

    /**
     * @return array
     */
    public function getFeeLines(): array
    {
        return $this->feeLines;
    }

    /**
     * @return bool
     */
    public function hasFeeLines(): bool
    {
        return $this->feeLines !== null;
    }

    /**
     * @param array $couponLines
     * @return $this
     */
    public function setCouponLines(array $couponLines)
    {
        $this->couponLines = $couponLines;
        $this->_touchedFields[self::FIELD_COUPON_LINES] = true;

        return $this;
    }

    /**
     * @return array
     */
    public function getCouponLines(): array
    {
        return $this->couponLines;
    }

    /**
     * @return bool
     */
    public function hasCouponLines(): bool
    {
        return $this->couponLines !== null;
    }

    /**
     * @param array $refunds
     * @return $this
     */
    public function setRefunds(array $refunds)
    {
        $this->refunds = $refunds;
        $this->_touchedFields[self::FIELD_REFUNDS] = true;

        return $this;
    }

    /**
     * @return array
     */
    public function getRefunds(): array
    {
        return $this->refunds;
    }

    /**
     * @return bool
     */
    public function hasRefunds(): bool
    {
        return $this->refunds !== null;
    }
}

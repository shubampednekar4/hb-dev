<?php
declare(strict_types=1);

/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace App\Dto\WooCommerce;

/**
 * WooCommerce/LineItem DTO
 *
 * @property int $id
 * @property string $name
 * @property int $productId
 * @property int $variationId
 * @property int $quantity
 * @property string $taxClass
 * @property float $subtotalTax
 * @property float $total
 * @property float $totalTax
 * @property \App\Dto\WooCommerce\TaxDto[] $taxes
 * @property string $sku
 * @property float $price
 */
class LineItemDto extends \CakeDto\Dto\AbstractDto
{
    public const FIELD_ID = 'id';
    public const FIELD_NAME = 'name';
    public const FIELD_PRODUCT_ID = 'productId';
    public const FIELD_VARIATION_ID = 'variationId';
    public const FIELD_QUANTITY = 'quantity';
    public const FIELD_TAX_CLASS = 'taxClass';
    public const FIELD_SUBTOTAL_TAX = 'subtotalTax';
    public const FIELD_TOTAL = 'total';
    public const FIELD_TOTAL_TAX = 'totalTax';
    public const FIELD_TAXES = 'taxes';
    public const FIELD_SKU = 'sku';
    public const FIELD_PRICE = 'price';

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $productId;

    /**
     * @var int
     */
    protected $variationId;

    /**
     * @var int
     */
    protected $quantity;

    /**
     * @var string
     */
    protected $taxClass;

    /**
     * @var float
     */
    protected $subtotalTax;

    /**
     * @var float
     */
    protected $total;

    /**
     * @var float
     */
    protected $totalTax;

    /**
     * @var \App\Dto\WooCommerce\TaxDto[]
     */
    protected $taxes;

    /**
     * @var string
     */
    protected $sku;

    /**
     * @var float
     */
    protected $price;

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
        'name' => [
            'name' => 'name',
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
        'productId' => [
            'name' => 'productId',
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
        'variationId' => [
            'name' => 'variationId',
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
        'quantity' => [
            'name' => 'quantity',
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
        'taxClass' => [
            'name' => 'taxClass',
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
        'subtotalTax' => [
            'name' => 'subtotalTax',
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
        'totalTax' => [
            'name' => 'totalTax',
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
        'taxes' => [
            'name' => 'taxes',
            'type' => '\App\Dto\WooCommerce\TaxDto[]',
            'required' => true,
            'defaultValue' => null,
            'dto' => null,
            'collectionType' => null,
            'associative' => false,
            'key' => null,
            'serialize' => null,
            'factory' => null,
        ],
        'sku' => [
            'name' => 'sku',
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
        'price' => [
            'name' => 'price',
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
    ];

    /**
     * @var array
     */
    protected $_keyMap = [
        'underscored' => [
            'id' => 'id',
            'name' => 'name',
            'product_id' => 'productId',
            'variation_id' => 'variationId',
            'quantity' => 'quantity',
            'tax_class' => 'taxClass',
            'subtotal_tax' => 'subtotalTax',
            'total' => 'total',
            'total_tax' => 'totalTax',
            'taxes' => 'taxes',
            'sku' => 'sku',
            'price' => 'price',
        ],
        'dashed' => [
            'id' => 'id',
            'name' => 'name',
            'product-id' => 'productId',
            'variation-id' => 'variationId',
            'quantity' => 'quantity',
            'tax-class' => 'taxClass',
            'subtotal-tax' => 'subtotalTax',
            'total' => 'total',
            'total-tax' => 'totalTax',
            'taxes' => 'taxes',
            'sku' => 'sku',
            'price' => 'price',
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
     * @param string $name
     * @return $this
     */
    public function setName(string $name)
    {
        $this->name = $name;
        $this->_touchedFields[self::FIELD_NAME] = true;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function hasName(): bool
    {
        return $this->name !== null;
    }

    /**
     * @param int $productId
     * @return $this
     */
    public function setProductId(int $productId)
    {
        $this->productId = $productId;
        $this->_touchedFields[self::FIELD_PRODUCT_ID] = true;

        return $this;
    }

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->productId;
    }

    /**
     * @return bool
     */
    public function hasProductId(): bool
    {
        return $this->productId !== null;
    }

    /**
     * @param int $variationId
     * @return $this
     */
    public function setVariationId(int $variationId)
    {
        $this->variationId = $variationId;
        $this->_touchedFields[self::FIELD_VARIATION_ID] = true;

        return $this;
    }

    /**
     * @return int
     */
    public function getVariationId(): int
    {
        return $this->variationId;
    }

    /**
     * @return bool
     */
    public function hasVariationId(): bool
    {
        return $this->variationId !== null;
    }

    /**
     * @param int $quantity
     * @return $this
     */
    public function setQuantity(int $quantity)
    {
        $this->quantity = $quantity;
        $this->_touchedFields[self::FIELD_QUANTITY] = true;

        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return bool
     */
    public function hasQuantity(): bool
    {
        return $this->quantity !== null;
    }

    /**
     * @param string $taxClass
     * @return $this
     */
    public function setTaxClass(string $taxClass)
    {
        $this->taxClass = $taxClass;
        $this->_touchedFields[self::FIELD_TAX_CLASS] = true;

        return $this;
    }

    /**
     * @return string
     */
    public function getTaxClass(): string
    {
        return $this->taxClass;
    }

    /**
     * @return bool
     */
    public function hasTaxClass(): bool
    {
        return $this->taxClass !== null;
    }

    /**
     * @param float $subtotalTax
     * @return $this
     */
    public function setSubtotalTax(float $subtotalTax)
    {
        $this->subtotalTax = $subtotalTax;
        $this->_touchedFields[self::FIELD_SUBTOTAL_TAX] = true;

        return $this;
    }

    /**
     * @return float
     */
    public function getSubtotalTax(): float
    {
        return $this->subtotalTax;
    }

    /**
     * @return bool
     */
    public function hasSubtotalTax(): bool
    {
        return $this->subtotalTax !== null;
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
     * @param float $totalTax
     * @return $this
     */
    public function setTotalTax(float $totalTax)
    {
        $this->totalTax = $totalTax;
        $this->_touchedFields[self::FIELD_TOTAL_TAX] = true;

        return $this;
    }

    /**
     * @return float
     */
    public function getTotalTax(): float
    {
        return $this->totalTax;
    }

    /**
     * @return bool
     */
    public function hasTotalTax(): bool
    {
        return $this->totalTax !== null;
    }

    /**
     * @param \App\Dto\WooCommerce\TaxDto[] $taxes
     * @return $this
     */
    public function setTaxes(array $taxes)
    {
        $this->taxes = $taxes;
        $this->_touchedFields[self::FIELD_TAXES] = true;

        return $this;
    }

    /**
     * @return \App\Dto\WooCommerce\TaxDto[]
     */
    public function getTaxes(): array
    {
        return $this->taxes;
    }

    /**
     * @return bool
     */
    public function hasTaxes(): bool
    {
        return $this->taxes !== null;
    }

    /**
     * @param string $sku
     * @return $this
     */
    public function setSku(string $sku)
    {
        $this->sku = $sku;
        $this->_touchedFields[self::FIELD_SKU] = true;

        return $this;
    }

    /**
     * @return string
     */
    public function getSku(): string
    {
        return $this->sku;
    }

    /**
     * @return bool
     */
    public function hasSku(): bool
    {
        return $this->sku !== null;
    }

    /**
     * @param float $price
     * @return $this
     */
    public function setPrice(float $price)
    {
        $this->price = $price;
        $this->_touchedFields[self::FIELD_PRICE] = true;

        return $this;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return bool
     */
    public function hasPrice(): bool
    {
        return $this->price !== null;
    }
}

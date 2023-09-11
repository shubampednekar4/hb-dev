<?php
declare(strict_types=1);

/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace App\Dto\WooCommerce;

/**
 * WooCommerce/TaxLine DTO
 *
 * @property int $id
 * @property string $rateCode
 * @property int $rateId
 * @property string $label
 * @property bool $compound
 * @property float $taxTotal
 * @property float $shippingTaxTotal
 */
class TaxLineDto extends \CakeDto\Dto\AbstractDto
{
    public const FIELD_ID = 'id';
    public const FIELD_RATE_CODE = 'rateCode';
    public const FIELD_RATE_ID = 'rateId';
    public const FIELD_LABEL = 'label';
    public const FIELD_COMPOUND = 'compound';
    public const FIELD_TAX_TOTAL = 'taxTotal';
    public const FIELD_SHIPPING_TAX_TOTAL = 'shippingTaxTotal';

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $rateCode;

    /**
     * @var int
     */
    protected $rateId;

    /**
     * @var string
     */
    protected $label;

    /**
     * @var bool
     */
    protected $compound;

    /**
     * @var float
     */
    protected $taxTotal;

    /**
     * @var float
     */
    protected $shippingTaxTotal;

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
        'rateCode' => [
            'name' => 'rateCode',
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
        'rateId' => [
            'name' => 'rateId',
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
        'label' => [
            'name' => 'label',
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
        'compound' => [
            'name' => 'compound',
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
        'taxTotal' => [
            'name' => 'taxTotal',
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
        'shippingTaxTotal' => [
            'name' => 'shippingTaxTotal',
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
            'rate_code' => 'rateCode',
            'rate_id' => 'rateId',
            'label' => 'label',
            'compound' => 'compound',
            'tax_total' => 'taxTotal',
            'shipping_tax_total' => 'shippingTaxTotal',
        ],
        'dashed' => [
            'id' => 'id',
            'rate-code' => 'rateCode',
            'rate-id' => 'rateId',
            'label' => 'label',
            'compound' => 'compound',
            'tax-total' => 'taxTotal',
            'shipping-tax-total' => 'shippingTaxTotal',
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
     * @param string $rateCode
     * @return $this
     */
    public function setRateCode(string $rateCode)
    {
        $this->rateCode = $rateCode;
        $this->_touchedFields[self::FIELD_RATE_CODE] = true;

        return $this;
    }

    /**
     * @return string
     */
    public function getRateCode(): string
    {
        return $this->rateCode;
    }

    /**
     * @return bool
     */
    public function hasRateCode(): bool
    {
        return $this->rateCode !== null;
    }

    /**
     * @param int $rateId
     * @return $this
     */
    public function setRateId(int $rateId)
    {
        $this->rateId = $rateId;
        $this->_touchedFields[self::FIELD_RATE_ID] = true;

        return $this;
    }

    /**
     * @return int
     */
    public function getRateId(): int
    {
        return $this->rateId;
    }

    /**
     * @return bool
     */
    public function hasRateId(): bool
    {
        return $this->rateId !== null;
    }

    /**
     * @param string $label
     * @return $this
     */
    public function setLabel(string $label)
    {
        $this->label = $label;
        $this->_touchedFields[self::FIELD_LABEL] = true;

        return $this;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @return bool
     */
    public function hasLabel(): bool
    {
        return $this->label !== null;
    }

    /**
     * @param bool $compound
     * @return $this
     */
    public function setCompound(bool $compound)
    {
        $this->compound = $compound;
        $this->_touchedFields[self::FIELD_COMPOUND] = true;

        return $this;
    }

    /**
     * @return bool
     */
    public function getCompound(): bool
    {
        return $this->compound;
    }

    /**
     * @return bool
     */
    public function hasCompound(): bool
    {
        return $this->compound !== null;
    }

    /**
     * @param float $taxTotal
     * @return $this
     */
    public function setTaxTotal(float $taxTotal)
    {
        $this->taxTotal = $taxTotal;
        $this->_touchedFields[self::FIELD_TAX_TOTAL] = true;

        return $this;
    }

    /**
     * @return float
     */
    public function getTaxTotal(): float
    {
        return $this->taxTotal;
    }

    /**
     * @return bool
     */
    public function hasTaxTotal(): bool
    {
        return $this->taxTotal !== null;
    }

    /**
     * @param float $shippingTaxTotal
     * @return $this
     */
    public function setShippingTaxTotal(float $shippingTaxTotal)
    {
        $this->shippingTaxTotal = $shippingTaxTotal;
        $this->_touchedFields[self::FIELD_SHIPPING_TAX_TOTAL] = true;

        return $this;
    }

    /**
     * @return float
     */
    public function getShippingTaxTotal(): float
    {
        return $this->shippingTaxTotal;
    }

    /**
     * @return bool
     */
    public function hasShippingTaxTotal(): bool
    {
        return $this->shippingTaxTotal !== null;
    }
}

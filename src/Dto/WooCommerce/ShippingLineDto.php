<?php
declare(strict_types=1);

/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace App\Dto\WooCommerce;

/**
 * WooCommerce/ShippingLine DTO
 *
 * @property int $id
 * @property string $methodTitle
 * @property string $methodId
 * @property float $total
 * @property float $totalTax
 * @property \App\Dto\WooCommerce\TaxDto[] $taxes
 */
class ShippingLineDto extends \CakeDto\Dto\AbstractDto
{
    public const FIELD_ID = 'id';
    public const FIELD_METHOD_TITLE = 'methodTitle';
    public const FIELD_METHOD_ID = 'methodId';
    public const FIELD_TOTAL = 'total';
    public const FIELD_TOTAL_TAX = 'totalTax';
    public const FIELD_TAXES = 'taxes';

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $methodTitle;

    /**
     * @var string
     */
    protected $methodId;

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
        'methodTitle' => [
            'name' => 'methodTitle',
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
        'methodId' => [
            'name' => 'methodId',
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
    ];

    /**
     * @var array
     */
    protected $_keyMap = [
        'underscored' => [
            'id' => 'id',
            'method_title' => 'methodTitle',
            'method_id' => 'methodId',
            'total' => 'total',
            'total_tax' => 'totalTax',
            'taxes' => 'taxes',
        ],
        'dashed' => [
            'id' => 'id',
            'method-title' => 'methodTitle',
            'method-id' => 'methodId',
            'total' => 'total',
            'total-tax' => 'totalTax',
            'taxes' => 'taxes',
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
     * @param string $methodTitle
     * @return $this
     */
    public function setMethodTitle(string $methodTitle)
    {
        $this->methodTitle = $methodTitle;
        $this->_touchedFields[self::FIELD_METHOD_TITLE] = true;

        return $this;
    }

    /**
     * @return string
     */
    public function getMethodTitle(): string
    {
        return $this->methodTitle;
    }

    /**
     * @return bool
     */
    public function hasMethodTitle(): bool
    {
        return $this->methodTitle !== null;
    }

    /**
     * @param string $methodId
     * @return $this
     */
    public function setMethodId(string $methodId)
    {
        $this->methodId = $methodId;
        $this->_touchedFields[self::FIELD_METHOD_ID] = true;

        return $this;
    }

    /**
     * @return string
     */
    public function getMethodId(): string
    {
        return $this->methodId;
    }

    /**
     * @return bool
     */
    public function hasMethodId(): bool
    {
        return $this->methodId !== null;
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
}

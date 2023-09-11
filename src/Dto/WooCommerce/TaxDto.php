<?php
declare(strict_types=1);

/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace App\Dto\WooCommerce;

/**
 * WooCommerce/Tax DTO
 *
 * @property int $id
 * @property float $total
 * @property float $subtotal
 */
class TaxDto extends \CakeDto\Dto\AbstractDto
{
    public const FIELD_ID = 'id';
    public const FIELD_TOTAL = 'total';
    public const FIELD_SUBTOTAL = 'subtotal';

    /**
     * @var int
     */
    protected $id;

    /**
     * @var float
     */
    protected $total;

    /**
     * @var float
     */
    protected $subtotal;

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
        'subtotal' => [
            'name' => 'subtotal',
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
            'total' => 'total',
            'subtotal' => 'subtotal',
        ],
        'dashed' => [
            'id' => 'id',
            'total' => 'total',
            'subtotal' => 'subtotal',
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
     * @param float $subtotal
     * @return $this
     */
    public function setSubtotal(float $subtotal)
    {
        $this->subtotal = $subtotal;
        $this->_touchedFields[self::FIELD_SUBTOTAL] = true;

        return $this;
    }

    /**
     * @return float
     */
    public function getSubtotal(): float
    {
        return $this->subtotal;
    }

    /**
     * @return bool
     */
    public function hasSubtotal(): bool
    {
        return $this->subtotal !== null;
    }
}

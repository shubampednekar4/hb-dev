<?php
declare(strict_types=1);

/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace App\Dto\WooCommerce;

/**
 * WooCommerce/Attribute DTO
 *
 * @property int $id
 * @property string $name
 * @property int $position
 * @property bool $visible
 * @property bool $variation
 * @property array $options
 */
class AttributeDto extends \CakeDto\Dto\AbstractDto
{
    public const FIELD_ID = 'id';
    public const FIELD_NAME = 'name';
    public const FIELD_POSITION = 'position';
    public const FIELD_VISIBLE = 'visible';
    public const FIELD_VARIATION = 'variation';
    public const FIELD_OPTIONS = 'options';

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
    protected $position;

    /**
     * @var bool
     */
    protected $visible;

    /**
     * @var bool
     */
    protected $variation;

    /**
     * @var array
     */
    protected $options;

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
        'position' => [
            'name' => 'position',
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
        'visible' => [
            'name' => 'visible',
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
        'variation' => [
            'name' => 'variation',
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
        'options' => [
            'name' => 'options',
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
            'name' => 'name',
            'position' => 'position',
            'visible' => 'visible',
            'variation' => 'variation',
            'options' => 'options',
        ],
        'dashed' => [
            'id' => 'id',
            'name' => 'name',
            'position' => 'position',
            'visible' => 'visible',
            'variation' => 'variation',
            'options' => 'options',
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
     * @param int $position
     * @return $this
     */
    public function setPosition(int $position)
    {
        $this->position = $position;
        $this->_touchedFields[self::FIELD_POSITION] = true;

        return $this;
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * @return bool
     */
    public function hasPosition(): bool
    {
        return $this->position !== null;
    }

    /**
     * @param bool $visible
     * @return $this
     */
    public function setVisible(bool $visible)
    {
        $this->visible = $visible;
        $this->_touchedFields[self::FIELD_VISIBLE] = true;

        return $this;
    }

    /**
     * @return bool
     */
    public function getVisible(): bool
    {
        return $this->visible;
    }

    /**
     * @return bool
     */
    public function hasVisible(): bool
    {
        return $this->visible !== null;
    }

    /**
     * @param bool $variation
     * @return $this
     */
    public function setVariation(bool $variation)
    {
        $this->variation = $variation;
        $this->_touchedFields[self::FIELD_VARIATION] = true;

        return $this;
    }

    /**
     * @return bool
     */
    public function getVariation(): bool
    {
        return $this->variation;
    }

    /**
     * @return bool
     */
    public function hasVariation(): bool
    {
        return $this->variation !== null;
    }

    /**
     * @param array $options
     * @return $this
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
        $this->_touchedFields[self::FIELD_OPTIONS] = true;

        return $this;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @return bool
     */
    public function hasOptions(): bool
    {
        return $this->options !== null;
    }
}

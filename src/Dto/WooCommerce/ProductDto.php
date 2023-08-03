<?php
declare(strict_types=1);

/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace App\Dto\WooCommerce;

/**
 * WooCommerce/Product DTO
 *
 * @property int $id
 * @property string|null $name
 * @property \App\Dto\WooCommerce\AttributeDto[]|null $attributes
 */
class ProductDto extends \CakeDto\Dto\AbstractDto
{
    public const FIELD_ID = 'id';
    public const FIELD_NAME = 'name';
    public const FIELD_ATTRIBUTES = 'attributes';

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string|null
     */
    protected $name;

    /**
     * @var \App\Dto\WooCommerce\AttributeDto[]|null
     */
    protected $attributes;

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
            'required' => false,
            'defaultValue' => null,
            'dto' => null,
            'collectionType' => null,
            'associative' => false,
            'key' => null,
            'serialize' => null,
            'factory' => null,
        ],
        'attributes' => [
            'name' => 'attributes',
            'type' => '\App\Dto\WooCommerce\AttributeDto[]',
            'required' => false,
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
            'attributes' => 'attributes',
        ],
        'dashed' => [
            'id' => 'id',
            'name' => 'name',
            'attributes' => 'attributes',
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
     * @param string|null $name
     * @return $this
     */
    public function setName(?string $name)
    {
        $this->name = $name;
        $this->_touchedFields[self::FIELD_NAME] = true;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @throws \RuntimeException If value is not set.
     * @return string
     */
    public function getNameOrFail(): string
    {
        if (!isset($this->name)) {
            throw new \RuntimeException('Value not set for field `name` (expected to be not null)');
        }

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
     * @param \App\Dto\WooCommerce\AttributeDto[]|null $attributes
     * @return $this
     */
    public function setAttributes(?array $attributes)
    {
        $this->attributes = $attributes;
        $this->_touchedFields[self::FIELD_ATTRIBUTES] = true;

        return $this;
    }

    /**
     * @return \App\Dto\WooCommerce\AttributeDto[]|null
     */
    public function getAttributes(): ?array
    {
        return $this->attributes;
    }

    /**
     * @throws \RuntimeException If value is not set.
     * @return \App\Dto\WooCommerce\AttributeDto[]
     */
    public function getAttributesOrFail(): array
    {
        if (!isset($this->attributes)) {
            throw new \RuntimeException('Value not set for field `attributes` (expected to be not null)');
        }

        return $this->attributes;
    }

    /**
     * @return bool
     */
    public function hasAttributes(): bool
    {
        return $this->attributes !== null;
    }
}

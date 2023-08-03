<?php
declare(strict_types=1);

/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace App\Dto;

/**
 * Address DTO
 *
 * @property string $streetAddress
 * @property string $city
 * @property string $state
 * @property string $zip
 */
class AddressDto extends \CakeDto\Dto\AbstractDto
{
    public const FIELD_STREET_ADDRESS = 'streetAddress';
    public const FIELD_CITY = 'city';
    public const FIELD_STATE = 'state';
    public const FIELD_ZIP = 'zip';

    /**
     * @var string
     */
    protected $streetAddress;

    /**
     * @var string
     */
    protected $city;

    /**
     * @var string
     */
    protected $state;

    /**
     * @var string
     */
    protected $zip;

    /**
     * Some data is only for debugging for now.
     *
     * @var array
     */
    protected $_metadata = [
        'streetAddress' => [
            'name' => 'streetAddress',
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
        'city' => [
            'name' => 'city',
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
        'state' => [
            'name' => 'state',
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
        'zip' => [
            'name' => 'zip',
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
    ];

    /**
     * @var array
     */
    protected $_keyMap = [
        'underscored' => [
            'street_address' => 'streetAddress',
            'city' => 'city',
            'state' => 'state',
            'zip' => 'zip',
        ],
        'dashed' => [
            'street-address' => 'streetAddress',
            'city' => 'city',
            'state' => 'state',
            'zip' => 'zip',
        ],
    ];

    /**
     * @param string $streetAddress
     * @return $this
     */
    public function setStreetAddress(string $streetAddress)
    {
        $this->streetAddress = $streetAddress;
        $this->_touchedFields[self::FIELD_STREET_ADDRESS] = true;

        return $this;
    }

    /**
     * @return string
     */
    public function getStreetAddress(): string
    {
        return $this->streetAddress;
    }

    /**
     * @return bool
     */
    public function hasStreetAddress(): bool
    {
        return $this->streetAddress !== null;
    }

    /**
     * @param string $city
     * @return $this
     */
    public function setCity(string $city)
    {
        $this->city = $city;
        $this->_touchedFields[self::FIELD_CITY] = true;

        return $this;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @return bool
     */
    public function hasCity(): bool
    {
        return $this->city !== null;
    }

    /**
     * @param string $state
     * @return $this
     */
    public function setState(string $state)
    {
        $this->state = $state;
        $this->_touchedFields[self::FIELD_STATE] = true;

        return $this;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @return bool
     */
    public function hasState(): bool
    {
        return $this->state !== null;
    }

    /**
     * @param string $zip
     * @return $this
     */
    public function setZip(string $zip)
    {
        $this->zip = $zip;
        $this->_touchedFields[self::FIELD_ZIP] = true;

        return $this;
    }

    /**
     * @return string
     */
    public function getZip(): string
    {
        return $this->zip;
    }

    /**
     * @return bool
     */
    public function hasZip(): bool
    {
        return $this->zip !== null;
    }
}

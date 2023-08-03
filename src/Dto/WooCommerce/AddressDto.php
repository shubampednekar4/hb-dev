<?php
declare(strict_types=1);

/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace App\Dto\WooCommerce;

/**
 * WooCommerce/Address DTO
 *
 * @property string $firstName
 * @property string $lastName
 * @property string $company
 * @property string $addressOne
 * @property string $addressTwo
 * @property string $city
 * @property string $state
 * @property string $postcode
 * @property string $country
 * @property string|null $email
 * @property string|null $phone
 */
class AddressDto extends \CakeDto\Dto\AbstractDto
{
    public const FIELD_FIRST_NAME = 'firstName';
    public const FIELD_LAST_NAME = 'lastName';
    public const FIELD_COMPANY = 'company';
    public const FIELD_ADDRESS_ONE = 'addressOne';
    public const FIELD_ADDRESS_TWO = 'addressTwo';
    public const FIELD_CITY = 'city';
    public const FIELD_STATE = 'state';
    public const FIELD_POSTCODE = 'postcode';
    public const FIELD_COUNTRY = 'country';
    public const FIELD_EMAIL = 'email';
    public const FIELD_PHONE = 'phone';

    /**
     * @var string
     */
    protected $firstName;

    /**
     * @var string
     */
    protected $lastName;

    /**
     * @var string
     */
    protected $company;

    /**
     * @var string
     */
    protected $addressOne;

    /**
     * @var string
     */
    protected $addressTwo;

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
    protected $postcode;

    /**
     * @var string
     */
    protected $country;

    /**
     * @var string|null
     */
    protected $email;

    /**
     * @var string|null
     */
    protected $phone;

    /**
     * Some data is only for debugging for now.
     *
     * @var array
     */
    protected $_metadata = [
        'firstName' => [
            'name' => 'firstName',
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
        'lastName' => [
            'name' => 'lastName',
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
        'company' => [
            'name' => 'company',
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
        'addressOne' => [
            'name' => 'addressOne',
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
        'addressTwo' => [
            'name' => 'addressTwo',
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
        'postcode' => [
            'name' => 'postcode',
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
        'country' => [
            'name' => 'country',
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
        'email' => [
            'name' => 'email',
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
        'phone' => [
            'name' => 'phone',
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
    ];

    /**
     * @var array
     */
    protected $_keyMap = [
        'underscored' => [
            'first_name' => 'firstName',
            'last_name' => 'lastName',
            'company' => 'company',
            'address_one' => 'addressOne',
            'address_two' => 'addressTwo',
            'city' => 'city',
            'state' => 'state',
            'postcode' => 'postcode',
            'country' => 'country',
            'email' => 'email',
            'phone' => 'phone',
        ],
        'dashed' => [
            'first-name' => 'firstName',
            'last-name' => 'lastName',
            'company' => 'company',
            'address-one' => 'addressOne',
            'address-two' => 'addressTwo',
            'city' => 'city',
            'state' => 'state',
            'postcode' => 'postcode',
            'country' => 'country',
            'email' => 'email',
            'phone' => 'phone',
        ],
    ];

    /**
     * @param string $firstName
     * @return $this
     */
    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
        $this->_touchedFields[self::FIELD_FIRST_NAME] = true;

        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return bool
     */
    public function hasFirstName(): bool
    {
        return $this->firstName !== null;
    }

    /**
     * @param string $lastName
     * @return $this
     */
    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
        $this->_touchedFields[self::FIELD_LAST_NAME] = true;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return bool
     */
    public function hasLastName(): bool
    {
        return $this->lastName !== null;
    }

    /**
     * @param string $company
     * @return $this
     */
    public function setCompany(string $company)
    {
        $this->company = $company;
        $this->_touchedFields[self::FIELD_COMPANY] = true;

        return $this;
    }

    /**
     * @return string
     */
    public function getCompany(): string
    {
        return $this->company;
    }

    /**
     * @return bool
     */
    public function hasCompany(): bool
    {
        return $this->company !== null;
    }

    /**
     * @param string $addressOne
     * @return $this
     */
    public function setAddressOne(string $addressOne)
    {
        $this->addressOne = $addressOne;
        $this->_touchedFields[self::FIELD_ADDRESS_ONE] = true;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddressOne(): string
    {
        return $this->addressOne;
    }

    /**
     * @return bool
     */
    public function hasAddressOne(): bool
    {
        return $this->addressOne !== null;
    }

    /**
     * @param string $addressTwo
     * @return $this
     */
    public function setAddressTwo(string $addressTwo)
    {
        $this->addressTwo = $addressTwo;
        $this->_touchedFields[self::FIELD_ADDRESS_TWO] = true;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddressTwo(): string
    {
        return $this->addressTwo;
    }

    /**
     * @return bool
     */
    public function hasAddressTwo(): bool
    {
        return $this->addressTwo !== null;
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
     * @param string $postcode
     * @return $this
     */
    public function setPostcode(string $postcode)
    {
        $this->postcode = $postcode;
        $this->_touchedFields[self::FIELD_POSTCODE] = true;

        return $this;
    }

    /**
     * @return string
     */
    public function getPostcode(): string
    {
        return $this->postcode;
    }

    /**
     * @return bool
     */
    public function hasPostcode(): bool
    {
        return $this->postcode !== null;
    }

    /**
     * @param string $country
     * @return $this
     */
    public function setCountry(string $country)
    {
        $this->country = $country;
        $this->_touchedFields[self::FIELD_COUNTRY] = true;

        return $this;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @return bool
     */
    public function hasCountry(): bool
    {
        return $this->country !== null;
    }

    /**
     * @param string|null $email
     * @return $this
     */
    public function setEmail(?string $email)
    {
        $this->email = $email;
        $this->_touchedFields[self::FIELD_EMAIL] = true;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @throws \RuntimeException If value is not set.
     * @return string
     */
    public function getEmailOrFail(): string
    {
        if (!isset($this->email)) {
            throw new \RuntimeException('Value not set for field `email` (expected to be not null)');
        }

        return $this->email;
    }

    /**
     * @return bool
     */
    public function hasEmail(): bool
    {
        return $this->email !== null;
    }

    /**
     * @param string|null $phone
     * @return $this
     */
    public function setPhone(?string $phone)
    {
        $this->phone = $phone;
        $this->_touchedFields[self::FIELD_PHONE] = true;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @throws \RuntimeException If value is not set.
     * @return string
     */
    public function getPhoneOrFail(): string
    {
        if (!isset($this->phone)) {
            throw new \RuntimeException('Value not set for field `phone` (expected to be not null)');
        }

        return $this->phone;
    }

    /**
     * @return bool
     */
    public function hasPhone(): bool
    {
        return $this->phone !== null;
    }
}

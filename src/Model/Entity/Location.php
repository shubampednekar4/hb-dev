<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use JeremyHarris\LazyLoad\ORM\LazyLoadEntityTrait;

/**
 * Location Entity
 *
 * @property int $location_id
 * @property int $franchise_id
 * @property string $location_name
 * @property string $location_address
 * @property string $location_country
 * @property string|null $location_state
 * @property int|null $state_id
 * @property string|null $location_analytics_id
 * @property string|null $location_map_code
 * @property string|null $location_pay_per_click
 * @property \Cake\I18n\FrozenTime|null $time_created
 * @property \Cake\I18n\FrozenTime|null $time_updated
 *
 * @property \App\Model\Entity\Franchise $franchise
 * @property \App\Model\Entity\State|null $state
 * @property \Cake\ORM\Entity|null $location_analytic
 * @property \App\Model\Entity\City[] $cities
 * @property \App\Model\Entity\Zip[] $zips
 * @property-read \App\Model\Entity\City|null $main_city
 * @property-read \App\Model\Entity\Zip|null $main_zip
 * @property-read array $assoc_cities
 * @property-read array $assoc_zips
 * @property \App\Model\Entity\Url[] $urls
 */
class Location extends Entity
{
    use LazyLoadEntityTrait;

    /**
     * Virtual fields to be included
     *
     * @var string[]
     */
    protected $_virtual = ['main_city', 'main_zip', 'assoc_cities', 'assoc_zips'];

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'franchise_id' => 1,
        'location_name' => 1,
        'location_address' => 1,
        'location_country' => 1,
        'location_state' => 1,
        'state_id' => 1,
        'location_analytics_id' => 1,
        'location_map_code' => 1,
        'location_pay_per_click' => 1,
        'time_created' => 1,
        'time_updated' => 1,
        'franchise' => 1,
        'state' => 1,
        'location_analytic' => 1,
        'cities' => 1,
        'zips' => 1,
        'main_city' => 1,
        'main_zip' => 1,
        'assoc_cities' => 1,
        'assoc_zips' => 1,
    ];

    /**
     * main_city method
     *
     * @return \App\Model\Entity\City|null
     */
    protected function _getMainCity(): ?City
    {
        if ($this->cities) {
            foreach ($this->cities as $city) {
                if ($city->city_is_main) {
                    return $city;
                }
            }
        }

        return null;
    }

    /**
     * main_zip method
     *
     * @return \App\Model\Entity\Zip|null
     */
    protected function _getMainZip(): ?Zip
    {
        if ($this->zips) {
            foreach ($this->zips as $zip) {
                if ($zip->zip_is_main) {
                    return $zip;
                }
            }
        }
        return null;
    }

    /**
     * assoc_cities method
     *
     * @return array
     */
    protected function _getAssocCities(): array
    {
        $result = [];
        if ($this->cities) {
            foreach ($this->cities as $city) {
                if (!$city->city_is_main) {
                    $result[] = $city;
                }
            }
        }
        return $result;
    }

    /**
     * assoc_zips method
     *
     * @return array
     */
    protected function _getAssocZips(): array
    {
        $result = [];
        if ($this->zips) {
            foreach ($this->zips as $zip) {
                if (!$zip->zip_is_main) {
                    $result[] = $zip;
                }
            }
        }
        return $result;
    }
}

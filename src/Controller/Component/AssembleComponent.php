<?php
declare(strict_types=1);

namespace App\Controller\Component;

use App\Model\Entity\Franchise;
use App\Model\Entity\Location;
use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

/**
 * Assemble component
 */
class AssembleComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    /**
     * Assemble cities method
     *
     * @param array $data
     * @return array
     */
    public function cities(array $data): array
    {
        $result = [];
        foreach ($data['cities'] as $city) {
            $result[] = [
                'city_name' => $city,
                'city_is_main' => 0
            ];
        }
        $result[] = [
            'city_name' => $data['city'],
            'city_is_main' => 1
        ];
        return $result;
    }

    /**
     * Assemble zips method
     *
     * @param array $data
     * @return array
     */
    public function zips(array $data): array
    {
        $result = [];
        foreach ($data['zips'] as $zip) {
            $result[] = [
                'zip_code' => $zip,
                'zip_is_main' => 0
            ];
        }
        $result[] = [
            'zip_code' => $data['zip'],
            'zip_is_main' => 1
        ];
        return $result;
    }

    /**
     * Assemble Locations method
     *
     * @param array $data
     * @param \App\Model\Entity\Franchise $franchise
     * @return array
     */
    public function locations(array $data, Franchise $franchise): array
    {
        $result = [];
        foreach ($data as $location) {
            $result[] = $this->single_location($location, $franchise);
        }
        return $result;
    }

    /**
     * @param array $data
     * @param \App\Model\Entity\Franchise $franchise
     * @param bool $asArray
     * @return \App\Model\Entity\Location|array|\Cake\Datasource\EntityInterface
     */
    public function single_location(array $data, Franchise $franchise, bool $asArray = false)
    {
        $state = TableRegistry::getTableLocator()->get('States')->get($data['state_id']);
        $dirty = [
            'franchise_id' => $franchise->franchise_id,
            'location_name' => $data['name'],
            'location_address' => $data['address'],
            'location_country' => $state->country->abbrev,
            'location_state' => $state->abbrev,
            'state_id' => $data['state_id'],
            'cities' => $this->cities($data),
            'zips' => $this->zips($data),
        ];
        if ($asArray) return $dirty;
        return TableRegistry::getTableLocator()->get('Locations')->newEntity($dirty);
    }
}

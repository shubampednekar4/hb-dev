<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\Location;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;
use Cake\Routing\Router;

/**
 * Locations Controller
 *
 * @property \App\Model\Table\LocationsTable $Locations
 * @method Location[]|ResultSetInterface paginate($object = null, array $settings = [])
 * @property \App\Controller\Component\AssembleComponent $Assemble
 */
class LocationsController extends AppController
{
    /**
     * Initialize method
     *
     * @throws \Exception
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Assemble');
    }

    /**
     * Add many locations method
     *
     * @return \Cake\Http\Response
     * @throws \Exception
     */
    public function addMany(): Response
    {
        $this->request->allowMethod('POST');
        $franchise = $this->Locations->Franchises->get($this->request->getData('franchise_id'));
        $this->Authorization->authorize($franchise, 'edit');
        $locations = $this->Assemble->locations($this->request->getData('location'), $franchise);
        $this->Locations->saveManyOrFail($locations, ['associated' => ['Cities', 'Zips']]);
        $franchise = $this->Locations->Franchises->get($franchise->franchise_id, [
            'contain' => [
                'Locations',
                'Locations.Cities',
                'Locations.Zips',
                'Locations.States',
                'Locations.States.Countries'
            ]
        ]);
        $response = [
            'franchise' => $franchise,
            'franchises' => $this->Locations->Franchises->find(),
        ];
        return $this->response->withType('application/json')
            ->withDisabledCache()
            ->withStringBody(json_encode($response));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response
     */
    public function add(): Response
    {
        $this->request->allowMethod(['put', 'post']);
        $data = $this->request->getData();
        $referrer = $this->request->referer();
        $params = Router::getRouteCollection()->parse($referrer);
        $franchise_id = $params['pass'][0];
        $franchise = $this->Locations->Franchises->get($franchise_id);
        $location = $this->Assemble->single_location($data, $franchise);
        $this->Authorization->authorize($location);
        $this->Locations->saveOrFail($location);
        $location = $this->Locations->get($location->location_id, ['contain' => 'States']);
        return $this->response->withType('application/json')
            ->withDisabledCache()
            ->withStringBody(json_encode($location));
    }

    /**
     * Edit method
     *
     * @return \Cake\Http\Response
     */
    public function edit(): Response
    {
        $this->request->allowMethod(['put', 'post']);
        $id = $this->request->getData('location_id');
        $location = $this->Locations->get($id);
        $this->Authorization->authorize($location);
        $data = $this->request->getData();

        $cities = [];
        $city = $location->main_city->toArray();
        $city['city_name'] = $data['main_city']['city_name'];
        $cities[] = $city;
        $existing_cities = [];
        foreach ($location->assoc_cities as $assoc_city) {
            if (in_array($assoc_city->city_name, $data['cities'])) {
                $existing_cities[] = $assoc_city->city_name;
            }
        }
        if ($data['cities']['city_name']) {
            foreach ($data['cities']['city_name'] as $assoc_city) {
                if (!in_array($assoc_city, $existing_cities)) {
                    $cities[] = [
                        'city_name' => $assoc_city,
                        'city_is_main' => false,
                    ];
                }
            }
        }


        $zips = [];
        $zip = $location->main_zip->toArray();
        $zip['zip_code'] = $data['main_zip']['zip_code'];
        $zips[] = $zip;
        $existing_zips = [];
        foreach ($location->assoc_zips as $assoc_zip) {
            if (in_array($assoc_zip->zip_code, $data['zips'])) {
                $existing_zips[] = $assoc_zip->zip_code;
            }
        }
        $data['zips']['zip_code'] = is_array($data['zips']['zip_code']) ? $data['zips']['zip_code'] : [];
        if ($data['zips']['zip_code']) {
            foreach ($data['zips']['zip_code'] as $assoc_zip) {
                if (!in_array($assoc_zip, $existing_zips)) {
                    $zips[] = [
                        'zip_code' => $assoc_zip,
                        'city_is_main' => false,
                    ];
                }
            }
        }

        $location = $this->Locations->patchEntity($location, [
            'location_name' => $data['location_name'],
            'location_address' => $data['location_address'],
            'state_id' => $data['state_id'],
            'cities' => $cities,
            'zips' => $zips,
        ]);
        $this->Locations->saveOrFail($location);
        $location = $this->Locations->get($location->location_id, ['contain' => 'States', 'Cities', 'Zips']);
        return $this->response->withType('application/json')
            ->withDisabledCache()
            ->withStringBody(json_encode($location));
    }

    /**
     * Delete method
     *
     * @param null $id
     * @return \Cake\Http\Response
     */
    public function delete($id = null): Response
    {
        $this->request->allowMethod('post');
        $location = $this->Locations->get($id);
        $this->Authorization->authorize($location);
        $this->Locations->deleteOrFail($location);
        return $this->response->withType('application/json')
            ->withDisabledCache()
            ->withStringBody(json_encode($location));
    }
}

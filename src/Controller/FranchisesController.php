<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\Component\ChartComponent;
use App\Model\Entity\Franchise;
use Cake\Database\Expression\QueryExpression;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Exception\UnauthorizedException;
use Cake\Http\Response;
use Cake\I18n\FrozenTime;
use Cake\ORM\Query;
use Cake\Routing\Router;
use Exception;

/**
 * Franchises Controller
 *
 * @property \App\Model\Table\FranchisesTable $Franchises
 * @method Franchise[]|ResultSetInterface paginate($object = null, array $settings = [])
 * @property \App\Controller\Component\ChartComponent $Chart
 */
class FranchisesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Chart');
        $this->Authentication->allowUnauthenticated(['get']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $franchises = $this->Franchises->find()->where(['franchise_status' => 'Active']);
        $this->Authorization->applyScope($franchises, 'index');
        $this->paginate = [
            'sortableFields' => [
                'Franchises.franchise_name',
                'Operators.full_name',
                'StateOwners.full_name',
                'Operators.operator_first_name',
                'StateOwners.state_owner_first_name',
                'Franchises.franchise_status',
                'Franchises.franchise_number_of_territories',
            ],
        ];

        // Franchises Added This Year
        $added = $this->Franchises->find()->where([
            'AND' => [
                function ($exp) {
                    $firstDate  = new FrozenTime("Jan 1");
                    $secondDate = new FrozenTime();

                    return $exp->between('Franchises.time_created', $firstDate->toIso8601String(),
                        $secondDate->toIso8601String());
                },
                'franchise_status' => 'Active',
            ]
        ])->count();

        // Franchises closed this year
        $closed = $this->Franchises->find()->where([
            'AND' => [
                function ($exp) {
                    $firstDate  = new FrozenTime("Jan 1");
                    $secondDate = new FrozenTime();

                    return $exp->between('Franchises.time_created', $firstDate->toIso8601String(),
                        $secondDate->toIso8601String());
                },
                'franchise_status' => 'Inactive',
            ]
        ])->count();

        // Latest Franchise
        $latest = $franchises->max(function ($franchise) {
            return $franchise->time_created;
        });

        // Timeline
        $data = $this->Chart->franchise(ChartComponent::YEAR, $franchises);

        $this->set(compact('franchises', 'data', 'added', 'closed', 'latest'));
    }

    /**
     * Manage method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function manage()
    {
        $this->paginate = [
            'contain'        => ['Operators', 'StateOwners'],
            'sortableFields' => [
                'franchise_name',
                'Operators.operator_first_name',
                'StateOwners.state_owner_first_name',
                'franchise_status',
                'franchise_number_of_territories',
            ],
            'order'          => [
                'franchise_name' => 'asc'
            ]
        ];

        $franchises = $this->Franchises->find();
        $params     = $this->request->getQueryParams();
        $data       = [];
        $reset      = false;
        if (key_exists('search', $params)) {
            if ($params['search']) {
                $search         = $params['search'];
                $data['search'] = $search;
                $reset          = true;
                $concat         = $franchises->func()->concat(['%', $search, '%']);
                $franchises     = $franchises->where([
                    'OR' => [
                        'franchise_name LIKE'             => $concat,
                        'franchise_description LIKE'      => $concat,
                        'franchise_status LIKE'           => $concat,
                        'franchise_number_of_territories' => intval($search),
                        function (QueryExpression $exp) use ($search) {
                            $conn  = $this->Franchises->Operators;
                            $query = $conn->find();

                            return $exp->like($query->func()->concat([
                                'Operators.operator_first_name' => 'identifier',
                                ' ',
                                'Operators.operator_last_name'  => 'identifier',
                            ]), "%$search%");
                        },
                        function (QueryExpression $exp) use ($search) {
                            $conn  = $this->Franchises->StateOwners;
                            $query = $conn->find();

                            return $exp->like($query->func()->concat([
                                'StateOwners.state_owner_first_name' => 'identifier',
                                ' ',
                                'StateOwners.state_owner_last_name'  => 'identifier',
                            ]), "%$search%");
                        },
                    ]
                ]);
            }
        }
        $franchises = $this->Authorization->applyScope($franchises, 'index');

        $franchises = $this->paginate($franchises);
        $this->set(compact('franchises', 'data', 'reset'));
    }

    /**
     * View method
     *
     * @param  string|null  $id  Franchise id.
     *
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null)
    {
        $franchise = $this->Franchises->get($id, [
            'contain' => [
                'Operators', 'StateOwners', 'Locations' => function (Query $q) {
                    return $q->order('location_name');
                }
            ],
        ]);

        $state_owners = $this->Franchises->StateOwners->find('list')->order('state_owner_first_name');
        $states       = $this->Franchises->Operators->States->find('list')->order('full_name');
        $this->set(compact('franchise', 'state_owners', 'states'));
    }

    /**
     * Get method
     *
     * @return \Cake\Http\Response
     */
    public function get(): Response
    {
        $token = $this->request->getQuery('token');
        // This will need to be created in a better way with authorizations but the token is there.

        if ($token !== '44a63f1e45faa1ec31db1dbe4d4e99f2ff1088f19fa16f74b81fb71feccb8ad9') {
            throw new UnauthorizedException('You are not authorized.');
        }
        $this->request->allowMethod(['get', 'post', 'options']);
        $data       = $this->request->getQueryParams();
        $franchises = $this->Franchises->find()->contain([
            'Locations',
            'Operators',
            'StateOwners',
            'StateOwners.States',
            'StateOwners.States.Countries',
            'Locations.Urls'
        ]);
        $this->Authorization->skipAuthorization();
        if ( ! empty($data['ids'])) {
            $franchises = $franchises->where([
                'franchise_id IN' => $data['ids']
            ]);
        }
        if ( ! empty($data['status'])) {
            if ( ! in_array(strtolower($data['status']), ['active', 'inactive', 'for sale'])) {
                return $this->response->withStatus(403, sprintf('Status "%s" is invalid.', $data['status']));
            }
            $franchises = $franchises->where([
                'status' => $data['status']
            ]);
        }
        $this->paginate($franchises);

        return $this->response->withType('application/json')
                              ->withDisabledCache()
                              ->withStringBody(json_encode($franchises))
                              ->withStatus(200)
                              ->withHeader('X-HB-Total-Pages', ceil($franchises->count() / 10.0));
    }

    /**
     * Create method
     *
     * @return \Cake\Http\Response
     */
    public function create(): Response
    {
        $this->request->allowMethod(['PUT', 'POST']);
        $franchise = $this->Franchises->newEmptyEntity();
        $this->Authorization->authorize($franchise, 'add');
        $this->response = $this->response->withType('application/json')
                                         ->withDisabledCache();

        try {
            $data = $this->request->getData();

            $operator       = $this->Franchises->Operators->get($data['operator_id']);
            $stateOwner     = $operator->state->state_owner ?: $this->Franchises->StateOwners->find()
                                                                                             ->where(['state_owner_first_name' => 'Corporate'])
                                                                                             ->first();
            $franchise_data = [
                'operator_id'           => $data['operator_id'],
                'state_owner_id'        => $stateOwner->state_owner_id,
                'franchise_description' => $data['description'],
                'franchise_name'        => $data['name'],
                'franchise_status'      => $data['status'],
            ];

            $franchise = $this->Franchises->patchEntity($franchise, $franchise_data);
            $this->Franchises->saveOrFail($franchise);

            return $this->response->withStringBody(json_encode($franchise));
        } catch (Exception $e) {
            $this->log($e->getMessage());
            $this->log($e->getTraceAsString());
        }

        return $this->response->withStatus(405, json_encode(['message' => 'Request not valid']));
    }

    /**
     * Edit method
     *
     * @param  string|null  $id  Franchise id.
     *
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $franchise = $this->Franchises->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $franchise = $this->Franchises->patchEntity($franchise, $this->request->getData());
            if ($this->Franchises->save($franchise)) {
                $this->Flash->success(__('The franchise has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The franchise could not be saved. Please, try again.'));
        }
        $operators   = $this->Franchises->Operators->find('list', ['limit' => 200]);
        $operators = $this->Operators->find();
        $stateOwners = $this->Franchises->StateOwners->find('list', ['limit' => 200]);
        $this->set(compact('franchise', 'operators', 'stateOwners'));
    }

    /**
     * Delete method
     *
     * @param  string|null  $id  Franchise id.
     *
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $franchise = $this->Franchises->get($id);
        $this->Authorization->authorize($franchise, 'delete');
        if ($this->Franchises->delete($franchise)) {
            $this->Flash->success(__('The franchise has been deleted.'));
        } else {
            $this->Flash->error(__('The franchise could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'manage']);
    }

    /**
     * Get statuses method
     *
     * @return \Cake\Http\Response
     */
    public function getStatuses(): Response
    {
        $this->Authorization->skipAuthorization();
        $statuses = ['Active', 'Inactive', 'For Sale'];

        return $this->response->withDisabledCache()
                              ->withType('application/json')
                              ->withStringBody(json_encode($statuses));
    }

    /**
     * Close method
     *
     * @param  null  $id
     *
     * @return \Cake\Http\Response|null
     */
    public function close($id = null): ?Response
    {
        $this->request->allowMethod('post');
        $franchise = $this->Franchises->get($id);
        $this->Authorization->authorize($franchise, 'edit');
        $franchise = $this->Franchises->patchEntity($franchise, ['franchise_status' => 'Inactive']);
        if ($this->Franchises->save($franchise)) {
            $this->Flash->success(__('Franchise was able to be labeled as "closed."'));
        } else {
            $this->Flash->error(__('Franchise could not be labeled as "closed."'));
        }

        return $this->redirect(['action' => 'view', $id]);
    }

    public function open($id = null): ?Response
    {
        $this->request->allowMethod('post');
        $franchise = $this->Franchises->get($id);
        $this->Authorization->authorize($franchise, 'edit');
        $franchise = $this->Franchises->patchEntity($franchise, ['franchise_status' => 'Active']);
        if ($this->Franchises->save($franchise)) {
            $this->Flash->success(__('Franchise was able to be labeled as "open."'));
        } else {
            $this->Flash->error(__('Franchise could not be labeled as "open."'));
        }

        return $this->redirect(['action' => 'view', $id]);
    }

    /**
     * Save info method
     *
     * @return \Cake\Http\Response
     */
    public function saveInfo(): Response
    {
        $this->request->allowMethod(['post', 'put']);
        $referrer  = $this->request->referer();
        $params    = Router::getRouteCollection()->parse($referrer);
        $id        = $params['pass'][0];
        $franchise = $this->Franchises->get($id);
        $franchise = $this->Franchises->patchEntity($franchise, $this->request->getData());
        $this->Franchises->saveOrFail($franchise);
        $this->Authorization->authorize($franchise, 'edit');
        $franchise = $this->Franchises->get($franchise->franchise_id, ['contain' => 'StateOwners']);

        return $this->response->withDisabledCache()
                              ->withType('application/json')
                              ->withStringBody(json_encode($franchise));
    }

    /**
     * Get open method.
     *
     * @return \Cake\Http\Response
     */
    public function getOpen(): Response
    {
        $this->request->allowMethod('GET');
        $franchises = $this->Franchises->find()->where(['franchise_status' => 'Active']);
        $this->Authorization->applyScope($franchises, 'index');

        return $this->response->withType('application/json')
                              ->withDisabledCache()
                              ->withStringBody(json_encode($franchises));
    }

    public function manageClose($id = null): Response
    {
        $this->request->allowMethod('POST');
        $franchise = $this->Franchises->get($id);
        $this->Authorization->authorize($franchise, 'edit');
        $franchise->franchise_status = 'Inactive';
        $this->Franchises->saveOrFail($franchise);
        $franchise = $this->Franchises->get($franchise->franchise_id);

        return $this->response->withType('application/json')
                              ->withDisabledCache()
                              ->withStringBody(json_encode($franchise));
    }
}

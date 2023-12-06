<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\Operator;
use App\Model\Entity\Hbads;
use App\Model\Entity\Videos;
use App\Model\Entity\Newsletters;
use App\Policy\HbadsPolicy;
use Cake\Core\Configure;
use Cake\Database\Expression\QueryExpression;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;
use Cake\I18n\FrozenDate;
use Cake\ORM\Exception\PersistenceFailedException;
use Cake\Routing\Router;
use Cake\Utility\Security;

/**
 * Operators Controller
 *
 * @property \App\Model\Table\OperatorsTable $Operators
 * @method Operator[]|ResultSetInterface paginate($object = null, array $settings = [])
 * @property \App\Controller\Component\RequestVerifyComponent $RequestVerify
 */
class NewslettersController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('RequestVerify');
        $this->loadComponent('Paginator');
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->Authorization->skipAuthorization();
        $identity = $this->Authentication->getIdentity();
        $identifier = $identity->getIdentifier();
        $resetNeeded = false;
        $search = null;
        $searchParam = $this->request->getQuery('search');
        $newsletters = $this->Newsletters->find();
        $this->set(compact('newsletters', 'resetNeeded', 'search'));
    }

    /**
     * View method
     *
     * @param string|null $id Operator id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $newsletter = $this->Newsletters->get($id);
        $this->Authorization->skipAuthorization();
        $identity = $this->Authentication->getIdentity();
        $identifier = $identity->getIdentifier();
        $user = $this->Newsletters->Operators->Users->get($identifier);
        $this->set(compact('newsletter', 'user'));
    }

    // /**
    //  * Add method
    //  *
    //  * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
    //  */
    public function add()
    {
        $this->Authorization->skipAuthorization();
        $identity = $this->Authentication->getIdentity();
        $identifier = $identity->getIdentifier();
        $newsletter = $this->Newsletters->newEmptyEntity();
        // $this->Authorization->authorize($hbad, 'create');
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $newsletter->title = $data['title'];
            $newsletter->description = $data['description'];
            $newsletter->newsletter_location = $data['newsletter_location'];
            
            if (!empty($data['newsletter_location'])) {
                $imageFile = $data['newsletter_location'];
                $imagePath = WWW_ROOT . 'newsletter' . DS . 'uploads' . DS;
                $imageFilename = time() . '_' . $imageFile->getClientFilename();
                $imageFile->moveTo($imagePath . $imageFilename);
                $newsletter->newsletter_location = $imageFilename;
            }
            else {
                $newsletter->newsletter_location = ''; // Set a default value
            }
            
            $newsletter->created_at = date('Y-m-d H:i:s');
            if ($this->Newsletters->save($newsletter)) {
                // Hbad saved successfully
                // redirect to wherever you want
                $this->Flash->success(__('The Newsletter has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The Newsletter could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('newsletter'));
    }
    

    // /**
    //  * Edit method
    //  *
    //  * @param string|null $id Operator id.
    //  * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
    //  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
    //  */
    public function edit($id = null)
    {
        $newsletter = $this->Newsletters->get($id);
        $this->Authorization->skipAuthorization();
        $identity = $this->Authentication->getIdentity();
        $identifier = $identity->getIdentifier();

        if ($this->request->is(['patch', 'post', 'put'])) {
            $newsletter = $this->Newsletters->patchEntity($newsletter, $this->request->getData());
            if ($this->Newsletters->save($newsletter)) {
                
              $this->Flash->success(__('The Newsletter has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Newsletter could not be saved. Please, try again.'));
        }
        $this->set(compact('newsletter'));
    }

    // /**
    //  * Delete method
    //  *
    //  * @param string|null $id Operator id.
    //  * @return \Cake\Http\Response|null|void Redirects to index.
    //  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
    //  */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $newsletter = $this->Newsletters->get($id);
        $this->Authorization->skipAuthorization();
        $identity = $this->Authentication->getIdentity();
        $identifier = $identity->getIdentifier();
        if ($this->Newsletters->delete($newsletter)) {
            $this->Flash->success(__('The Newsletter has been deleted.'));
        } else {
            $this->Flash->error(__('The Newsletter could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    // /**
    //  * @return \Cake\Http\Response
    //  */
    // public function getOperators(): Response
    // {
    //     $this->request->allowMethod(['GET']);
    //     $operators = $this->Operators->find();
    //     $this->Authorization->applyScope($operators, 'index');
    //     return $this->response->withDisabledCache()
    //         ->withType('application/json')
    //         ->withStringBody(json_encode($operators));
    // }

    // /**
    //  * Create operator method
    //  *
    //  * Used on AJAX calls.
    //  *
    //  * @return \Cake\Http\Response
    //  * @throws \Exception
    //  */
    // public function create(): Response
    // {
    //     $this->request->allowMethod(['POST', 'PUT']);
    //     $operator = $this->Operators->newEmptyEntity();
    //     $this->Authorization->authorize($operator, 'create');
    //     try {
    //         $data = $this->request->getData();
    //         $this->log(print_r($data, true));
    //         if (!$this->RequestVerify->OperatorUserData($data)) throw new \Exception('Not all data was passed.');
    //         $operator_type = $this->Operators->Users->UserTypes->find()->where(['name' => 'operator'])->first();
    //         $woocommerce = $this->loadComponent('Woocommerce');
    //         $id = $data['state_id'] ?? null;
    //         $state = $this->Operators->States->get($id);
    //             if ($woocommerce->noConflicts($data)) {
    //                 $customer = $woocommerce->createCustomer([
    //                     'email' => $data['email'],
    //                     'first_name' => $data['first_name'],
    //                     'last_name' => $data['last_name'],
    //                     'username' => $data['user_login'],
    //                     'password' => $data['password'],
    //                     'billing' => [
    //                         'first_name' => $data['first_name'],
    //                         'last_name' => $data['last_name'],
    //                         'company' => '',
    //                         'address_1' => $data['street_address'],
    //                         'address_2' => '',
    //                         'city' => $data['city'],
    //                         'state' => $state->abbrev,
    //                         'postcode' => $data['zip'],
    //                         'country' => $state->country->abbrev,
    //                         'email' => $data['email'],
    //                         'phone' => $data['phone'],
    //                     ],
    //                     'shipping' => [
    //                         'first_name' => $data['first_name'],
    //                         'last_name' => $data['last_name'],
    //                         'company' => '',
    //                         'address_1' => $data['street_address'],
    //                         'address_2' => '',
    //                         'city' => $data['city'],
    //                         'state' => $state->abbrev,
    //                         'postcode' => $data['zip'],
    //                         'country' => $state->country->abbrev,
    //                         'email' => $data['email'],
    //                     ],
    //                 ]);
    //                 $customer_id = strval($customer->id);
    //             } else {
    //                 return $this->response->withStringBody(json_encode(['message' => 'Customer already exists in the shop, please delete the customer and try again. Ensure that the customer is not associated with any orders before doing this.']));
    //             }
    //     } catch (\Exception $e) {
    //         $this->log($e->getMessage());
    //         $this->log($e->getTraceAsString());
    //         return $this->response->withStatus(400, 'Request not valid');
    //     }

    //     try {
    //         $operator = $this->Operators->patchEntity($operator, [
    //             'operator_first_name' => $data['first_name'],
    //             'operator_last_name' => $data['last_name'],
    //             'operator_email' => $data['email'],
    //             'operator_state' => $state->abbrev,
    //             'operator_phone' => $data['phone'] ?? '',
    //             'operator_address' => $data['street_address'],
    //             'operator_city' => $data['city'],
    //             'operator_zip' => $data['zip'],
    //             'date_joined' => new FrozenDate(),
    //             'operator_id' => $data['user_login'],
    //             'state_id' => $state->state_id,
    //             'operator_token' => Security::randomString(32),
    //             'operator_country' => $state->country->abbrev,
    //         ]);
    //         $this->Operators->saveOrFail($operator);
    //         /** @var \App\Model\Entity\UserType $operator_type */
    //         $user = $this->Operators->Users->newEntity([
    //             'user_username' => $data['user_login'],
    //             'user_email' => $data['email'],
    //             'user_first_name' => $data['first_name'],
    //             'user_last_name' => $data['last_name'],
    //             'user_password' => $data['password'],
    //             'user_type' => 'operator',
    //             'operator_id' => $operator->operator_id,
    //             'user_type_id' => $operator_type->id,
    //             'customer_id' => $customer_id,
    //         ]);
    //         $this->Authorization->authorize($user, 'create');
    //         $this->Operators->Users->saveOrFail($user);
    //         $operator = $this->Operators->get($operator->operator_id);
    //         $operator->user_id = $user->user_id;
    //         if ($operator->hasErrors()) {
    //             dd('stop');
    //         }
    //         $this->Operators->saveOrFail($operator);
    //     } catch (PersistenceFailedException $e) {
    //         $this->response = $this->response->withType('application/json')
    //             ->withDisabledCache();
    //         if (Configure::read('debug')) {
    //             $check = 'Entity save failure. Found the following errors (operator_id.unique: "The provided value is invalid").';
    //             return $this->response->withStringBody(json_encode([
    //                     'message' => $e->getMessage() === $check ? 'Operator or User Already Exists' : $e->getMessage(),
    //                     'file' => $e->getFile(),
    //                     'line' => $e->getLine(),
    //                     'trace' => $e->getTrace()
    //                 ]))
    //                 ->withStatus(400, $e->getMessage());
    //         } else {
    //             return $this->response->withStringBody(json_encode(['message' => 'An internal error has occurred']))
    //                 ->withStatus(400, 'An internal error has occurred');
    //         }
    //     }


    //     return $this->response->withDisabledCache()
    //         ->withType('application/json')
    //         ->withStringBody(json_encode($operator));
    // }

    // /**
    //  * Save information method
    //  *
    //  * @return \Cake\Http\Response
    //  */
    // public function saveInfo(): Response
    // {
    //     $this->request->allowMethod(['post', 'put']);
    //     $referrer = $this->request->referer();
    //     $params = Router::getRouteCollection()->parse($referrer);
    //     $id = $params['pass'][0];
    //     $franchise = $this->Operators->Franchises->get($id);
    //     $operator = $franchise->operator;
    //     $this->Authorization->authorize($operator, 'edit');
    //     $operator = $this->Operators->patchEntity($operator, $this->request->getData());
    //     $this->Operators->saveOrFail($operator);
    //     $operator = $this->Operators->get($operator->operator_id, ['contain' => ['States', 'Users']]);
    //     return $this->response->withDisabledCache()
    //         ->withType('application/json')
    //         ->withStringBody(json_encode($operator));
    // }
}

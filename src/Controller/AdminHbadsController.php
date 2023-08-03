<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\Operator;
use App\Model\Entity\Hbads;
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
class AdminHbadsController extends AppController
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
        // $user = $this->Operators->Users->get($identifier);
        // if (!$user->has_manage_access) {
        //     $operator = $this->Operators->find()
        //         ->where(['user_id' => $user->user_id])
        //         ->first();
        //     /** @var \App\Model\Entity\Operator $operator */
        //     $this->redirect(['action' => 'view', $operator->operator_id]);
        // }
        // $this->paginate = [
        //     'contain' => ['Users', 'States'],
        // ];
        // $operators = $this->Operators->find();
        // $operators = $this->Authorization->applyScope($operators, 'index');
        $resetNeeded = false;
        $search = null;
        $searchParam = $this->request->getQuery('search');
        // if ($searchParam) {
        //     $resetNeeded = true;
        //     $search = $searchParam;
        //     $parsedParam = $operators->func()->concat(['%', $searchParam, '%']);
        //     $operators = $operators->where([
        //         'OR' => [
        //             function (QueryExpression $exp) use ($searchParam) {
        //                 $conn = $this->getTableLocator()->get('Operators');
        //                 $query = $conn->find();

        //                 return $exp->like($query->func()->concat([
        //                     'Operators.operator_first_name' => 'identifier',
        //                     ' ',
        //                     'Operators.operator_last_name' => 'identifier',
        //                 ]), "%$searchParam%");
        //             },
        //             'Operators.operator_email LIKE' => $parsedParam,
        //             'Operators.operator_phone LIKE' => $parsedParam,
        //             'Operators.operator_state LIKE' => $parsedParam,
        //             'Operators.operator_city LIKE' => $parsedParam,
        //             'Operators.operator_address LIKE' => $parsedParam,
        //             'Operators.operator_zip LIKE' => $parsedParam,
        //             'Operators.operator_country LIKE' => $parsedParam,
        //         ],
        //     ]);
        // }
        // if ($operators->count() === 0) {
        //     $this->Flash->info(__('No operators were found.'));
        // }
        // $operators = $this->paginate($operators);
        $hbads = $this->AdminHbads->Hbads->find();
        $this->set(compact('hbads', 'resetNeeded', 'search'));
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
        $hbad = $this->AdminHbads->Hbads->get($id);
        $this->Authorization->skipAuthorization();
        $identity = $this->Authentication->getIdentity();
        $identifier = $identity->getIdentifier();
        $user = $this->AdminHbads->Operators->Users->get($identifier);
        $this->set(compact('hbad', 'user'));
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
        $hbad = $this->AdminHbads->Hbads->newEmptyEntity();
        // $this->Authorization->authorize($hbad, 'create');
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $hbad->title = $data['title'];
            $hbad->description = $data['description'];
            
            // Check if image file is uploaded
            if (!empty($data['image_location'])) {
                $imageFile = $data['image_location'];
                $imagePath = WWW_ROOT . 'img' . DS . 'uploads' . DS;
                $imageFilename = time() . '_' . $imageFile->getClientFilename();
                $imageFile->moveTo($imagePath . $imageFilename);
                $hbad->image_location = $imageFilename;
            }
            else {
                $hbad->image_location = ''; // Set a default value
            }
            
            // Check if PDF file is uploaded
            if (!empty($data['pdf_location'])) {
                $pdfFile = $data['pdf_location'];
                $pdfPath = WWW_ROOT . 'pdf' . DS . 'uploads' . DS;
                $pdfFilename = time() . '_' . $pdfFile->getClientFilename();
                $pdfFile->moveTo($pdfPath . $pdfFilename);
                $hbad->pdf_location = $pdfFilename;
            }
            else {
                $hbad->pdf_location = ''; // Set a default value
            }
            $hbad->created_at = date('Y-m-d H:i:s');
            $hbad->is_deleted = 0;
            if ($this->AdminHbads->Hbads->save($hbad)) {
                // Hbad saved successfully
                // redirect to wherever you want
                $this->Flash->success(__('The Hbad has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The Hbad could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('hbad'));
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
        $hbad = $this->AdminHbads->Hbads->get($id);
        $this->Authorization->skipAuthorization();
        $identity = $this->Authentication->getIdentity();
        $identifier = $identity->getIdentifier();

        if ($this->request->is(['patch', 'post', 'put'])) {
            $hbad = $this->AdminHbads->Hbads->patchEntity($hbad, $this->request->getData());
            if ($this->AdminHbads->Hbads->save($hbad)) {
                
              $this->Flash->success(__('The Ad has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Ad could not be saved. Please, try again.'));
        }
        $this->set(compact('hbad'));
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
        $hbad = $this->AdminHbads->Hbads->get($id);
        $this->Authorization->skipAuthorization();
        $identity = $this->Authentication->getIdentity();
        $identifier = $identity->getIdentifier();
        if ($this->AdminHbads->Hbads->delete($hbad)) {
            $this->Flash->success(__('The Ad has been deleted.'));
        } else {
            $this->Flash->error(__('The Ad could not be deleted. Please, try again.'));
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

<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\User;
use Authorization\Exception\ForbiddenException;
use Cake\Database\Expression\QueryExpression;
use Cake\Event\EventInterface;
use Cake\Mailer\Mailer;
use Cake\Routing\Router;
use Cake\Utility\Security;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method User[]|ResultSetInterface paginate($object = null, array $settings = [])
 * @property \App\Controller\Component\WoocommerceComponent $Woocommerce
 */
class UsersController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Woocommerce');
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        $this->Authentication->allowUnauthenticated([
            'login', 'forgotPassword', 'resetPassword', 'logout', 'resetSent'
        ]);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $identity    = $this->Authentication->getIdentity();
        $currentUser = $this->Users->get($identity->getIdentifier());
        if ( ! $currentUser->is_admin) {
            $this->Flash->error(__('Sorry, you aren\'t allowed to do that.'));
            throw new ForbiddenException();
        }
        $this->paginate = [
            'contain' => ['Operators', 'StateOwners', 'UserTypes'],
        ];
        $users          = $this->Users->find();
        $users          = $this->Authorization->applyScope($users);

        $resetNeeded = false;
        $search      = null;
        $searchParam = $this->request->getQuery('search');
        if ($searchParam) {
            $resetNeeded = true;
            $search      = $searchParam;
            $parsedParam = $users->func()->concat(['%', $searchParam, '%']);
            $users       = $users->where([
                'OR' => [
                    function (QueryExpression $exp) use ($searchParam) {
                        $conn  = $this->getTableLocator()->get('Users');
                        $query = $conn->find();

                        return $exp->like($query->func()->concat([
                            'Users.user_first_name' => 'identifier',
                            ' ',
                            'Users.user_last_name'  => 'identifier',
                        ]), "%$searchParam%");
                    },
                    'Users.user_username LIKE'   => $parsedParam,
                    'Users.user_first_name LIKE' => $parsedParam,
                    'Users.user_last_name LIKE'  => $parsedParam,
                    'Users.user_email LIKE'      => $parsedParam,
                    'Users.user_type LIKE'       => $parsedParam,
                ],
            ]);
        }
        if ($users->count() === 0) {
            $this->Flash->info(__('No users were found.'));
        }
        if ( ! $this->request->getQuery('sort')) {
            $users = $this->paginate($users->order(['Users.user_username']));
        } else {
            $users = $this->paginate($users);
        }
        $this->set(compact('users', 'resetNeeded', 'search'));
    }

    /**
     * View method
     *
     * @param  string|null  $id  User id.
     *
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Operators', 'StateOwners'],
        ]);
        $this->Authorization->authorize($user, 'view');

        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        $this->Authorization->authorize($user, 'create');
        $userTypes       = $this->Users->UserTypes->find()->select('name');
        $userTypeOptions = [];
        foreach ($userTypes as $userType) {
            $userTypeOptions[$userType->name] = $userType->name;
        }
        if ($this->request->is('post')) {
            $data        = $this->request->getData();
            $companyName = "Heaven's Best Carpet Cleaning";
            $woo_data    = [
                'email'      => $data['user_email'],
                'first_name' => $data['user_first_name'],
                'last_name'  => $data['user_last_name'],
                'username'   => $data['user_username'],
                'password'   => $data['user_password'],
                'billing'    => [
                    'first_name' => $data['user_first_name'],
                    'last_name'  => $data['user_last_name'],
                    'company'    => $companyName,
                    'address_1'  => '',
                    'address_2'  => '',
                    'city'       => '',
                    'state'      => '',
                    'postcode'   => '',
                    'country'    => '',
                    'email'      => $data['user_email'],
                    'phone'      => '',
                ],
                'shipping'   => [
                    'first_name' => $data['user_first_name'],
                    'last_name'  => $data['user_last_name'],
                    'company'    => $companyName,
                    'address_1'  => '',
                    'address_2'  => '',
                    'city'       => '',
                    'state'      => '',
                    'postcode'   => '',
                    'country'    => '',
                    'email'      => $data['user_email'],
                ],
            ];


            $customer = $this->Woocommerce->createCustomer($woo_data);
            if ( ! $customer->id) {
                $this->Flash->error(__('The user could not be created on the shop. Please try again. If this problem persists please contact support.'));
            } else {
                $data['customer_id'] = strval($customer->id);
                $user                = $this->Users->patchEntity($user, $data, ['associations' => ['Operators']]);
                if ($this->Users->save($user)) {
                    $this->Flash->success(__('The user has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $this->set('states', $this->Users->Operators->States->find('list'));
        $this->set('operators', $this->Users->Operators->find('list'));
        $this->set('stateOwners', $this->Users->StateOwners->find('list'));
        $this->set('countries', $this->Users->Operators->States->Countries->find('list'));
        $this->set('users', $this->Users->find('list'));
        $this->set(compact('user', 'userTypeOptions'));
    }

    /**
     * Edit method
     *
     * @param  string|null  $id  User id.
     *
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['UserTypes'],
        ]);
        $this->Authorization->authorize($user, 'update');
        $userTypes       = $this->Users->UserTypes->find()->select('name');
        $userTypeOptions = [];
        foreach ($userTypes as $userType) {
            $userTypeOptions[$userType->name] = $userType->name;
        }
        $actor = $this->Users->get($this->Authentication->getIdentity()->getIdentifier());
        if ($this->request->is(['patch', 'post', 'put'])) {
            $password = $this->request->getData('user_password');
            $data     = $this->request->getData();
            if ( ! $password) {
                unset($data['user_password']);
            }

            if (isset($data['new_user_type'])) {
                $oldUserType                   = $this->Users->UserTypes->get($data['new_user_type']['id']);
                $data['new_user_type']['name'] = $oldUserType->name;
            }
            $user = $this->Users->patchEntity($user, $data);
            if ($this->Users->save($user)) {
                if ($actor->is_admin) {
                    $this->Flash->success(__('Profile has been saved.'));

                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->success(__('Your profile has been saved.'));

                    return $this->redirect(['controller' => 'pages', 'action' => 'home']);
                }
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $operators   = $this->Users->Operators->find('list', ['limit' => 200]);
        $stateOwners = $this->Users->StateOwners->find('list', ['limit' => 200]);
        $this->set(compact('user', 'operators', 'stateOwners', 'userTypeOptions', 'actor'));
    }

    /**
     * Delete method
     *
     * @param  string|null  $id  User id.
     *
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        $this->Authorization->authorize($user, 'delete');
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Login method.
     *
     * @return \Cake\Http\Response|null
     */
    public function login()
    {
        $this->Authorization->skipAuthorization();
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            $target = $this->Authentication->getLoginRedirect() ?? '/';

            return $this->redirect($target);
        }
        if ($this->request->is('post') && ! $result->isValid()) {
            $this->Flash->error('Invalid username or password');
        }
        $this->viewBuilder()->setLayout('no_nav');
    }

    /**
     * Logout Method.
     *
     * @return \Cake\Http\Response|null
     */
    public function logout()
    {
        $this->Authorization->skipAuthorization();
        $this->Authentication->logout();

        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }

    /**
     * Forgot password method.
     *
     * @return \Cake\Http\Response|null
     */
    public function forgotPassword()
    {
        $this->Authorization->skipAuthorization();
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            $this->Flash->warning('You are already logged in.');

            return $this->redirect(['controller' => 'pages', 'action' => 'home']);
        }
        if ($this->request->is('post')) {
            $parameter = $this->request->getData('username_or_email');
            $user      = $this->Users->find()->where([
                'OR' => [
                    'user_username' => $parameter,
                    'user_email'    => $parameter,
                ],
            ])->first();
            /** @var \App\Model\Entity\User $user */
            if ($user) {
                $token = Security::randomString(32);
                $user  = $this->Users->patchEntity($user, ['forgot_pw_token' => $token]);
                if ($this->Users->save($user)) {
                    $link   = Router::url([
                        'controller' => 'Users', 'action' => 'resetPassword', '?' => [
                            'token' => $token,
                        ]
                    ], true);
                    $mailer = new Mailer([
                        'transport'   => 'default',
                        'from'        => ['no-reply@heavensbest.com' => "Heaven's Best Corporate App"],
                        'to'          => $user->user_email,
                        'subject'     => 'Password Reset',
                        'theme'       => 'Modern',
                        'layout'      => 'default',
                        'template'    => 'link',
                        'emailFormat' => 'html',
                        'viewVars'    => [
                            'user' => $user,
                            'link' => $link,
                        ],
                    ]);
                    $mailer->deliver();
                }
            }
            $this->Flash->success('A password link has been sent to your email.');

            return $this->redirect(['controller' => 'Users', 'action' => 'resetSent']);
        }
        $this->viewBuilder()->setLayout('no_nav');
    }

    /**
     * Reset password method.
     *
     * @return \Cake\Http\Response|null
     */
    public function resetPassword()
    {
        $this->Authorization->skipAuthorization();
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            $this->Flash->warning('You are already logged in.');
            $target = Router::url(['controller' => 'pages', 'action' => 'home']);

            return $this->redirect($target);
        }
        $token = $this->request->getQuery('token');
        if ( ! $token) {
            $this->Flash->warning('Password reset link was invalid.');

            return $this->redirect(['controller' => 'users', 'action' => 'login']);
        }
        $user = $this->Users->find()->where(['forgot_pw_token' => $token])->first();

        if ($user) {
            $this->Flash->warning('Password reset link was invalid.');

            return $this->redirect(['controller' => 'users', 'action' => 'login']);
        }

        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success('Password was reset successfully');

                return $this->redirect(['controller' => 'Users', 'action' => 'login']);
            } else {
                $this->Flash->error('Password could not be reset. Please try again');
            }
        }
        $this->viewBuilder()->setLayout('no_nav');
        $this->set(compact('user'));
    }

    /**
     * Reset Sent method.
     *
     * @return \Cake\Http\Response|null
     */
    public function resetSent()
    {
        $this->Authorization->skipAuthorization();
        if ($this->referer() !== '/users/forgot-password') {
            $this->Flash->error('Cannot access that page from here.');

            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
        $this->viewBuilder()->setLayout('no_nav');
    }
}

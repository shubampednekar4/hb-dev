<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Database\Expression\QueryExpression;

/**
 * StateOwners Controller
 *
 * @property \App\Model\Table\StateOwnersTable $StateOwners
 * @method \App\Model\Entity\StateOwner[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class StateOwnersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $stateOwners = $this->StateOwners->find();
        $this->Authorization->skipAuthorization();
        $stateOwners = $this->Authorization->applyScope($stateOwners);

        $resetNeeded = false;
        $search = null;
        $searchParam = $this->request->getQuery('search');
        if ($searchParam) {
            $resetNeeded = true;
            $search = $searchParam;
            $parsedParam = $stateOwners->func()->concat(['%', $searchParam, '%']);
            $stateOwners = $stateOwners->where([
                'OR' => [
                    function (QueryExpression $exp) use ($searchParam) {
                        $conn = $this->getTableLocator()->get('StateOwners');
                        $query = $conn->find();

                        return $exp->like($query->func()->concat([
                            'StateOwners.state_owner_first_name' => 'identifier',
                            ' ',
                            'StateOwners.state_owner_last_name' => 'identifier',
                        ]), "%$searchParam%");
                    },
                    'StateOwners.state_owner_email LIKE' => $parsedParam,
                    'StateOwners.state_owner_phone LIKE' => $parsedParam,
                    'StateOwners.state_owner_city LIKE' => $parsedParam,
                    'StateOwners.state_owner_address LIKE' => $parsedParam,
                    'StateOwners.state_owner_zip LIKE' => $parsedParam,
                ],
            ]);
        }
        if ($stateOwners->count() === 0) {
            $this->Flash->info('No State Owners were found.');
        }

        $stateOwners = $this->paginate($stateOwners);
        $this->set(compact('stateOwners', 'resetNeeded', 'search'));
    }

    /**
     * View method
     *
     * @param string|null $id State Owner id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $stateOwner = $this->StateOwners->get($id, [
            'contain' => ['States'],
        ]);

        $this->Authorization->authorize($stateOwner, 'view');
        $stateOwnerStates = $this->StateOwners->States->find()->where(['state_owner_id' => $stateOwner->state_owner_id]);

        $this->set(compact('stateOwner', 'stateOwnerStates'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $stateOwner = $this->StateOwners->newEmptyEntity();
        $this->Authorization->authorize($stateOwner, 'create');
        if ($this->request->is('post')) {
            $stateOwner = $this->StateOwners->patchEntity($stateOwner, $this->request->getData());
            if ($this->StateOwners->save($stateOwner)) {
                $this->Flash->success(__('The state owner has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The state owner could not be saved. Please, try again.'));
        }
        $states = $this->StateOwners->States->find('list', ['limit' => 200]);
        $operators = $this->StateOwners->Operators->find('list');
        $users = $this->StateOwners->Operators->Users->find('list');
        $this->set(compact('stateOwner', 'states', 'operators', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id State Owner id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $stateOwner = $this->StateOwners->get($id, [
            'contain' => ['States', 'Users'],
        ]);
        $this->Authorization->authorize($stateOwner, 'update');
        $operators = $this->StateOwners->Operators->find('list');
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            // force the operator_id to be null if nothing is selected
            if ($data['state_owner_operator_id'] === '') {
                $data['state_owner_operator_id'] = null;
            }
            $stateOwner = $this->StateOwners->patchEntity($stateOwner, $data, ['associated' => ['Users', 'Operators']]);
            if ($this->StateOwners->save($stateOwner, ['associated' => ['States']])) {
                $state_ids = $data['States']['_state_ids'];
                $linked = $this->StateOwners->States->find()->where(['state_id IN' => $state_ids]);
                $this->StateOwners->States->link($stateOwner, $linked->toArray());
                $this->StateOwners->States->unlink($stateOwner, array_diff_assoc($stateOwner->states, $linked->toArray()));
                $oldUser = $stateOwner->user;
                if ($this->request->getData('user_id')) {
                    $user = $this->StateOwners->Users->get($this->request->getData('user_id'));
                    $user = $this->StateOwners->Users->patchEntity($user, ['state_owner_id' => $stateOwner->state_owner_id]);
                    if ($oldUser) {
                        $oldUser = $this->StateOwners->Users->patchEntity($oldUser, ['state_owner_id' => null]);
                        if (!$this->StateOwners->Users->save($user) || !$this->StateOwners->Users->save($oldUser)) {
                            $this->Flash->error(__('Unable to update user.'));
                        }
                    } elseif (!$this->StateOwners->Users->save($user)) {
                        $this->Flash->error(__('Unable to update user.'));
                    }
                } else {
                    if ($oldUser) {
                        $oldUser = $this->StateOwners->Users->patchEntity($oldUser, ['state_owner_id' => null]);
                        if (!$this->StateOwners->Users->save($oldUser)) {
                            $this->Flash->error(__('Unable to update user.'));
                        }
                    }
                }

                $this->Flash->success(__('The state owner has been saved.'));

                return $this->redirect(['controller' => 'StateOwners', 'action' => 'view', $stateOwner->state_owner_id]);
            }
            $this->Flash->error(__('The state owner could not be saved. Please, try again.'));
        }
        $rawStates = $this->StateOwners->States->find();
        $states = $this->StateOwners->States->find('list');
        $multipleStates = [];
        /** @var \App\Model\Entity\State $state */
        foreach ($rawStates as $state) {
            $multipleStates[$state->state_id] = [
                'value' => $state->state_id,
                'text' => $state->full_name,
            ];
            if ($state->state_owner_id) {
                if ($state->state_owner_id === $stateOwner->state_owner_id) {
                    $multipleStates[$state->state_id]['selected'] = true;
                }
            }
        }

        $rawUsers = $this->StateOwners->Users->find();
        $users = [];
        /** @var \App\Model\Entity\User $user */
        foreach ($rawUsers as $user) {
            $users[$user->user_id] = [
                'value' => $user->user_id,
                'text' => sprintf('%s %s (%s)', $user->user_first_name, $user->user_last_name, $user->user_username),
            ];
            if ($user->state_owner_id) {
                if ($user->state_owner_id === $stateOwner->state_owner_id) {
                    $users[$user->user_id]['selected'] = true;
                }
            }
        }
        $this->set(compact('stateOwner', 'states', 'operators', 'users', 'multipleStates'));
    }

    /**
     * Delete method
     *
     * @param string|null $id State Owner id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $stateOwner = $this->StateOwners->get($id);
        $this->Authorization->authorize($stateOwner, 'delete');
        if ($this->StateOwners->delete($stateOwner)) {
            $this->Flash->success(__('The state owner has been deleted.'));
        } else {
            $this->Flash->error(__('The state owner could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

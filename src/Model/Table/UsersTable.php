<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \App\Model\Table\OperatorsTable&\Cake\ORM\Association\BelongsTo $Operators
 * @property \App\Model\Table\StateOwnersTable&\Cake\ORM\Association\BelongsTo $StateOwners
 * @property \App\Model\Table\UserTypesTable&\Cake\ORM\Association\BelongsTo $UserTypes
 * @method \App\Model\Entity\User newEmptyEntity()
 * @method \App\Model\Entity\User newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 * @property \App\Model\Table\NotificationsTable&\Cake\ORM\Association\HasMany $Notifications
 */
class UsersTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('display_name');
        $this->setPrimaryKey('user_id');

        $this->belongsTo('Operators', [
            'foreignKey' => 'operator_id',
        ]);
        $this->belongsTo('StateOwners', [
            'foreignKey' => 'state_owner_id',
        ]);
        $this->belongsTo('UserTypes', [
            'foreignKey' => 'user_type_id',
            'propertyName' => 'new_user_type',
        ]);
        $this->belongsTo('StateOwners', [
            'foreignKey' => 'state_owner_id',
        ]);
        $this->hasMany('Notifications', [
            'foreignKey' => 'user_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('user_id')
            ->allowEmptyString('user_id', null, 'create')
            ->add('user_id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('user_username')
            ->maxLength('user_username', 90)
            ->requirePresence('user_username', 'create')
            ->notEmptyString('user_username');

        $validator
            ->scalar('user_email')
            ->maxLength('user_email', 45)
            ->requirePresence('user_email', 'create')
            ->notEmptyString('user_email');

        $validator
            ->scalar('user_first_name')
            ->maxLength('user_first_name', 45)
            ->requirePresence('user_first_name', 'create')
            ->notEmptyString('user_first_name');

        $validator
            ->scalar('user_last_name')
            ->maxLength('user_last_name', 45)
            ->requirePresence('user_last_name', 'create')
            ->notEmptyString('user_last_name');

        $validator
            ->scalar('user_password')
            ->maxLength('user_password', 64)
            ->requirePresence('user_password', 'create')
            ->add('user_password', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('user_type')
            ->maxLength('user_type', 45)
            ->requirePresence('user_type', 'create')
            ->notEmptyString('user_type');

        $validator
            ->dateTime('forgot_pw_token_ts')
            ->allowEmptyDateTime('forgot_pw_token_ts');

        $validator
            ->dateTime('time_created')
            ->allowEmptyDateTime('time_created');

        $validator
            ->dateTime('time_updated')
            ->allowEmptyDateTime('time_updated');

        $validator
            ->scalar('forgot_pw_token')
            ->maxLength('forgot_pw_token', 32)
            ->allowEmptyString('forgot_pw_token');

        $validator
            ->numeric('customer_id')
            ->requirePresence('customer_id', 'create')
            ->notEmptyString('tile_and_grout');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['user_id']), ['errorField' => 'user_id']);
        $rules->add($rules->isUnique(['user_password']), ['errorField' => 'user_password']);
        $rules->add($rules->existsIn(['operator_id'], 'Operators'), ['errorField' => 'operator_id']);
        $rules->add($rules->existsIn(['state_owner_id'], 'StateOwners'), ['errorField' => 'state_owner_id']);
        $rules->add($rules->existsIn(['user_type_id'], 'UserTypes'), ['errorField' => 'user_type_id']);

        return $rules;
    }
}

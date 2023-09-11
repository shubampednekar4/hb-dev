<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Operators Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\StatesTable&\Cake\ORM\Association\BelongsTo $States
 * @method \App\Model\Entity\Operator newEmptyEntity()
 * @method \App\Model\Entity\Operator newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Operator[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Operator get($primaryKey, $options = [])
 * @method \App\Model\Entity\Operator findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Operator patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Operator[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Operator|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Operator saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Operator[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Operator[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Operator[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Operator[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 * @property \App\Model\Table\StateOwnersTable&\Cake\ORM\Association\HasMany $StateOwners
 * @property \Cake\ORM\Table&\Cake\ORM\Association\BelongsTo $Supervisor
 * @property \App\Model\Table\FranchisesTable&\Cake\ORM\Association\HasMany $Franchises
 */
class OperatorsTable extends Table
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

        $this->setTable('operators');
        $this->setDisplayField('list_name');
        $this->setPrimaryKey('operator_id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
        $this->belongsTo('States', [
            'foreignKey' => 'state_id',
        ]);
        $this->hasMany('StateOwners', [
            'foreignKey' => 'state_owner_operator_id',
        ]);
        $this->hasMany('Franchises', [
            'operator_id'
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
            ->scalar('operator_id')
            ->maxLength('operator_id', 11)
            ->allowEmptyString('operator_id', null, 'create')
            ->add('operator_id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('operator_first_name')
            ->maxLength('operator_first_name', 45)
            ->requirePresence('operator_first_name', 'create')
            ->notEmptyString('operator_first_name');

        $validator
            ->scalar('operator_last_name')
            ->maxLength('operator_last_name', 45)
            ->requirePresence('operator_last_name', 'create')
            ->notEmptyString('operator_last_name');

        $validator
            ->scalar('operator_email')
            ->maxLength('operator_email', 120)
            ->allowEmptyString('operator_email');

        $validator
            ->scalar('operator_phone')
            ->maxLength('operator_phone', 45)
            ->allowEmptyString('operator_phone');

        $validator
            ->scalar('operator_state')
            ->maxLength('operator_state', 45)
            ->allowEmptyString('operator_state');

        $validator
            ->scalar('operator_city')
            ->maxLength('operator_city', 45)
            ->allowEmptyString('operator_city');

        $validator
            ->scalar('operator_address')
            ->maxLength('operator_address', 45)
            ->allowEmptyString('operator_address');

        $validator
            ->scalar('operator_zip')
            ->maxLength('operator_zip', 45)
            ->allowEmptyString('operator_zip');

        $validator
            ->scalar('operator_country')
            ->maxLength('operator_country', 45)
            ->allowEmptyString('operator_country');

        $validator
            ->scalar('operator_token')
            ->maxLength('operator_token', 32)
            ->allowEmptyString('operator_token');

        $validator
            ->date('date_joined')
            ->allowEmptyDate('date_joined');

        $validator
            ->dateTime('time_created')
            ->allowEmptyDateTime('time_created');

        $validator
            ->dateTime('time_updated')
            ->allowEmptyDateTime('time_updated');

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
        $rules->add($rules->isUnique(['operator_id']), ['errorField' => 'operator_id']);
        $rules->add($rules->isUnique(['user_id']), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn(['state_id'], 'States'), ['errorField' => 'state_id']);

        return $rules;
    }
}

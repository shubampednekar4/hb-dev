<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * StateOwners Model
 *
 * @method \App\Model\Entity\StateOwner newEmptyEntity()
 * @method \App\Model\Entity\StateOwner newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\StateOwner[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\StateOwner get($primaryKey, $options = [])
 * @method \App\Model\Entity\StateOwner findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\StateOwner patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\StateOwner[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\StateOwner|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\StateOwner saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\StateOwner[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\StateOwner[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\StateOwner[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\StateOwner[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 * @property \App\Model\Table\OperatorsTable&\Cake\ORM\Association\BelongsTo $Operators
 * @property \App\Model\Table\StatesTable&\Cake\ORM\Association\HasMany $States
 * @property \App\Model\Table\StatesTable&\Cake\ORM\Association\BelongsTo $State
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\HasOne $Users
 */
class StateOwnersTable extends Table
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

        $this->setTable('state_owners');
        $this->setDisplayField('full_name');
        $this->setPrimaryKey('state_owner_id');
        $this->hasMany('States', [
            'foreignKey' => 'state_owner_id',
        ]);
        $this->belongsTo('State', [
            'foreignKey' => 'state_id',
            'className' => 'States',
        ]);
        $this->hasOne('Users', [
            'foreignKey' => 'state_owner_id',
        ]);
        $this->belongsTo('Operators', [
            'foreignKey' => 'state_owner_operator_id',
            'className' => 'Operators',
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
            ->integer('state_owner_id')
            ->allowEmptyString('state_owner_id', null, 'create')
            ->add('state_owner_id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('state_owner_first_name')
            ->maxLength('state_owner_first_name', 45)
            ->requirePresence('state_owner_first_name', 'create')
            ->notEmptyString('state_owner_first_name');

        $validator
            ->scalar('state_owner_last_name')
            ->maxLength('state_owner_last_name', 45)
            ->requirePresence('state_owner_last_name', 'create')
            ->notEmptyString('state_owner_last_name');

        $validator
            ->scalar('state_owner_email')
            ->maxLength('state_owner_email', 120)
            ->allowEmptyString('state_owner_email');

        $validator
            ->scalar('state_owner_phone')
            ->maxLength('state_owner_phone', 45)
            ->allowEmptyString('state_owner_phone');

        $validator
            ->scalar('state_owner_address')
            ->maxLength('state_owner_address', 45)
            ->allowEmptyString('state_owner_address');

        $validator
            ->scalar('state_owner_city')
            ->maxLength('state_owner_city', 45)
            ->allowEmptyString('state_owner_city');

        $validator
            ->scalar('state_owner_zip')
            ->maxLength('state_owner_zip', 45)
            ->allowEmptyString('state_owner_zip');

        $validator
            ->scalar('state_owner_token')
            ->maxLength('state_owner_token', 32)
            ->allowEmptyString('state_owner_token');

        $validator
            ->boolean('state_owner_able_to_sell')
            ->notEmptyString('state_owner_able_to_sell');

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
        $rules->add($rules->isUnique(['state_owner_id']), ['errorField' => 'state_owner_id']);
        $rules->add($rules->existsIn(['state_id'], 'States'), ['errorField' => 'state_id']);
        $rules->add($rules->existsIn(
            ['state_owner_operator_id'],
            'Operators',
            [
                'allowNullableNulls' => true,
                'message' => "Doesn't exist",
            ]
        ), ['errorField' => 'state_owner_operator_id']);

        return $rules;
    }
}

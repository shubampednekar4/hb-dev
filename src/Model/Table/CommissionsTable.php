<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Commissions Model
 *
 * @property \App\Model\Table\OperatorsTable&\Cake\ORM\Association\BelongsTo $Operators
 * @property \App\Model\Table\StateOwnersTable&\Cake\ORM\Association\BelongsTo $StateOwners
 * @property \Cake\ORM\Table&\Cake\ORM\Association\BelongsTo $Orders
 * @method \App\Model\Entity\Commission newEmptyEntity()
 * @method \App\Model\Entity\Commission newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Commission[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Commission get($primaryKey, $options = [])
 * @method \App\Model\Entity\Commission findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Commission patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Commission[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Commission|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Commission saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Commission[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Commission[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Commission[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Commission[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class CommissionsTable extends Table
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

        $this->setTable('commissions');
        $this->setDisplayField('commission_id');
        $this->setPrimaryKey('commission_id');

        $this->belongsTo('Operators', [
            'foreignKey' => 'operator_id',
        ]);
        $this->belongsTo('StateOwners', [
            'foreignKey' => 'state_owner_id',
        ]);
        $this->belongsTo('Orders', [
            'foreignKey' => 'order_id',
            'joinType' => 'INNER',
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
            ->integer('commission_id')
            ->allowEmptyString('commission_id', null, 'create')
            ->add('commission_id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->numeric('total_commission')
            ->requirePresence('total_commission', 'create')
            ->notEmptyString('total_commission');

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
        $rules->add($rules->isUnique(['commission_id']), ['errorField' => 'commission_id']);
        $rules->add($rules->existsIn(['order_id'], 'Orders'), ['errorField' => 'order_id']);
        $rules->add($rules->existsIn(['operator_id'], 'Operators'), ['errorField' => 'operator_id']);
        $rules->add($rules->existsIn(['state_owner_id'], 'StateOwners'), ['errorField' => 'state_owner_id']);

        return $rules;
    }
}

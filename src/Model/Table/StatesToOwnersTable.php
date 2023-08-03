<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * StatesToOwners Model
 *
 * @property \App\Model\Table\StateOwnersTable&\Cake\ORM\Association\BelongsTo $StateOwners
 * @property \App\Model\Table\StatesTable&\Cake\ORM\Association\BelongsTo $States
 * @method \App\Model\Entity\StatesToOwner newEmptyEntity()
 * @method \App\Model\Entity\StatesToOwner newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\StatesToOwner[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\StatesToOwner get($primaryKey, $options = [])
 * @method \App\Model\Entity\StatesToOwner findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\StatesToOwner patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\StatesToOwner[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\StatesToOwner|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\StatesToOwner saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\StatesToOwner[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\StatesToOwner[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\StatesToOwner[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\StatesToOwner[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class StatesToOwnersTable extends Table
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

        $this->setTable('states_to_owners');
        $this->setDisplayField('state_to_owners_id');
        $this->setPrimaryKey('state_to_owners_id');

        $this->belongsTo('StateOwners', [
            'foreignKey' => 'state_owner_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('States', [
            'foreignKey' => 'state_id',
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
            ->integer('state_to_owners_id')
            ->allowEmptyString('state_to_owners_id', null, 'create')
            ->add('state_to_owners_id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

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
        $rules->add($rules->isUnique(['state_to_owners_id']), ['errorField' => 'state_to_owners_id']);
        $rules->add($rules->existsIn(['state_owner_id'], 'StateOwners'), ['errorField' => 'state_owner_id']);
        $rules->add($rules->existsIn(['state_id'], 'States'), ['errorField' => 'state_id']);

        return $rules;
    }
}

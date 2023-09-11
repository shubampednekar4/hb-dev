<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Franchises Model
 *
 * @property \App\Model\Table\OperatorsTable&\Cake\ORM\Association\BelongsTo $Operators
 * @property \App\Model\Table\StateOwnersTable&\Cake\ORM\Association\BelongsTo $StateOwners
 * @method \App\Model\Entity\Franchise newEmptyEntity()
 * @method \App\Model\Entity\Franchise newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Franchise[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Franchise get($primaryKey, $options = [])
 * @method \App\Model\Entity\Franchise findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Franchise patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Franchise[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Franchise|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Franchise saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Franchise[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Franchise[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Franchise[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Franchise[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 * @property \App\Model\Table\LocationsTable&\Cake\ORM\Association\HasMany $Locations
 */
class FranchisesTable extends Table
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

        $this->setTable('franchises');
        $this->setDisplayField('franchise_name');
        $this->setPrimaryKey('franchise_id');

        $this->belongsTo('Operators', [
            'foreignKey' => 'operator_id',
        ]);
        $this->belongsTo('StateOwners', [
            'foreignKey' => 'state_owner_id',
        ]);
        $this->hasMany('Locations', [
            'foreignKey' => 'franchise_id',
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
            ->integer('franchise_id')
            ->allowEmptyString('franchise_id', null, 'create')
            ->add('franchise_id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('franchise_description')
            ->requirePresence('franchise_description', 'create')
            ->notEmptyString('franchise_description');

        $validator
            ->scalar('franchise_name')
            ->maxLength('franchise_name', 45)
            ->requirePresence('franchise_name', 'create')
            ->notEmptyString('franchise_name')
            ->add('franchise_name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('franchise_status')
            ->maxLength('franchise_status', 45)
            ->requirePresence('franchise_status', 'create')
            ->notEmptyString('franchise_status');

        $validator
            ->scalar('franchise_number_of_territories')
            ->maxLength('franchise_number_of_territories', 45)
            ->allowEmptyString('franchise_number_of_territories');

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
        $rules->add($rules->isUnique(['franchise_name']), ['errorField' => 'franchise_name']);
        $rules->add($rules->isUnique(['franchise_id']), ['errorField' => 'franchise_id']);
        $rules->add($rules->existsIn(['operator_id'], 'Operators'), ['errorField' => 'operator_id']);
        $rules->add($rules->existsIn(['state_owner_id'], 'StateOwners'), ['errorField' => 'state_owner_id']);

        return $rules;
    }
}

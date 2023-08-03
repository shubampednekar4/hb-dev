<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Locations Model
 *
 * @property \App\Model\Table\FranchisesTable&\Cake\ORM\Association\BelongsTo $Franchises
 * @property \App\Model\Table\StatesTable&\Cake\ORM\Association\BelongsTo $States
 * @property \Cake\ORM\Table&\Cake\ORM\Association\BelongsTo $LocationAnalytics
 * @method \App\Model\Entity\Location newEmptyEntity()
 * @method \App\Model\Entity\Location newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Location[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Location get($primaryKey, $options = [])
 * @method \App\Model\Entity\Location findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Location patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Location[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Location|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Location saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Location[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Location[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Location[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Location[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 * @property \App\Model\Table\CitiesTable&\Cake\ORM\Association\HasMany $Cities
 * @property \App\Model\Table\ZipsTable&\Cake\ORM\Association\HasMany $Zips
 * @property \App\Model\Table\UrlsTable&\Cake\ORM\Association\HasMany $Urls
 */
class LocationsTable extends Table
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

        $this->setTable('locations');
        $this->setDisplayField('location_id');
        $this->setPrimaryKey('location_id');

        $this->belongsTo('Franchises', [
            'foreignKey' => 'franchise_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('States', [
            'foreignKey' => 'state_id',
        ]);
        $this->hasMany('Cities', [
            'foreignKey' => 'location_id',
            'saveStrategy' => 'replace'
        ]);
        $this->hasMany('Zips', [
            'foreignKey' => 'location_id',
            'saveStrategy' => 'replace'
        ]);
        $this->hasMany('Urls', [
            'foreignKey' => 'location_id',
            'saveStrategy' => 'replace'
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
            ->integer('location_id')
            ->allowEmptyString('location_id', null, 'create')
            ->add('location_id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('location_name')
            ->maxLength('location_name', 45)
            ->requirePresence('location_name', 'create')
            ->notEmptyString('location_name')
            ->add('location_name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('location_address')
            ->maxLength('location_address', 45)
            ->requirePresence('location_address', 'create')
            ->notEmptyString('location_address');

        $validator
            ->scalar('location_country')
            ->maxLength('location_country', 45)
            ->requirePresence('location_country', 'create')
            ->notEmptyString('location_country');

        $validator
            ->scalar('location_state')
            ->maxLength('location_state', 45)
            ->allowEmptyString('location_state');

        $validator
            ->scalar('location_map_code')
            ->maxLength('location_map_code', 256)
            ->notEmptyString('location_map_code');

        $validator
            ->scalar('location_pay_per_click')
            ->maxLength('location_pay_per_click', 45)
            ->allowEmptyString('location_pay_per_click');

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
        $rules->add($rules->isUnique(['location_id']), ['errorField' => 'location_id']);
        $rules->add($rules->isUnique(['location_name']), ['errorField' => 'location_name']);
        $rules->add($rules->existsIn(['franchise_id'], 'Franchises'), ['errorField' => 'franchise_id']);
        $rules->add($rules->existsIn(['state_id'], 'States'), ['errorField' => 'state_id']);

        return $rules;
    }
}

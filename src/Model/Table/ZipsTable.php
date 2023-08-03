<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Zips Model
 *
 * @property \App\Model\Table\LocationsTable&\Cake\ORM\Association\BelongsTo $Locations
 *
 * @method \App\Model\Entity\Zip newEmptyEntity()
 * @method \App\Model\Entity\Zip newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Zip[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Zip get($primaryKey, $options = [])
 * @method \App\Model\Entity\Zip findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Zip patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Zip[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Zip|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Zip saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Zip[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Zip[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Zip[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Zip[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ZipsTable extends Table
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

        $this->setTable('zips');
        $this->setDisplayField('zip_code');
        $this->setPrimaryKey('zip_id');

        $this->belongsTo('Locations', [
            'foreignKey' => 'location_id',
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
            ->integer('zip_id')
            ->allowEmptyString('zip_id', null, 'create')
            ->add('zip_id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('zip_code')
            ->maxLength('zip_code', 45)
            ->requirePresence('zip_code', 'create')
            ->notEmptyString('zip_code');

        $validator
            ->notEmptyString('zip_is_main');

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
        $rules->add($rules->isUnique(['zip_id']), ['errorField' => 'zip_id']);
        $rules->add($rules->existsIn(['location_id'], 'Locations'), ['errorField' => 'location_id']);

        return $rules;
    }
}

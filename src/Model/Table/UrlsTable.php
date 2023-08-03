<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Urls Model
 *
 * @property \App\Model\Table\LocationsTable&\Cake\ORM\Association\BelongsTo $Locations
 * @method \App\Model\Entity\Url newEmptyEntity()
 * @method \App\Model\Entity\Url newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Url[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Url get($primaryKey, $options = [])
 * @method \App\Model\Entity\Url findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Url patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Url[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Url|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Url saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Url[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Url[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Url[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Url[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class UrlsTable extends Table
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

        $this->setTable('urls');
        $this->setDisplayField('url_id');
        $this->setPrimaryKey('url_id');

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
            ->integer('url_id')
            ->allowEmptyString('url_id', null, 'create')
            ->add('url_id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('url_address')
            ->maxLength('url_address', 512)
            ->requirePresence('url_address', 'create')
            ->notEmptyString('url_address');

        $validator
            ->scalar('url_type')
            ->maxLength('url_type', 45)
            ->requirePresence('url_type', 'create')
            ->notEmptyString('url_type');

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
        $rules->add($rules->isUnique(['url_id']), ['errorField' => 'url_id']);
        $rules->add($rules->existsIn(['location_id'], 'Locations'), ['errorField' => 'location_id']);

        return $rules;
    }
}

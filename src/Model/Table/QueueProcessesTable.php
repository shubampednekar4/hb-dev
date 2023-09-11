<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * QueueProcesses Model
 *
 * @method \App\Model\Entity\QueueProcess newEmptyEntity()
 * @method \App\Model\Entity\QueueProcess newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\QueueProcess[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\QueueProcess get($primaryKey, $options = [])
 * @method \App\Model\Entity\QueueProcess findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\QueueProcess patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\QueueProcess[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\QueueProcess|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\QueueProcess saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\QueueProcess[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\QueueProcess[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\QueueProcess[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\QueueProcess[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class QueueProcessesTable extends Table
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

        $this->setTable('queue_processes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('pid')
            ->maxLength('pid', 40)
            ->requirePresence('pid', 'create')
            ->notEmptyString('pid');

        $validator
            ->boolean('terminate')
            ->notEmptyString('terminate');

        $validator
            ->scalar('server')
            ->maxLength('server', 90)
            ->allowEmptyString('server');

        $validator
            ->scalar('workerkey')
            ->maxLength('workerkey', 45)
            ->requirePresence('workerkey', 'create')
            ->notEmptyString('workerkey')
            ->add('workerkey', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

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
        $rules->add($rules->isUnique(['workerkey']), ['errorField' => 'workerkey']);

        return $rules;
    }
}

<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * QueuedJobs Model
 *
 * @method \App\Model\Entity\QueuedJob newEmptyEntity()
 * @method \App\Model\Entity\QueuedJob newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\QueuedJob[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\QueuedJob get($primaryKey, $options = [])
 * @method \App\Model\Entity\QueuedJob findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\QueuedJob patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\QueuedJob[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\QueuedJob|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\QueuedJob saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\QueuedJob[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\QueuedJob[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\QueuedJob[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\QueuedJob[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class QueuedJobsTable extends Table
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

        $this->setTable('queued_jobs');
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
            ->scalar('job_type')
            ->maxLength('job_type', 45)
            ->requirePresence('job_type', 'create')
            ->notEmptyString('job_type');

        $validator
            ->scalar('data')
            ->allowEmptyString('data');

        $validator
            ->scalar('job_group')
            ->maxLength('job_group', 255)
            ->allowEmptyString('job_group');

        $validator
            ->scalar('reference')
            ->maxLength('reference', 255)
            ->allowEmptyString('reference');

        $validator
            ->dateTime('notbefore')
            ->allowEmptyDateTime('notbefore');

        $validator
            ->dateTime('fetched')
            ->allowEmptyDateTime('fetched');

        $validator
            ->dateTime('completed')
            ->allowEmptyDateTime('completed');

        $validator
            ->numeric('progress')
            ->allowEmptyString('progress');

        $validator
            ->integer('failed')
            ->notEmptyString('failed');

        $validator
            ->scalar('failure_message')
            ->allowEmptyString('failure_message');

        $validator
            ->scalar('workerkey')
            ->maxLength('workerkey', 45)
            ->allowEmptyString('workerkey');

        $validator
            ->scalar('status')
            ->maxLength('status', 255)
            ->allowEmptyString('status');

        $validator
            ->integer('priority')
            ->notEmptyString('priority');

        return $validator;
    }
}

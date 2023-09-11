<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PdfJobs Model
 *
 * @property \App\Model\Table\PdfsTable&\Cake\ORM\Association\BelongsTo $Pdfs
 * @property \App\Model\Table\QueuedJobsTable&\Cake\ORM\Association\BelongsTo $QueuedJobs
 * @method \App\Model\Entity\PdfJob newEmptyEntity()
 * @method \App\Model\Entity\PdfJob newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\PdfJob[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PdfJob get($primaryKey, $options = [])
 * @method \App\Model\Entity\PdfJob findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\PdfJob patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PdfJob[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\PdfJob|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PdfJob saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PdfJob[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PdfJob[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\PdfJob[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PdfJob[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PdfJobsTable extends Table
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

        $this->setTable('pdf_jobs');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Pdfs', [
            'foreignKey' => 'pdf_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('QueuedJobs', [
            'foreignKey' => 'queued_job_id',
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
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->boolean('is_completed')
            ->notEmptyString('is_completed');

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
        $rules->add($rules->existsIn(['pdf_id'], 'Pdfs'), ['errorField' => 'pdf_id']);
        $rules->add($rules->existsIn(['queued_job_id'], 'QueuedJobs'), ['errorField' => 'queued_job_id']);

        return $rules;
    }
}

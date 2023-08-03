<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Pdfs Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\PdfGroupsTable&\Cake\ORM\Association\HasMany $PdfGroups
 * @property \App\Model\Table\PdfJobsTable&\Cake\ORM\Association\HasMany $PdfJobs
 *
 * @method \App\Model\Entity\Pdf newEmptyEntity()
 * @method \App\Model\Entity\Pdf newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Pdf[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Pdf get($primaryKey, $options = [])
 * @method \App\Model\Entity\Pdf findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Pdf patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Pdf[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Pdf|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Pdf saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Pdf[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Pdf[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Pdf[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Pdf[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PdfsTable extends Table
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

        $this->setTable('pdfs');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('PdfGroups', [
            'foreignKey' => 'pdf_id',
        ]);
        $this->hasMany('PdfJobs', [
            'foreignKey' => 'pdf_id',
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
            ->dateTime('startDate')
            ->requirePresence('startDate', 'create')
            ->notEmptyDateTime('startDate');

        $validator
            ->dateTime('endDate')
            ->requirePresence('endDate', 'create')
            ->notEmptyDateTime('endDate');

        $validator
            ->boolean('is_done')
            ->notEmptyString('is_done');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }
}

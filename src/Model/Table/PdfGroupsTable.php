<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PdfGroups Model
 *
 * @property \App\Model\Table\StateOwnersTable&\Cake\ORM\Association\BelongsTo $StateOwners
 * @property \App\Model\Table\PdfsTable&\Cake\ORM\Association\BelongsTo $Pdfs
 * @property \App\Model\Table\PdfMetaTable&\Cake\ORM\Association\HasMany $PdfMeta
 * @method \App\Model\Entity\PdfGroup newEmptyEntity()
 * @method \App\Model\Entity\PdfGroup newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\PdfGroup[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PdfGroup get($primaryKey, $options = [])
 * @method \App\Model\Entity\PdfGroup findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\PdfGroup patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PdfGroup[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\PdfGroup|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PdfGroup saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PdfGroup[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PdfGroup[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\PdfGroup[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PdfGroup[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PdfGroupsTable extends Table
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

        $this->setTable('pdf_groups');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('StateOwners', [
            'foreignKey' => 'state_owner_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Pdfs', [
            'foreignKey' => 'pdf_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('PdfMeta', [
            'foreignKey' => 'pdf_group_id',
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
        $rules->add($rules->existsIn(['state_owner_id'], 'StateOwners'), ['errorField' => 'state_owner_id']);
        $rules->add($rules->existsIn(['pdf_id'], 'Pdfs'), ['errorField' => 'pdf_id']);

        return $rules;
    }
}

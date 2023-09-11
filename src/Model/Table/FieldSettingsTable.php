<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FieldSettings Model
 *
 * @method \App\Model\Entity\FieldSetting newEmptyEntity()
 * @method \App\Model\Entity\FieldSetting newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\FieldSetting[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FieldSetting get($primaryKey, $options = [])
 * @method \App\Model\Entity\FieldSetting findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\FieldSetting patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FieldSetting[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\FieldSetting|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FieldSetting saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FieldSetting[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\FieldSetting[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\FieldSetting[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\FieldSetting[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class FieldSettingsTable extends Table
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

        $this->setTable('field_settings');
        $this->setDisplayField('field_setting_id');
        $this->setPrimaryKey('field_setting_id');
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
            ->integer('field_setting_id')
            ->allowEmptyString('field_setting_id', null, 'create');

        $validator
            ->scalar('field_setting_type')
            ->maxLength('field_setting_type', 45)
            ->requirePresence('field_setting_type', 'create')
            ->notEmptyString('field_setting_type');

        $validator
            ->scalar('field_setting_name')
            ->maxLength('field_setting_name', 45)
            ->requirePresence('field_setting_name', 'create')
            ->notEmptyString('field_setting_name');

        $validator
            ->scalar('field_setting_content')
            ->maxLength('field_setting_content', 256)
            ->allowEmptyString('field_setting_content');

        $validator
            ->scalar('field_setting_image_path')
            ->maxLength('field_setting_image_path', 500)
            ->allowEmptyFile('field_setting_image_path');

        $validator
            ->dateTime('time_created')
            ->allowEmptyDateTime('time_created');

        $validator
            ->dateTime('time_upated')
            ->allowEmptyDateTime('time_upated');

        return $validator;
    }
}

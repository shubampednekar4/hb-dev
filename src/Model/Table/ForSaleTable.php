<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ForSale Model
 *
 * @property \App\Model\Table\FranchisesTable&\Cake\ORM\Association\BelongsTo $Franchises
 * @method \App\Model\Entity\ForSale newEmptyEntity()
 * @method \App\Model\Entity\ForSale newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ForSale[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ForSale get($primaryKey, $options = [])
 * @method \App\Model\Entity\ForSale findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\ForSale patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ForSale[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ForSale|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ForSale saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ForSale[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ForSale[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\ForSale[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ForSale[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ForSaleTable extends Table
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

        $this->setTable('for_sale');
        $this->setDisplayField('for_sale_id');
        $this->setPrimaryKey('for_sale_id');

        $this->belongsTo('Franchises', [
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
            ->integer('for_sale_id')
            ->allowEmptyString('for_sale_id', null, 'create');

        $validator
            ->boolean('published')
            ->allowEmptyString('published');

        $validator
            ->scalar('user_coding_header')
            ->allowEmptyString('user_coding_header');

        $validator
            ->scalar('for_sale_name')
            ->maxLength('for_sale_name', 45)
            ->allowEmptyString('for_sale_name');

        $validator
            ->scalar('for_sale_overview')
            ->allowEmptyString('for_sale_overview');

        $validator
            ->scalar('for_sale_whb')
            ->allowEmptyString('for_sale_whb');

        $validator
            ->scalar('for_sale_vitals')
            ->allowEmptyString('for_sale_vitals');

        $validator
            ->scalar('for_sale_map')
            ->allowEmptyString('for_sale_map');

        $validator
            ->scalar('for_sale_emails')
            ->allowEmptyString('for_sale_emails');

        $validator
            ->scalar('for_sale_required')
            ->allowEmptyString('for_sale_required');

        $validator
            ->scalar('for_sale_img_path')
            ->allowEmptyString('for_sale_img_path');

        $validator
            ->scalar('custom_header')
            ->allowEmptyString('custom_header');

        $validator
            ->scalar('custom_text')
            ->allowEmptyString('custom_text');

        $validator
            ->scalar('for_sale_banner_text')
            ->allowEmptyString('for_sale_banner_text');

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
        $rules->add($rules->existsIn(['franchise_id'], 'Franchises'), ['errorField' => 'franchise_id']);

        return $rules;
    }
}

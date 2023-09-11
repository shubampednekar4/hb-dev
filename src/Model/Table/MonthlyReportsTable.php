<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MonthlyReports Model
 *
 * @property \App\Model\Table\OperatorsTable&\Cake\ORM\Association\BelongsTo $Operators
 * @property \App\Model\Table\FranchisesTable&\Cake\ORM\Association\BelongsTo $Franchises
 * @method \App\Model\Entity\MonthlyReport newEmptyEntity()
 * @method \App\Model\Entity\MonthlyReport newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\MonthlyReport[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MonthlyReport get($primaryKey, $options = [])
 * @method \App\Model\Entity\MonthlyReport findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\MonthlyReport patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MonthlyReport[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\MonthlyReport|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MonthlyReport saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MonthlyReport[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\MonthlyReport[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\MonthlyReport[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\MonthlyReport[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class MonthlyReportsTable extends Table
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

        $this->setTable('reports');
        $this->setDisplayField('report_id');
        $this->setPrimaryKey('report_id');

        $this->belongsTo('Operators', [
            'foreignKey' => 'operator_id',
        ]);
        $this->belongsTo('Franchises', [
            'foreignKey' => 'franchise_id',
        ]);
        // Define the StateOwners association
        $this->belongsTo('StateOwners');
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
            ->integer('report_id')
            ->allowEmptyString('report_id', null, 'create')
            ->add('report_id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->date('month')
            ->requirePresence('month', 'create')
            ->notEmptyDate('month');

        $validator
            ->numeric('carpet_cleaning_res')
            ->allowEmptyString('carpet_cleaning_res');

        $validator
            ->numeric('carpet_cleaning_comm')
            ->allowEmptyString('carpet_cleaning_comm');

        $validator
            ->numeric('upholstery_cleaning')
            ->allowEmptyString('upholstery_cleaning');

        $validator
            ->numeric('tile_grout_res')
            ->allowEmptyString('tile_grout_res');

        $validator
            ->numeric('tile_grout_comm')
            ->allowEmptyString('tile_grout_comm');

        $validator
            ->numeric('hardwood_floor')
            ->allowEmptyString('hardwood_floor');

        $validator
            ->numeric('fabric_protectant')
            ->allowEmptyString('fabric_protectant');

        $validator
            ->numeric('miscellaneous')
            ->allowEmptyString('miscellaneous');

        $validator
            ->numeric('advertising_cost')
            ->allowEmptyString('advertising_cost');

        $validator
            ->numeric('advertising_percentage')
            ->allowEmptyString('advertising_percentage');

        $validator
            ->numeric('receipt_total')
            ->allowEmptyString('receipt_total');

        $validator
            ->dateTime('time_created')
            ->allowEmptyDateTime('time_created');

        $validator
            ->requirePresence('operator_id', 'add')
            ->notEmptyString('operator_id');

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
        $rules->add($rules->isUnique(['report_id']), ['errorField' => 'report_id']);
        $rules->add($rules->existsIn(['operator_id'], 'Operators'), ['errorField' => 'operator_id']);
        $rules->add($rules->existsIn(['franchise_id'], 'Franchises'), ['errorField' => 'franchise_id']);
        $rules->addCreate($rules->isUnique([ 'month', 'franchise_id'], 'There is a report for that month for this franchise already, try editing the existing report instead.'));

        return $rules;
    }
}

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
class NewsTable extends Table
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

        
        // Define the Videos association
        $this->belongsTo('Newsletters');
        // Define the Operators association
        $this->belongsTo('Operators');
        
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->notEmptyString('title', __('Please enter a title.'))
            ->maxLength('title', 255, __('Title must be no more than 255 characters.'))
            ->notEmptyString('description', __('Please enter a description.'));

        return $validator;
    }

    /**
     * Before save method.
     *
     * @param \Cake\Event\EventInterface $event The beforeSave event that was fired.
     * @param \Cake\ORM\EntityInterface $entity The entity that is going to be saved.
     * @param \ArrayObject $options The options for the save operation.
     * @return void
     */
    public function beforeSave($event, $entity, $options)
    {
        if ($entity->isNew()) {
            $entity->created_at = date('Y-m-d H:i:s');
        }
        
    }
}

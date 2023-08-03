<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use JeremyHarris\LazyLoad\ORM\LazyLoadEntityTrait;

/**
 * MonthlyReport Entity
 *
 * @property int $report_id
 * @property string|null $operator_id
 * @property int|null $franchise_id
 * @property \Cake\I18n\FrozenDate $month
 * @property float|null $carpet_cleaning_res
 * @property float|null $carpet_cleaning_comm
 * @property float|null $upholstery_cleaning
 * @property float|null $tile_grout_res
 * @property float|null $tile_grout_comm
 * @property float|null $hardwood_floor
 * @property float|null $fabric_protectant
 * @property float|null $miscellaneous
 * @property float|null $advertising_cost
 * @property float|null $advertising_percentage
 * @property float|null $receipt_total
 * @property \Cake\I18n\FrozenTime|null $time_created
 *
 * @property \App\Model\Entity\Operator|null $operator
 * @property \App\Model\Entity\Franchise|null $franchise
 * @property \App\Model\Entity\State $state
 */
class MonthlyReport extends Entity
{
    use LazyLoadEntityTrait;

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'operator_id' => true,
        'franchise_id' => true,
        'month' => true,
        'carpet_cleaning_res' => true,
        'carpet_cleaning_comm' => true,
        'upholstery_cleaning' => true,
        'tile_grout_res' => true,
        'tile_grout_comm' => true,
        'hardwood_floor' => true,
        'fabric_protectant' => true,
        'miscellaneous' => true,
        'advertising_cost' => true,
        'advertising_percentage' => true,
        'receipt_total' => true,
        'time_created' => true,
        'operator' => true,
        'franchise' => true,
        'state' => true,
    ];
}

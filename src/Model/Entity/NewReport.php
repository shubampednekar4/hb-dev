<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * NewReport Entity
 *
 * @property int $id
 * @property int|null $state_id
 * @property int|null $franchise_id
 * @property string $first_name
 * @property string $last_name
 * @property string $address
 * @property string $city
 * @property string $postal_code
 * @property string $phone
 * @property string $email
 * @property float $carpet_and_upholstery
 * @property float $tile_and_grout
 * @property float $fabric_protector
 * @property float $other_sales
 * @property float $advertising_cost
 * @property \Cake\I18n\FrozenDate $month
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property string $operator_id
 * @property int $user_id
 *
 * @property \App\Model\Entity\State|null $state
 * @property \App\Model\Entity\Franchise|null $franchise
 * @property \App\Model\Entity\Operator $operator
 * @property \App\Model\Entity\User $user
 */
class NewReport extends Entity
{
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
        'state_id' => 1,
        'franchise_id' => 1,
        'first_name' => 1,
        'last_name' => 1,
        'address' => 1,
        'city' => 1,
        'postal_code' => 1,
        'phone' => 1,
        'email' => 1,
        'carpet_and_upholstery' => 1,
        'tile_and_grout' => 1,
        'fabric_protector' => 1,
        'other_sales' => 1,
        'advertising_cost' => 1,
        'month' => 1,
        'created' => 1,
        'modified' => 1,
        'operator_id' => 1,
        'user_id' => 1,
        'state' => 1,
        'franchise' => 1,
        'operator' => 1,
        'user' => 1,
    ];
}

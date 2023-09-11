<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Commission Entity
 *
 * @property int $commission_id
 * @property string|null $operator_id
 * @property int|null $state_owner_id
 * @property string $order_id
 * @property float $total_commission
 * @property \Cake\I18n\FrozenTime|null $time_created
 * @property \Cake\I18n\FrozenTime|null $time_updated
 *
 * @property \App\Model\Entity\Operator|null $operator
 * @property \App\Model\Entity\StateOwner|null $state_owner
 * @property \Cake\ORM\Entity $order
 */
class Commission extends Entity
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
        'operator_id' => 1,
        'state_owner_id' => 1,
        'order_id' => 1,
        'total_commission' => 1,
        'time_created' => 1,
        'time_updated' => 1,
        'operator' => 1,
        'state_owner' => 1,
        'order' => 1,
    ];
}

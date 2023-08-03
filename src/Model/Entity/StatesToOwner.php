<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * StatesToOwner Entity
 *
 * @property int $state_to_owners_id
 * @property int $state_owner_id
 * @property int $state_id
 *
 * @property \App\Model\Entity\StateOwner $state_owner
 * @property \App\Model\Entity\State $state
 */
class StatesToOwner extends Entity
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
        'state_owner_id' => 1,
        'state_id' => 1,
        'state_owner' => 1,
        'state' => 1,
    ];
}

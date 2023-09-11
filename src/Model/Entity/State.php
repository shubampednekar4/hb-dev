<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use JeremyHarris\LazyLoad\ORM\LazyLoadEntityTrait;

/**
 * State Entity
 *
 * @property int $state_id
 * @property string $full_name
 * @property string $abbrev
 * @property int|null $country_id
 * @property int|null $state_owner_id
 *
 * @property \App\Model\Entity\Country|null $country
 * @property \App\Model\Entity\StateOwner|null $state_owner
 * @property \App\Model\Entity\StateOwner[] $state_owners
 */
class State extends Entity
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
        'full_name' => 1,
        'abbrev' => 1,
        'country_id' => 1,
        'state_owner_id' => 1,
        'country' => 1,
        'state_owner' => 1,
        'states' => 1,
        '*' => 1,
    ];
}

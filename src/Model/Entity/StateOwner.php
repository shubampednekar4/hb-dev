<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use JeremyHarris\LazyLoad\ORM\LazyLoadEntityTrait;

/**
 * StateOwner Entity
 *
 * @property int $state_owner_id
 * @property int|null $state_id
 * @property string $state_owner_first_name
 * @property string $state_owner_last_name
 * @property string|null $state_owner_operator_id
 * @property string|null $state_owner_email
 * @property string|null $state_owner_phone
 * @property string|null $state_owner_address
 * @property string|null $state_owner_city
 * @property string|null $state_owner_zip
 * @property string|null $state_owner_token
 * @property bool $state_owner_able_to_sell
 * @property \Cake\I18n\FrozenTime|null $time_created
 * @property \Cake\I18n\FrozenTime|null $time_updated
 *
 * @property \App\Model\Entity\State|null $state
 * @property \App\Model\Entity\Operator|null $operator
 * @property \App\Model\Entity\User[] $users
 * @property \App\Model\Entity\State[] $states
 * @property \App\Model\Entity\User|null $user
 * @property \App\Model\Entity\State|null $State
 * @property string $full_name
 */
class StateOwner extends Entity
{
    use LazyLoadEntityTrait;

    protected $_virtual = ['full_name'];

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
        'state_owner_first_name' => 1,
        'state_owner_last_name' => 1,
        'state_owner_operator_id' => 1,
        'state_owner_email' => 1,
        'state_owner_phone' => 1,
        'state_owner_address' => 1,
        'state_owner_city' => 1,
        'state_owner_zip' => 1,
        'state_owner_token' => 1,
        'state_owner_able_to_sell' => 1,
        'time_created' => 1,
        'time_updated' => 1,
        'state' => 1,
        'operator' => 1,
        'users' => 1,
        'states' => 1,
        'full_name' => 1,
        '*' => 1,
    ];

    public function _getFullName(): string
    {
        return $this->state_owner_first_name . ' ' . $this->state_owner_last_name;
    }

    /**
     * @param string $operator_id
     * @return string|null
     */
    public function setStateOwnerOperatorId(string $operator_id): ?string
    {
        return $operator_id ?: null;
    }
}

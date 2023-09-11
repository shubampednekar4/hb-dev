<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use JeremyHarris\LazyLoad\ORM\LazyLoadEntityTrait;

/**
 * Operator Entity
 *
 * @property int|null $user_id
 * @property int|null $state_id
 * @property string $operator_id
 * @property string $operator_first_name
 * @property string $operator_last_name
 * @property string|null $operator_email
 * @property string|null $operator_phone
 * @property string|null $operator_state
 * @property string|null $operator_city
 * @property string|null $operator_address
 * @property string|null $operator_zip
 * @property string|null $operator_country
 * @property string|null $operator_token
 * @property \Cake\I18n\FrozenDate|null $date_joined
 * @property \Cake\I18n\FrozenTime|null $time_created
 * @property \Cake\I18n\FrozenTime|null $time_updated
 *
 * @property \App\Model\Entity\User|null $user
 * @property \App\Model\Entity\State|null $state
 * @property \App\Model\Entity\StateOwner[] $state_owners
 * @property \App\Model\Entity\Franchise[] $franchises
 * @property \App\Model\Entity\Report[] $reports
 * @property \Cake\ORM\Entity $supervisor
 * @property string $full_name
 * @property string $list_name
 */
class Operator extends Entity
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
        'user_id' => 1,
        'state_id' => 1,
        'operator_first_name' => 1,
        'operator_last_name' => 1,
        'operator_email' => 1,
        'operator_phone' => 1,
        'operator_state' => 1,
        'operator_city' => 1,
        'operator_address' => 1,
        'operator_zip' => 1,
        'operator_country' => 1,
        'operator_token' => 1,
        'date_joined' => 1,
        'time_created' => 1,
        'time_updated' => 1,
        'user' => 1,
        'state' => 1,
        'state_owners' => 1,
        'franchises' => 1,
        'reports' => 1,
        'full_name' => 1,
        'operator_id' => 1,
    ];

    public function _getFullName(): string
    {
        return $this->operator_first_name . ' ' . $this->operator_last_name;
    }

    public function _getListName(): string
    {
        return sprintf('%s %s (%s)', $this->operator_first_name, $this->operator_last_name, $this->operator_id);
    }
}

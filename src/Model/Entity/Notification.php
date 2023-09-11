<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Notification Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $link
 * @property string|null $attributes
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property bool $is_new
 * @property bool $sent
 *
 * @property \App\Model\Entity\User $user
 */
class Notification extends Entity
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
        'user_id' => 1,
        'title' => 1,
        'link' => 1,
        'attributes' => 1,
        'created' => 1,
        'modified' => 1,
        'is_new' => 1,
        'sent' => 1,
        'user' => 1,
    ];
}

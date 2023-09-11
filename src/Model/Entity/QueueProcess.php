<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * QueueProcess Entity
 *
 * @property int $id
 * @property string $pid
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property bool $terminate
 * @property string|null $server
 * @property string $workerkey
 */
class QueueProcess extends Entity
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
        'pid' => 1,
        'created' => 1,
        'modified' => 1,
        'terminate' => 1,
        'server' => 1,
        'workerkey' => 1,
    ];
}

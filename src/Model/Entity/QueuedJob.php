<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * QueuedJob Entity
 *
 * @property int $id
 * @property string $job_type
 * @property string|null $data
 * @property string|null $job_group
 * @property string|null $reference
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime|null $notbefore
 * @property \Cake\I18n\FrozenTime|null $fetched
 * @property \Cake\I18n\FrozenTime|null $completed
 * @property float|null $progress
 * @property int $failed
 * @property string|null $failure_message
 * @property string|null $workerkey
 * @property string|null $status
 * @property int $priority
 * @property string $job_task
 */
class QueuedJob extends Entity
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
        'job_type' => 1,
        'data' => 1,
        'job_group' => 1,
        'reference' => 1,
        'created' => 1,
        'notbefore' => 1,
        'fetched' => 1,
        'completed' => 1,
        'progress' => 1,
        'failed' => 1,
        'failure_message' => 1,
        'workerkey' => 1,
        'status' => 1,
        'priority' => 1,
    ];
}

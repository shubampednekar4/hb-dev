<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PdfJob Entity
 *
 * @property int $id
 * @property int $pdf_id
 * @property int $queued_job_id
 * @property bool $is_completed
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Pdf $pdf
 * @property \App\Model\Entity\QueuedJob $queued_job
 */
class PdfJob extends Entity
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
        'pdf_id' => 1,
        'queued_job_id' => 1,
        'is_completed' => 1,
        'created' => 1,
        'modified' => 1,
        'pdf' => 1,
        'queued_job' => 1,
    ];
}

<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use JeremyHarris\LazyLoad\ORM\LazyLoadEntityTrait;

/**
 * Pdf Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property \Cake\I18n\FrozenTime $startDate
 * @property \Cake\I18n\FrozenTime $endDate
 * @property int $user_id
 * @property bool $is_done
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\PdfGroup[] $pdf_groups
 * @property \App\Model\Entity\PdfJob[] $pdf_jobs
 */
class Pdf extends Entity
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
        'created' => 1,
        'modified' => 1,
        'startDate' => 1,
        'endDate' => 1,
        'user_id' => 1,
        'is_done' => 1,
        'user' => 1,
        'pdf_groups' => 1,
        'pdf_jobs' => 1,
    ];
}

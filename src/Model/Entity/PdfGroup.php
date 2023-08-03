<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PdfGroup Entity
 *
 * @property int $id
 * @property int $state_owner_id
 * @property int $pdf_id
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\StateOwner $state_owner
 * @property \App\Model\Entity\Pdf $pdf
 * @property \App\Model\Entity\PdfMetum[] $pdf_meta
 */
class PdfGroup extends Entity
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
        'pdf_id' => 1,
        'created' => 1,
        'modified' => 1,
        'state_owner' => 1,
        'pdf' => 1,
        'pdf_meta' => 1,
    ];
}

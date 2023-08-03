<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PdfMetum Entity
 *
 * @property int $id
 * @property string $name
 * @property string $value
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int $pdf_group_id
 *
 * @property \App\Model\Entity\Pdf $pdf
 * @property \App\Model\Entity\PdfGroup $pdf_group
 */
class PdfMetum extends Entity
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
        'name' => 1,
        'value' => 1,
        'created' => 1,
        'modified' => 1,
        'pdf_group_id' => 1,
        'pdf' => 1,
    ];
}

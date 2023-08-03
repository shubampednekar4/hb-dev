<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Panel Entity
 *
 * @property string $id
 * @property string $request_id
 * @property string|null $panel
 * @property string|null $title
 * @property string|null $element
 * @property string|null $summary
 * @property string|resource|null $content
 *
 * @property \App\Model\Entity\Request $request
 */
class Panel extends Entity
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
        'request_id' => 1,
        'panel' => 1,
        'title' => 1,
        'element' => 1,
        'summary' => 1,
        'content' => 1,
        'request' => 1,
    ];
}

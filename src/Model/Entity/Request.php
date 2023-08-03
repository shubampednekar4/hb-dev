<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Request Entity
 *
 * @property string $id
 * @property string $url
 * @property string|null $content_type
 * @property int|null $status_code
 * @property string|null $method
 * @property \Cake\I18n\FrozenTime $requested_at
 *
 * @property \App\Model\Entity\Panel[] $panels
 */
class Request extends Entity
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
        'url' => 1,
        'content_type' => 1,
        'status_code' => 1,
        'method' => 1,
        'requested_at' => 1,
        'panels' => 1,
    ];
}

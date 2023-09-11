<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Url Entity
 *
 * @property int $url_id
 * @property int $location_id
 * @property string $url_address
 * @property string $url_type
 * @property \Cake\I18n\FrozenTime|null $time_created
 * @property \Cake\I18n\FrozenTime|null $time_updated
 *
 * @property \App\Model\Entity\Location $location
 */
class Url extends Entity
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
        'location_id' => 1,
        'url_address' => 1,
        'url_type' => 1,
        'time_created' => 1,
        'time_updated' => 1,
        'location' => 1,
    ];
}

<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Rate Entity
 *
 * @property int $rate_id
 * @property int $term_id
 * @property float|null $rate_amount
 * @property \Cake\I18n\FrozenTime|null $date_created
 * @property \Cake\I18n\FrozenTime|null $date_updated
 *
 * @property \Cake\ORM\Entity $term
 */
class Rate extends Entity
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
        'term_id' => 1,
        'rate_amount' => 1,
        'date_created' => 1,
        'date_updated' => 1,
        'term' => 1,
    ];
}

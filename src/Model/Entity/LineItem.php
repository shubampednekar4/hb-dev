<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LineItem Entity
 *
 * @property int $line_item_id
 * @property int $product_id
 * @property int $commission_id
 * @property float|null $price
 * @property float|null $rate_amount
 * @property \Cake\I18n\FrozenTime|null $date_created
 * @property \Cake\I18n\FrozenTime|null $date_updated
 *
 * @property \App\Model\Entity\Product $product
 * @property \App\Model\Entity\Commission $commission
 */
class LineItem extends Entity
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
        'product_id' => 1,
        'commission_id' => 1,
        'price' => 1,
        'rate_amount' => 1,
        'date_created' => 1,
        'date_updated' => 1,
        'product' => 1,
        'commission' => 1,
    ];
}

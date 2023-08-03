<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Product Entity
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $product_id
 * @property string|null $sku
 * @property int|null $quantity
 * @property float|null $price
 * @property int $order_id
 * @property \Cake\I18n\FrozenTime|null $time_created
 * @property \Cake\I18n\FrozenTime|null $time_updated
 *
 * @property \App\Model\Entity\Product[] $products
 * @property \Cake\ORM\Entity $order
 * @property \App\Model\Entity\LineItem[] $line_items
 */
class Product extends Entity
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
        'product_id' => 1,
        'sku' => 1,
        'quantity' => 1,
        'price' => 1,
        'order_id' => 1,
        'time_created' => 1,
        'time_updated' => 1,
        'products' => 1,
        'order' => 1,
        'line_items' => 1,
    ];
}

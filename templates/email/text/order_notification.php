<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\StateOwner $state_owner
 * @var \App\Model\Entity\Operator $operator
 * @var array $order
 * @var string[] $data
 * @var array $line_items
 * @var float $commission
 */

use Cake\I18n\FrozenDate;
$date = new FrozenDate($order['date_modified']);
?>

Hello <?= $state_owner->name ?>

We just received an order from <?= $operator->name ?>. The order number is <?= $order["id"] ?> and it was made on <?= $date->format('d M Y') ?>. The total commission earned from this order is <?= $this->StringFormat->currency($commission) ?>. If you have any questions or concerns regarding this order or your commission, please reach out to our corporate office by calling (800) 359-2095. Thank you so much!

Heaven's Best Carpet Cleaning Corporate

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

<div style="background-color: #eeeeee;margin: 0;padding: 0;font-family: Roboto, Helvetica, Arial, sans-serif;color: #000001;">
    <div style="width: 1120px; max-width: 100%; margin: auto; box-shadow: 0 0 6px #343A40;">
        <div style="background-color: #479de1;color: #ffffff;font-family: Roboto, Helvetica, Arial, sans-serif;padding: 25px 50px;box-sizing: border-box;">
            <div style="display: flex;flex-flow: row nowrap;justify-content: space-between;align-items: center;width:100%">
                <div style="width: 200px;max-width: 100%;">
                    <?= $this->Html->image('https://www.heavensbest.com/heavens-best-carpet-cleaning.png', ['alt' => "heaven's best logo", 'style' => 'max-width: 100%;']) ?>
                </div>
                <div style="width: 100%;">
                    <h1 style="font-size: 70px;font-weight: 300;text-align: right">Order Notification</h1>
                </div>
            </div>
        </div>
        <div style="padding: 4rem 6rem;background-color: #ffffff;">
            <section style="background-color: #ffffff;">
                <p style="font-weight: 600;"><?= __("Hello {0}", $state_owner->full_name) ?></p>
                <p>"We just received an order from <span
                            style="color: #479de1;font-weight: 600;"><?= $operator->full_name ?></span>. The order number is
                    <span style="color: #479de1;font-weight: 600;"><?= $order['id'] ?></span> and it was made on <span
                            style="color: #479de1;font-weight: 600;"><?= $date->format('d M Y') ?></span>. The total
                    commission earned from this order is <span
                            style="color: #479de1;font-weight: 600;"><?= $this->StringFormat->currency($commission) ?></span>.
                    If you have any questions or concerns regarding this order or your commission, please reach out to
                    our corporate office by calling (800) 359-2095. Thank you so much!</p>
            </section>
            <section style="background-color: #ffffff;">
                <table style="width: 100%;border-collapse: collapse;box-sizing: border-box;">
                    <tr>
                        <th style="font-weight: 600;text-align: center;padding: 1rem;border-bottom: 2px black solid;">
                            SKU
                        </th>
                        <th style="font-weight: 600;text-align: left;padding: 1rem;border-bottom: 2px black solid;">
                            Name
                        </th>
                        <th style="font-weight: 600;text-align: center;padding: 1rem;border-bottom: 2px black solid;">
                            Quantity
                        </th>
                        <th style="font-weight: 600;padding: 1rem;border-bottom: 2px black solid;text-align: right;">
                            Price
                        </th>
                        <th style="font-weight: 600;padding: 1rem;border-bottom: 2px black solid;text-align: right;">
                            Item Total
                        </th>
                        <th style="font-weight: 600;padding: 1rem;border-bottom: 2px black solid;text-align: right;">
                            Commission
                        </th>
                    </tr>
                    <?php $rowCount = 0; ?>
                    <?php foreach ($line_items as $item): ?>
                        <tr <?= $rowCount++ % 2 == 1 ? ' style="background-color: #EBEBEB;border-bottom: 1px solid #343A40;"' : null ?>>
                            <td style="font-weight: 600;padding: 1rem;text-align: center;"><?= $item["product_id"] ?></td>
                            <td style="padding: 1rem;text-align: left;"><?= $item["name"] ?></td>
                            <td style="padding: 1rem; text-align: center"><?= $item["quantity"] ?></td>
                            <td style="padding: 1rem;text-align: right;"><?= $this->StringFormat->currency($item["price"]) ?></td>
                            <td style="padding: 1rem;text-align: right;"><?= $this->StringFormat->currency($item["total"]) ?></td>
                            <td style="padding: 1rem;text-align: right;"><?= $this->StringFormat->currency($item["commission"]) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="4"
                            style="padding: 1rem;background-color: #479de1; color: #FFFFFF; font-size: 24px; font-weight: 600;">
                            Totals
                        </td>
                        <td style="padding: 1rem;background-color: #479de1; color: #FFFFFF; font-size: 24px; font-weight: 600;text-align: right"><?= $this->StringFormat->currency($order["total"]) ?></td>
                        <td style="padding: 1rem;background-color: #479de1; color: #FFFFFF; font-size: 24px; font-weight: 600;text-align: right"><?= $this->StringFormat->currency($commission) ?></td>
                    </tr>
                </table>
            </section>
        </div>
    </div>
</div>


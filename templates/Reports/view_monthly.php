<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Report $report
 */

use App\Model\Entity\Report;
use App\View\AppView;

$this->assign('title', 'View Monthly Report');
?>

<?= $this->Html->link('<i class="fas fa-backward"></i> Go Back to All Monthly Reports', ['action' => 'viewAllMonthly'], [
    'escape' => false,
    'class' => 'btn btn-sm btn-default'
]) ?>
<?= $this->Form->postlink('<i class="fas fa-trash"></i> Delete Report', ['action' => 'delete'], [
    'escape' => false,
    'class' => 'btn btn-sm btn-danger',
    'confirm' => 'Are you sure you want to delete this item?',
]) ?>
<div class="card">
    <header class="card-header card-header-primary">
        <h2 class="card-title"><?= __($this->fetch('title')) ?></h2>
        <p class="card-category">Report Info</p>
    </header>
    <section class="card-body view-info">
        <h3 class="card-title"><?= __('Basic Information') ?></h3>
        <div class="row">
            <div class="col-lg-3 col-md-12">
                <h4 class="card-title"><?= __('Operator') ?></h4>
                <p class="card-text"><?= sprintf('%s %s (%s)', h($report->first_name), h($report->last_name), h($report->operator->operator_id)) ?></p>
                <p class="card-text"><?= h($report->address) . '<br/>' . sprintf('%s, %s %s', h($report->city), h($report->state->abbrev), $report->postal_code)?></p>
                <p class="card-text"><?= $this->Html->link(h($report->phone), 'tel:+1' . $report->phone) ?></p>
                <p class="card-text"><?= $this->Text->autoLinkEmails(h($report->email))?></p>
            </div>
            <div class="col-lg-3 col-md-12">
                <h4 class="card-title"><?= __('Franchise') ?></h4>
                <p class="card-text"><?= h($report->franchise->franchise_name) ?></p>
            </div>
            <div class="col-lg-3 col-md-12 bg-success text-white">
                <h4 class="card-title text-white"><?= __('Revenue') ?></h4>
                <p class="card-text"><span class="font-weight-bold">Carpet and Upholstery:</span> <?= $this->Number->currency(h($report->carpet_and_upholstery), 'USD') ?></p>
                <p class="card-text"><span class="font-weight-bold">Tile and Grout:</span> <?= $this->Number->currency(h($report->tile_and_grout), 'USD') ?></p>
                <p class="card-text"><span class="font-weight-bold">Fabric Protector:</span> <?= $this->Number->currency(h($report->fabric_protector), 'USD') ?></p>
                <p class="card-text"><span class="font-weight-bold">Other Sales:</span> <?= $this->Number->currency(h($report->other_sales), 'USD') ?></p>
            </div>
            <div class="col-lg-3 col-md 12 bg-danger text-white">
                <h4 class="card-title text-white"><?= __('Costs') ?></h4>
                <p class="card-text"><span class="font-weight-bold">Advertising:</span> <?= $this->Number->currency(h($report->advertising_cost), 'USD') ?></p>
            </div>
        </div>
</div>
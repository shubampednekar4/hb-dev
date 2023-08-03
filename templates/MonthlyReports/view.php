<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MonthlyReport $monthlyReport
 */

use App\Model\Entity\MonthlyReport;
use App\View\AppView;


$this->assign('title', $monthlyReport->month->format('F Y') . " Stats For \"" . $monthlyReport->franchise->franchise_name . "\"");
?>

<?= $this->Html->link('<i class="material-icons">fast_rewind</i> Go Back', 'javascript:history.back()', [
    'escape' => false,
    'class' => 'btn btn-sm btn-default'
]) ?>
<?= $this->Form->postlink('<i class="material-icons">delete</i> Delete Monthly Report', [
        'action' => 'delete',
    $monthlyReport->report_id,
], [
    'escapeTitle' => false,
    'class' => 'btn btn-sm btn-danger',
    'confirm' => sprintf('Are you sure you want to delete this the report for (%s)?', $monthlyReport->month->format('M, Y')),
]) ?>
<div class="card">
    <header class="card-header card-header-primary">
        <h2 class="card-title"><?= __($this->fetch('title')) ?></h2>
        <p class="card-category"><?= __("Monthly Stat Info") ?></p>
    </header>
    <section class="card-body">
        <h3 class="card-title"><?= __('Sales') ?></h3>
        <h4 class="card-title"><?= __('Residential') ?></h4>
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <p class="card-text">Carpet Cleaning: <?= $this->Number->currency($monthlyReport->carpet_cleaning_res, 'USD') ?></p>
            </div>
            <div class="col-lg-6 col-md-12">
                <p class="card-text">Tile & Grout: <?= $this->Number->currency($monthlyReport->tile_grout_res, 'USD') ?></p>
            </div>
        </div>
        <h4 class="card-title"><?= __("Commercial") ?></h4>
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <p class="card-text">Carpet Cleaning: <?= $this->Number->currency($monthlyReport->carpet_cleaning_comm, 'USD') ?></p>
            </div>
            <div class="col-lg-6 col-md-12">
                <p class="card-text">Tile & Grout: <?= $this->Number->currency($monthlyReport->tile_grout_comm, 'USD') ?></p>
            </div>
        </div>
        <h4 class="card-title"><?= __("Other") ?></h4>
        <div class="row">
            <div class="col-lg-3 col-md-12">
                <p class="card-text">Upholstery: <?= $this->Number->currency($monthlyReport->upholstery_cleaning, 'USD') ?></p>
            </div>
            <div class="col-lg-3 col-md-12">
                <p class="card-text">Fabric Protectant: <?= $this->Number->currency($monthlyReport->fabric_protectant, 'USD') ?></p>
            </div>
            <div class="col-lg-3 col-md-12">
                <p class="card-text">Hardwood Floors: <?= $this->Number->currency($monthlyReport->hardwood_floor, 'USD') ?></p>
            </div>
            <div class="col-lg-3 col-md-12">
                <p class="card-text">Miscellaneous: <?= $this->Number->currency($monthlyReport->miscellaneous, 'USD') ?></p>
            </div>
        </div>
        <h5 class="card-title text-success"><?= __('Receipt Total: {0}', $this->Number->currency($monthlyReport->receipt_total, 'USD')) ?></h5>
        <hr/>
        <h4 class="card-title"><?= __("Advertising") ?></h4>
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <p class="card-text">Cost: <?= $this->Number->currency($monthlyReport->advertising_cost, 'USD') ?></p>
            </div>
            <div class="col-lg-6 col-md-12">
                <p class="card-text">Percentage: <?= $this->Number->toPercentage($monthlyReport->advertising_percentage) ?></p>
            </div>
        </div>
        <?php
        echo $this->Html->link('<i class="material-icons">edit</i> Edit Monthly Report', [
            'action' => 'edit',
            $monthlyReport->report_id
        ], ['class' => 'btn btn-primary', 'escape' => false])
        ?>
    </section>
</div>
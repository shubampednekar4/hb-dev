<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Franchise[]|\Cake\Collection\CollectionInterface $franchises
 * @var string $data
 * @var int $added
 * @var int $closed
 * @var \App\Model\Entity\Franchise $latest
 */

$this->Html->script([
    'execute/franchises/common.js?v=1.0.0a',
    'execute/franchises/charts.min.js',
    'execute/franchises/buttons.min.js?v=1.0.0e',
], ['block' => true]);
?>
<?= $this->Form->control('franchise_chart_data', ['type' => 'hidden', 'value' => $data]) ?>

<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card card-stats">
            <div class="card-header card-header-success card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">business_center</i>
                </div>
                <p class="card-category">2021 Growth</p>
                <h3 class="card-title"><?= sprintf("%s Added", $added) ?></h3>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="material-icons">calculate</i>
                    37.71% reporting
                </div>
                <div class="control">
                    <button type="button" id="add_franchise_btn" class="btn btn-sm btn-success">Add Franchise</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card card-stats">
            <div class="card-header card-header-danger card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">remove_circle</i>
                </div>
                <p class="card-category">2021 Attrition</p>
                <h3 class="card-title"><?= sprintf("%s Closed", $closed) ?></h3>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="material-icons">calculate</i>
                    37.71% reporting
                </div>
                <div class="control">
                    <button type="button" id="close_franchise_btn" class="btn btn-sm btn-danger">Close Franchise</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card card-stats">
            <div class="card-header card-header-info card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">summarize</i>
                </div>
                <p class="card-category">Summary</p>
                <h3 class="card-title"><?= $this->Number->format($franchises->count()) ?> Franchises Open Currently</h3>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="material-icons">calculate</i>
                    37.71% reporting
                </div>
                <div class="control">
                    <?= $this->Html->link(__('Manage All'), ['action' => 'manage'], ['class' => 'btn btn-sm btn-info'])?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card card-stats">
            <div class="card-header card-header-warning card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">verified</i>
                </div>
                <p class="card-category">Latest Franchise Added</p>
                <h3 class="card-title"><?= $latest->franchise_name ?></h3>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="material-icons">calculate</i>
                    37.71% reporting
                </div>
                <div class="control">
                    <?= $this->Html->link('See More', [
                        'action' => 'view',
                        $latest->franchise_id
                    ], ['class' => 'btn btn-sm btn-warning']) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-sm-12">
        <div class="card card-chart">
            <div class="card-header card-header-info">
                <div class="ct-chart" id="franchises"></div>
            </div>
            <div class="card-body">
                <h4 class="card-title"><?= __('Total Franchises') ?></h4>
                <p class="card-description"><?= __('Number of Franchises Currently Active.') ?></p>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="material-icons">date_range</i>
                    <?= __('Summarized By Year') ?>
                </div>
            </div>
        </div>
    </div>
</div>



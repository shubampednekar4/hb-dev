<?php
/**
 * @var \App\View\AppView $this
 * @var $reportsIndexLink
 * @var mixed $reportsIndexLink
 * @var \App\Model\Entity\User $user
 * @var int $monthlyReportCount
 * @var int $totalReportsPossible
 * @var float $receiptTotal
 * @var float $advertisingCost
 * @var string $receiptData
 * @var string $advertisingData
 * @var float $commission_amount
 */

use App\Model\Entity\Franchise;
use App\Model\Entity\User;
use App\View\AppView;


$this->assign('title', 'Reports');
$this->Html->script([
    'execute/reports/monthly/main_menu_charts_generator.js?v1.0.9a',
    'execute/reports/commissions/commission_report.js?v1.0.0k',
], ['block' => true, 'once' => true]);
?>
<?= $this->Form->control('receipt_chart_data', ['type' => 'hidden', 'value' => $receiptData]) ?>
<?= $this->Form->control('advertising_chart_data', ['type' => 'hidden', 'value' => $advertisingData]) ?>

<div id="summaries" class="row">
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card card-stats">
            <div class="card-header card-header-warning card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">content_copy</i>
                </div>
                <p class="card-category"><?= __('Monthly Stats Completed') ?></p>
                <h3 class="card-title"><?= __('{0}/{1}', $monthlyReportCount, $totalReportsPossible) ?></h3>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <?php if (!$user->is_admin): ?>
                        <?php if ($monthlyReportCount < $totalReportsPossible): ?>
                            <i class="material-icons text-danger">warning</i>
                            <?= $this->Html->link('Missing Reports', ['action' => 'add']) ?>
                        <?php else: ?>
                            <i class="material-icons text-success">check</i>
                            <?= __("All Caught Up") ?>
                        <?php endif; ?>
                    <?php elseif ($totalReportsPossible > 0): ?>
                        <i class="material-icons">calculate</i>
                        <?= __('{0} Reporting', $this->Number->toPercentage(($monthlyReportCount / $totalReportsPossible * 100))) ?>
                    <?php else: ?>
                        <i class="material-icons">calculate</i>
                        <?= __('{0} Reporting', $this->Number->toPercentage((100))) ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card card-stats">
            <div class="card-header card-header-success card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">attach_money</i>
                </div>
                <p class="card-category"><?= __('Receipt Total') ?></p>
                <h3 class="card-title"><?= $this->Number->currency($receiptTotal, 'USD') ?></h3>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="material-icons">date_range</i>
                    <?= __('Over Last Year') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card card-stats">
            <div class="card-header card-header-danger card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">request_quote</i>
                </div>
                <p class="card-category"><?= __('Advertising Cost') ?></p>
                <h3 class="card-title"><?= $this->Number->currency($advertisingCost, 'USD') ?></h3>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="material-icons">equalizer</i>
                    <?php if ($receiptTotal !== 0): ?>
                        <?= $this->Number->toPercentage(($advertisingCost / $receiptTotal) * 100, 2) ?> <?= __('of Total Receipts') ?>
                    <?php else: ?>
                        <?= __('0% of Total Receipts') ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php if ($user->is_admin): ?>
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card card-stats">
                <div class="card-header card-header-info card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">payments</i>
                    </div>
                    <p class="card-category"><?= __('Commissions Earned By State Owners') ?></p>
                    <h3 class="card-title"><?= /*$this->Number->currency($commission_amount, 'USD')*/ "Feature Will Be In Future Release" ?></h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">date_range</i>
                        <?= __('Year To Date') ?>
                    </div>
                    <div class="actions">
                        <?= $this->Form->button('Run Commission Report', [
                            'class' => 'btn btn-small btn-info',
                            'type' => 'button',
                            'data-toggle' => 'modal',
                            'data-target' => '#commissionsReportModal'
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<div id="charts" class="row">
    <div class="col-lg-6 col-md-12">
        <div class="card card-chart">
            <div class="card-header card-header-primary">
                <div class="ct-chart" id="receipts"></div>
            </div>
            <div class="card-body">
                <h4 class="card-title"><?= __('Total Receipts') ?></h4>
                <p class="card-text"><?= __('Monthly Franchise Sales') ?></p>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="material-icons">date_range</i>
                    <?= __('Over Last Year') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-12">
        <div class="card card-chart">
            <div class="card-header card-header-danger">
                <div class="ct-chart" id="advertising"></div>
            </div>
            <div class="card-body">
                <h4 class="card-title"><?= __('Advertising Costs') ?></h4>
                <p class="card-text"><?= __('Monthly Franchise Advertising Expenditures') ?></p>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="material-icons">date_range</i>
                    <?= __('Over Last Year') ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="controls" class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header card-header-primary" data-background-color="purple">
                <h3 class="card-titl col-md-6e"><i class="far fa-calendar-alt"></i> <?= __('Monthly Stats') ?></h3>
                <p class="card-category"><?= __('Manage monthly statistics for franchise revenue and advertising costs.') ?></p>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-md-12 text-center">
                        <h4 class="card-title"><?= __('Add Monthly Stats') ?></h4>
                        <p class="card-text"><?= __('Add information regarding franchise sales revenue and advertising costs. Totals are automatically calculated.') ?></p>
                        <?= $this->Html->link('<i class="material-icons">add_circle</i> ' . __('Add Monthly Stats'), ['action' => 'add'], [
                            'class' => 'btn btn-danger',
                            'escape' => false,
                        ]) ?>
                    </div>
                    <div class="col-lg-6 col-md-12 text-center">
                        <h4 class="card-title"><?= __('Review Monthly Stats') ?></h4>
                        <p class="card-text"><?= __('Review franchise information regarding monthly sales revenue and advertising costs.') ?></p>
                        <?= $this->Html->link('<i class="material-icons">visibility</i> ' . __('Review Monthly Stats'), $reportsIndexLink, [
                            'class' => 'btn btn-primary',
                            'escape' => false,
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="commissionsReportModal" tabindex="-1" role="dialog"
     aria-labelledby="commissionsReportModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">'
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="CommissionsReportModalLabel"><?= __("Run Commissions Report") ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3><?= __("Select Time Range") ?></h3>
                <div class="form-row">
                    <div class="col-12">
                        <div class="form-group">
                            <?= $this->Form->control('start_date', [
                                'type' => 'date',
                                'label' => 'From',
                                'class' => 'form-control'
                            ]) ?>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-12">
                        <div class="form-group">
                            <?= $this->Form->control('end_date', [
                                'type' => 'date',
                                'label' => 'To',
                                'class' => 'form-control'
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <?= $this->Form->button('Run', ['class' => 'btn btn-success', 'type' => 'button', 'id' => 'sendReportBtn']) ?>
            </div>
        </div>
    </div>
</div>

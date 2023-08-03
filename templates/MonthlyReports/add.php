<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MonthlyReport $monthlyReport
 * @var Franchise[] $franchises
 * @var Operator[] $operators
 * @var \App\Model\Entity\User $user
 * @var string|null $operator_id
 * @var FrozenDate $today
 * @var int $month
 * @var string $franchise_id
 */

use App\Model\Entity\Franchise;
use App\Model\Entity\MonthlyReport;
use App\Model\Entity\Operator;
use App\Model\Entity\User;
use App\View\AppView;
use Cake\I18n\FrozenDate;

$today = $today ?? new FrozenDate();

$this->assign('title', 'Add Monthly Stats');
$this->Html->script('execute/reports/monthly/form_autofill_calculations.min.js?v1.0.5f', [
    'block' => true,
    'once' => true,
]);
?>
<?= $this->Html->link('<i class="material-icons">fast_rewind</i> Go Back', ['action' => 'main-menu'], [
    'escape' => false,
    'class' => 'btn btn-sm btn-info'
]) ?>
<div class="card">
    <header class="card-header card-header-success">
        <h2 class="card-title"><i class="material-icons">add_circle</i> <?= __($this->fetch('title')) ?></h2>
        <p class="card-category">Add New Monthly Report To The System</p>
    </header>


    <section class="card-body">
        <?= $this->Form->create($monthlyReport) ?>
        <h3 class="card-title"><?= __('Basic Information') ?></h3>
        <div class="form-row">
            <div class="col-lg-4 col-md-12">
                <div class="form-group">
                    <?= $this->Form->control('month', [
                        'class' => 'form-control',
                        'type' => 'month',
                        'value' => $today->format('Y') . '-' . $month,
                        'required',
                        'readonly' => true // Add the readonly attribute here
                    ]); ?>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="form-group" id="operator-parent">
                    <?= $this->Form->control('operator_id', [
                        'options' => $operators,
                        'empty' => '(choose one)',
                        'class' => 'form-control select2',
                        $user->user_type_name === 'operator' ? 'readonly' : null,
                        'value' => $operator_id,
                        'required',
                        'data-parent' => 'operator-parent'
                    ]); ?>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="form-group" id="state-owner-parent">
                    <?= $this->Form->control('franchise_id', [
                        'options' => $franchises,
                        'empty' => '(choose one)',
                        'class' => 'form-control select2',
                        'value' => $franchise_id,
                        'required',
                        'data-parent' => 'state-owner-parent'
                    ]); ?>
                </div>
            </div>
        </div>
        <h3 class="card-title"><?= __('Sales') ?></h3>
        <h4 class="card-title"><?= __('Residential') ?></h4>
        <div class="form-row">
            <div class="col-lg-6 col-md-12">
                <?= $this->Form->label('carpet_cleaning_res', 'Carpet Cleaning') ?>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="material-icons">attach_money</i>
                        </span>
                    </div>
                    <?= $this->Form->control('carpet_cleaning_res', [
                        'class' => 'form-control money hb-add',
                        'label' => false,
                        'value' => $monthlyReport->isEmpty('carpet_cleaning_res') ? '' : $monthlyReport->carpet_cleaning_res,
                        'placeholder' => '0',
                    ]); ?>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <?= $this->Form->label('tile_grout_res', 'Tile & Grout') ?>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="material-icons">attach_money</i>
                        </span>
                    </div>
                    <?= $this->Form->control('tile_grout_res', [
                        'class' => 'form-control money hb-add',
                        'label' => false,
                        'value' => $monthlyReport->isEmpty('title_grout_res') ? '' : $monthlyReport->tile_grout_res,
                        'placeholder' => '0',
                    ]); ?>
                </div>
            </div>
        </div>

        <h4 class="card-title"><?= __('Commercial') ?></h4>
        <div class="form-row">
            <div class="col-lg-6 col-md-12">
                <?= $this->Form->label('carpet_cleaning_comm', 'Carpet Cleaning') ?>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="material-icons">attach_money</i>
                        </span>
                    </div>
                    <?= $this->Form->control('carpet_cleaning_comm', [
                        'class' => 'form-control money hb-add',
                        'label' => false,
                        'value' => $monthlyReport->isEmpty('carpet_cleaning_comm') ? '' : $monthlyReport->carpet_cleaning_comm,
                        'placeholder' => '0',
                    ]); ?>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <?= $this->Form->label('tile_grout_comm', 'Tile & Grout') ?>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="material-icons">attach_money</i>
                        </span>
                    </div>
                    <?= $this->Form->control('tile_grout_comm', [
                        'class' => 'form-control money hb-add',
                        'label' => false,
                        'value' => $monthlyReport->isEmpty('tile_grout_comm') ? '' : $monthlyReport->tile_grout_comm,
                        'placeholder' => '0',
                    ]); ?>
                </div>
            </div>
        </div>

        <h4 class="card-title"><?= __('Other') ?></h4>
        <div class="form-row">
            <div class="col-lg-6 col-md-12">
                <?= $this->Form->label('upholstery_cleaning') ?>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="material-icons">attach_money</i>
                        </span>
                    </div>
                    <?= $this->Form->control('upholstery_cleaning', [
                        'class' => 'form-control money hb-add',
                        'label' => false,
                        'value' => $monthlyReport->isEmpty('upholstery_cleaning') ? '' : $monthlyReport->upholstery_cleaning,
                        'placeholder' => '0',
                    ]); ?>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <?= $this->Form->label('hardwood_floor') ?>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="material-icons">attach_money</i>
                        </span>
                    </div>
                    <?= $this->Form->control('hardwood_floor', [
                        'class' => 'form-control money hb-add',
                        'label' => false,
                        'value' => $monthlyReport->isEmpty('hardwood_floor') ? '' : $monthlyReport->hardwood_floor,
                        'placeholder' => '0',
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-lg-6 col-md-12">
                <?= $this->Form->label('fabric_protectant') ?>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="material-icons">attach_money</i>
                        </span>
                    </div>
                    <?= $this->Form->control('fabric_protectant', [
                        'class' => 'form-control money hb-add',
                        'label' => false,
                        'value' => $monthlyReport->isEmpty('fabric_protectant') ? '' : $monthlyReport->fabric_protectant,
                        'placeholder' => '0',
                    ]); ?>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <?= $this->Form->label('miscellaneous') ?>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="material-icons">attach_money</i>
                        </span>
                    </div>
                    <?= $this->Form->control('miscellaneous', [
                        'class' => 'form-control money hb-add',
                        'label' => false,
                        'value' => $monthlyReport->isEmpty('miscellaneous') ? '' : $monthlyReport->miscellaneous,
                        'placeholder' => '0',
                    ]); ?>
                </div>
            </div>
        </div>

        <h4 class="card-title"><?= __('Summary') ?></h4>
        <div class="form-row">
            <div class="col">
                <?= $this->Form->label('receipt_total') ?>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="material-icons">attach_money</i>
                        </span>
                    </div>
                    <?= $this->Form->control('receipt_total', [
                        'class' => 'form-control',
                        'readonly',
                        'label' => false,
                        'value' => $monthlyReport->isEmpty('receipt_total') ? '' : $monthlyReport->receipt_total,
                        'placeholder' => '0',
                    ]); ?>
                </div>
            </div>
        </div>

        <h3 class="card-title"><?= __('Advertising') ?></h3>
        <div class="form-row">
            <div class="col-lg-6 col-md-12">
                <?= $this->Form->label('advertising_cost', 'Cost') ?>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="material-icons">attach_money</i>
                        </span>
                    </div>
                    <?= $this->Form->control('advertising_cost', [
                        'class' => 'form-control money',
                        'label' => false,
                        'value' => $monthlyReport->isEmpty('advertising_cost') ? '' : $monthlyReport->advertising_cost,
                        'placeholder' => '0',
                    ]); ?>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="form-group">
                    <?= $this->Form->control('advertising_percentage', [
                        'class' => 'form-control mt-4',
                        'readonly',
                        'label' => ['text' => 'Percentage', 'style' => 'top:-20px'],
                        'value' => $monthlyReport->isEmpty('advertising_percentage') ? '0' : $monthlyReport->advertising_percentage,
                    ]); ?>
                </div>
            </div>
        </div>


        <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-success']) ?>
        <?= $this->Form->end() ?>
    </section>
</div>

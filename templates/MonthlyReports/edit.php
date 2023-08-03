<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MonthlyReport $monthlyReport
 * @var Franchise[] $franchises
 * @var Operator[] $operators
 * @var \App\Model\Entity\User $user
 * @var string|null $operator_id
 * @var FrozenDate $today
 */

use App\Model\Entity\Franchise;
use App\Model\Entity\MonthlyReport;
use App\Model\Entity\Operator;
use App\Model\Entity\User;
use App\View\AppView;
use Cake\I18n\FrozenDate;

$today = $today ?? new FrozenDate();

$this->assign('title', 'Edit Monthly Stats');
$this->Html->script('execute/reports/monthly/form_autofill_calculations.min.js?v1.0.5f', [
    'block' => true,
    'once' => true,
]);
?>
<?= $this->Html->link('<i class="material-icons">fast_rewind</i> Go Back', 'javascript:history.back()', [
    'escape' => false,
    'class' => 'btn btn-sm btn-info'
]) ?>
<?= $this->Html->link(__('<i class="material-icons">list</i> All Monthly Stats'), ['action' => 'index'], [
    'escape' => false,
    'class' => 'btn btn-sm btn-primary',
]) ?>
<?= $this->Form->postLink('<i class="material-icons">delete</i> Delete Monthly Stats', ['action' => 'delete', $monthlyReport->report_id], [
    'escape' => false,
    'class' => 'btn btn-sm btn-danger',
    'confirm' => 'Are you sure you want to delete this Monthly Report?'
]) ?>

<div class="card">
    <header class="card-header card-header-success">
        <h2 class="card-title"><i class="material-icons">edit</i> <?= __($this->fetch('title')) ?></h2>
        <p class="card-category">Edit Existing Monthly Stats</p>
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
                        'required'
                    ]); ?>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="form-group">
                    <?php if ($user->is_operator): ?>
                        <?= $this->Form->control('Operator', [
                            'type' => 'text',
                            'readonly',
                            'class' => 'form-control',
                            'value' => $user->is_operator ? $user->user_first_name . ' ' . $user->user_last_name : null,
                        ]) ?>
                        <?= $this->Form->control('operator_id', [
                            'type' => 'hidden',
                            'required'
                        ]); ?>
                    <?php else: ?>
                        <?= $this->Form->control('operator_id', [
                            'options' => $operators,
                            'empty' => '(choose one)',
                            'class' => 'form-control single-select',
                            'required'
                        ]); ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="form-group">
                    <?= $this->Form->control('franchise_id', [
                        'options' => $franchises,
                        'empty' => '(choose one)',
                        'class' => 'form-control single-select',
                        'required'
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
                        'required'
                    ]); ?>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <?= $this->Form->label('title_grout_res', 'Tile & Grout') ?>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="material-icons">attach_money</i>
                        </span>
                    </div>
                    <?= $this->Form->control('tile_grout_res', [
                        'class' => 'form-control money hb-add',
                        'label' => false,
                        'required'
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
                        'required'
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
                        'required'
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
                        'required'
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
                        'required'
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
                        'required'
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
                        'required'
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
                        'required'
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
                        'required'
                    ]); ?>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="form-group">
                    <?= $this->Form->control('advertising_percentage', [
                        'class' => 'form-control',
                        'readonly',
                        'label' => 'Percentage',
                        'required',
                    ]); ?>
                </div>
            </div>
        </div>


        <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-success']) ?>
        <?= $this->Form->end() ?>
    </section>
</div>


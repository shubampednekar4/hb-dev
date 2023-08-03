<?php

/**
 * @var \App\View\AppView $this
 * @var User $user
 * @var \App\Model\Entity\Operator $operator
 * @var State[] $states
 * @var Franchise[] $franchises
 */

use App\Model\Entity\Franchise;
use App\Model\Entity\Operator;
use App\Model\Entity\State;
use App\Model\Entity\User;
use App\View\AppView;

$this->assign('title', 'Create Monthly Report');
?>
<?= $this->Html->link('<i class="fas fa-backward"></i> ' . __('Go Back'), ['action' => 'index'], [
    'class' => 'btn btn-sm btn-info',
    'escape' => false,
]) ?>
    <h2><i class="far fa-calendar-alt"></i> <?= __($this->fetch('title')) ?></h2>

<?= $this->Form->create($operator) ?>
    <article class="card mb-5">
        <header class="card-header card-header-primary">
            <h3 class="card-title"><i class="fas fa-table"></i> <?= __('Report Data') ?></h3>
            <p class="card-category"><?= __('Information about how well the franchise did this month.') ?></p>
        </header>
        <section class="card-body">
            <div class="form-row">
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <?= $this->Form->label('month') ?>
                        <?= $this->Form->month('month', [
                            'class' => 'form-control',
                        ]) ?>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <?= $this->Form->control('franchise_id', [
                            'class' => 'form-control single-select',
                            'empty' => __('(choose one)'),
                            'label' => __('Franchise'),
                            'type' => 'select',
                            'required',
                        ]) ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h4><?= __('Sales Numbers') ?></h4>
                </div>
            </div>
            <div class="form-row">
                <div class="col-lg-6 col-md-12">
                    <?= $this->Form->label('carpet_and_upholstery') ?>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-dollar-sign text-success"></i>
                            </span>
                        </div>
                        <?= $this->Form->control('carpet_and_upholstery', [
                            'type' => 'number',
                            'class' => 'form-control money',
                            'min' => '0',
                            'step' => '0.01',
                            'required',
                            'label' => false,
                        ]) ?>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <?= $this->Form->label('tile_and_grouting') ?>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-dollar-sign text-success"></i>
                            </span>
                        </div>
                        <?= $this->Form->control('tile_and_grouting', [
                            'type' => 'number',
                            'class' => 'form-control money',
                            'min' => '0',
                            'step' => '0.01',
                            'required',
                            'label' => false,
                        ]) ?>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-lg-6 col-md-12">
                    <?= $this->Form->label('fabric_protector') ?>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-dollar-sign text-success"></i>
                            </span>
                        </div>
                        <?= $this->Form->control('fabric_protector', [
                            'type' => 'number',
                            'class' => 'form-control money',
                            'min' => '0',
                            'step' => '0.01',
                            'required',
                            'label' => false,
                        ]) ?>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <?= $this->Form->label('other_sales') ?>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-dollar-sign text-success"></i>
                            </span>
                        </div>
                        <?= $this->Form->control('other_sales', [
                            'type' => 'number',
                            'class' => 'form-control money',
                            'min' => '0',
                            'step' => '0.01',
                            'required',
                            'label' => false,
                        ]) ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h4><?= __('Advertising Numbers') ?></h4>
                </div>
            </div>
            <div class="form-row">
                <div class="col">
                    <?= $this->Form->label('advertising_cost') ?>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-dollar-sign text-danger"></i>
                            </span>
                        </div>
                        <?= $this->Form->control('advertising_cost', [
                            'type' => 'number',
                            'class' => 'form-control money',
                            'min' => '0',
                            'step' => '0.01',
                            'required',
                            'label' => false,
                        ]) ?>
                    </div>
                </div>
            </div>
        </section>
    </article>
<?= $this->Form->submit(__('Submit'), ['class' => 'btn btn-success']) ?>
<?= $this->Form->end(); ?>
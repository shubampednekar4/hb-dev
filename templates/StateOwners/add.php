<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\StateOwner $stateOwner
 * @var mixed $states
 * @var Operator[]|Collection $operators
 */

use App\Model\Entity\Operator;
use App\Model\Entity\StateOwner;
use App\View\AppView;
use Cake\Database\Schema\Collection;

$this->assign('title', 'Add State Owner');
?>
<?= $this->Html->link('<i class="material-icons">fast_rewind</i> Go Back', ['action' => 'index',], [
    'escape' => false,
    'class' => 'btn btn-sm btn-info'
]) ?>
<div class="card">
    <header class="card-header card-header-warning">
        <h2 class="card-title"><i class="material-icons">add_circle</i> <?= __($this->fetch('title')) ?></h2>
        <p class="card-category"><?= __('Add New State Owner To The System') ?></p>
    </header>
    <section class="card-body">
        <?= $this->Form->create($stateOwner) ?>
        <h3 class="card-title"><?= __('Contact') ?></h3>
        <div class="form-row">
            <div class="col-lg-6 col-md-12">
                <div class="form-group">
                    <?= $this->Form->control('state_owner_first_name', [
                        'class' => 'form-control',
                        'label' => 'First Name',
                    ]); ?>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="form-group">
                    <?= $this->Form->control('state_owner_last_name', [
                        'class' => 'form-control',
                        'label' => 'Last Name',
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-lg-6 col-md-12">
                <div class="form-group">
                    <?= $this->Form->control('state_owner_email', [
                        'class' => 'form-control',
                        'label' => 'Email',
                    ]); ?>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="form-group">
                    <?= $this->Form->control('state_owner_phone', [
                        'class' => 'form-control',
                        'label' => 'Phone',
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-12">
                <div class="form-group">
                    <?= $this->Form->control('state_owner_address', [
                        'class' => 'form-control',
                        'label' => 'Street Address',
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-lg-4 col-md-12">
                <div class="form-group">
                    <?= $this->Form->control('state_owner_city', [
                        'class' => 'form-control',
                        'label' => 'City',
                    ]); ?>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="form-group" id="state-id-parent">
                    <?= $this->Form->control('state_id', [
                        'class' => 'form-control select2',
                        'label' => 'State',
                        'data-parent' => 'state-id-parent'
                    ]); ?>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="form-group">
                    <?= $this->Form->control('state_owner_zip', [
                        'class' => 'form-control',
                        'label' => 'Zip/Postal Code',
                    ]); ?>
                </div>
            </div>
        </div>
        <h3 class="card-title"><?= __('System') ?></h3>
        <div class="form-row">
            <div class="col-lg-4 col-md-12">
                <div class="form-group" id="states-ids-parent">
                    <?= $this->Form->control('states._ids', [
                        'options' => $states,
                        'class' => 'form-control select2',
                        'multiple' => true,
                        'label' => 'Managed States',
                        'data-parent' => 'states-ids-parent',
                    ]); ?>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="form-group" id="state-owner-operator-id-parent">
                    <?= $this->Form->control('state_owner_operator_id', [
                        'class' => 'form-control select2',
                        'options' => $operators,
                        'empty' => __('(none)'),
                        'label' => __('Operator'),
                        'data-parent' => 'state-owner-operator-id-parent'
                    ]); ?>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="form-group" id="user-id-parent">
                    <?= $this->Form->control('user_id', [
                        'class' => 'form-control select2',
                        'empty' => '(none)',
                        'data-parent' => 'user-id-parent'
                    ]); ?>
                </div>
            </div>
        </div>
        <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-success']) ?>
        <?= $this->Form->end() ?>
    </section>
</div>

<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\StateOwner $stateOwner
 * @var State[]|Collection $states
 * @var State[]|Collection $multipleStates
 * @var Operator[]|Collection $operators
 * @var User[]|Collection $users
 */

use App\Model\Entity\Operator;
use App\Model\Entity\State;
use App\Model\Entity\StateOwner;
use App\Model\Entity\User;
use App\View\AppView;
use Cake\Database\Schema\Collection;

$this->assign('title', __('Edit State Owner'));
?>
<?= $this->Html->link('<i class="material-icons">fast_rewind</i> ' . __('Go Back'), ['action' => 'view', $stateOwner->state_owner_id], [
    'escape' => false,
    'class' => 'btn btn-sm btn-info'
]) ?>
<?= $this->Html->link('<i class="material-icons">list</i> ' . __('All State Owners'), ['action' => 'index'], [
    'escape' => false,
    'class' => 'btn btn-sm btn-primary',
]) ?>
<?= $this->Form->postLink('<i class="material-icons">delete</i> ' . __( 'Delete State Owner'), ['action' => 'delete', $stateOwner->state_owner_id], [
    'escape' => false,
    'class' => 'btn btn-sm btn-danger',
    'confirm' => __('Are you sure you want to delete this State Owner?')
]) ?>
<div class="card">
    <div class="card-header card-header-warning">
        <h2 class="card-title"><i class="material-icons">edit</i> <?= __($this->fetch('title')) ?></h2>
        <p class="card-category"><?= __('Alter State Owner Info') ?></p>
    </div>
    <div class="card-body">
        <?= $this->Form->create($stateOwner) ?>
        <h3><?= __('Contact') ?></h3>
        <div class="form-row">
            <div class="col-lg-6 col-md-12">
                <div class="form-group">
                    <?= $this->Form->control('state_owner_first_name', [
                        'class' => 'form-control',
                        'label' => __('First Name'),
                    ]); ?>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="form-group">
                    <?= $this->Form->control('state_owner_last_name', [
                        'class' => 'form-control',
                        'label' => __('Last Name'),
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-lg-6 col-md-12">
                <div class="form-group">
                    <?= $this->Form->control('state_owner_email', [
                        'class' => 'form-control',
                        'label' => __('Email'),
                    ]); ?>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="form-group">
                    <?= $this->Form->control('state_owner_phone', [
                        'class' => 'form-control',
                        'label' => __('Phone'),
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-12">
                <div class="form-group">
                    <?= $this->Form->control('state_owner_address', [
                        'class' => 'form-control',
                        'label' => __('Street Address'),
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-lg-4 col-md-12">
                <div class="form-group">
                    <?= $this->Form->control('state_owner_city', [
                        'class' => 'form-control',
                        'label' => __('City'),
                    ]); ?>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="form-group" id="state-id-parent">
                    <?= $this->Form->control('state_id', [
                        'class' => 'form-control select2',
                        'label' => __('State'),
                        'data-parent' => 'state-id-parent'
                    ]); ?>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="form-group">
                    <?= $this->Form->control('state_owner_zip', [
                        'class' => 'form-control',
                        'label' => __('Zip/Postal Code'),
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h3><?= __('System') ?></h3>
            </div>
        </div>
        <div class="form-row">
            <div class="col-lg-4 col-md-12">
                <div class="form-group" id="states-ids-parent">
                    <?= $this->Form->control('States._state_ids', [
                        'options' => $multipleStates,
                        'class' => 'form-control select2',
                        'multiple' => true,
                        'label' => __('Managed States'),
                        'data-parent' => 'states-ids-parent'
                    ]); ?>
                </div>
                <p class="card-text text-info small"><?= __('Note: If the state you need to assign to the state owner is not showing, it is likely assigned to another state owner already.') ?></p>
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
                            'options' => $users,
                        'class' => 'form-control select2',
                        'empty' => __('(none)'),
                        'label' => __('User'),
                        'data-parent' => 'user-id-parent'
                    ]) ?>
                </div>
            </div>
        </div>
        <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-success']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>

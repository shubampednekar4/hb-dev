<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Operator $operator
 * @var mixed $states
 * @var mixed $users
 * @var mixed $stateOptions
 * @var mixed $countryOptions
 */

use App\Model\Entity\Operator;
use App\View\AppView;

$this->assign('title', 'Edit Operator');
?>
<?= $this->Html->link('<i class="material-icons">fast_rewind</i> Go Back', ['action' => 'view', $operator->operator_id], [
    'escape' => false,
    'class' => 'btn btn-sm btn-default'
]) ?>
<?= $this->Html->link(__('<i class="material-icons">list</i> All Operators'), ['action' => 'index'], [
    'escape' => false,
    'class' => 'btn btn-sm btn-primary',
]) ?>
<?= $this->Form->postLink('<i class="material-icons">delete</i> Delete Operator', ['action' => 'delete', $operator->operator_id], [
    'escape' => false,
    'class' => 'btn btn-sm btn-danger',
    'confirm' => 'Are you sure you want to delete this Operator?'
]) ?>
<div class="card">
    <header class="card-header card-header-danger">
        <h2 class="card-title"><i class="material-icons">edit</i> <?= __($this->fetch('title')) ?></h2>
        <p class="card-category">Alter Operator Info</p>
    </header>


    <section class="card-body">
        <?= $this->Form->create($operator) ?>
        <h3>Contact</h3>
        <div class="row">
            <div class="form-group col-md-6 col-sm-12">
                <?= $this->Form->control('operator_first_name', [
                    'class' => 'form-control',
                    'label' => 'First Name',
                ]); ?>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <?= $this->Form->control('operator_last_name', [
                    'class' => 'form-control',
                    'label' => 'Last Name',
                ]); ?>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6 col-sm-12">
                <?= $this->Form->control('operator_email', [
                    'class' => 'form-control',
                    'label' => 'Email Name',
                    'type' => 'email',
                ]); ?>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <?= $this->Form->control('operator_phone', [
                    'class' => 'form-control',
                    'type' => 'tel',
                    'label' => 'Phone Number',
                    'pattern' => '\d{3}[\-]\d{3}[\-]\d{4}'
                ]); ?>
            </div>
        </div>

        <h3>Address</h3>
        <div class="row">
            <div class="form-group col">
                <?= $this->Form->control('operator_address', [
                    'class' => 'form-control',
                    'label' => 'Street Address',
                ]); ?>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4 col-sm-12">
                <?= $this->Form->control('operator_city', [
                    'class' => 'form-control',
                    'label' => 'City',
                ]); ?>
            </div>
            <div class="form-group col-md-4 col-sm-12" id="operator-state-parent">
                <?= $this->Form->control('operator_state', [
                    'class' => 'form-control select2',
                    'label' => 'State',
                    'options' => $stateOptions,
                    'empty' => '(choose one)',
                    'data-parent' => 'operator-state-parent'
                ]); ?>
            </div>
            <div class="form-group col-md-4 col-sm-12">
                <?= $this->Form->control('operator_zip', [
                    'class' => 'form-control',
                    'label' => 'Zip/Postal Code',
                ]); ?>
            </div>
        </div>
        <div class="row">
            <div class="form-group col col-sm-12" id="operator-country-parent">
                <?= $this->Form->control('operator_country', [
                    'class' => 'form-control select2',
                    'label' => 'Country',
                    'options' => $countryOptions,
                    'empty' => '(choose one)',
                    'data-parent' => 'operator-country-parent'
                ]); ?>
            </div>
        </div>

        <h3>System</h3>
        <div class="row">
            <div class="form-group col-md-6 col-sm-12" id="state-id-parent">
                <?= $this->Form->control('state_id', [
                    'label' => 'Franchise State',
                    'options' => $states,
                    'empty' => '(choose one)',
                    'class' => 'form-control select2',
                    'data-parent' => 'state-id-parent'
                ]); ?>
            </div>
            <div class="form-group col-md-6 col-sm-12" id="user-id-parent">
                <?= $this->Form->control('user_id', [
                    'options' => $users,
                    'empty' => '(none)',
                    'class' => 'form-control select2',
                    'data-parent' => 'user-id-parent',
                ]); ?>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6 col-sm-12">
                <?= $this->Form->control('operator_id', [
                    'label' => 'Operator ID',
                    'type' => 'text',
                    'class' => 'form-control',
                    'maxlength' => 5,
                ]) ?>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <?= $this->Form->control('date_joined', [
                    'empty' => true,
                    'class' => 'form-control',
                ]); ?>
            </div>
        </div>

        <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-success']) ?>
        <?= $this->Form->end() ?>
    </section>
</div>

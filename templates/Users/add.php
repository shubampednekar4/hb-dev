<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var mixed $operators
 * @var mixed|StateOwner[] $stateOwners
 * @var mixed|UserType[] $userTypeOptions
 * @var mixed|State[] $states
 * @var mixed|Country[] $countries
 * @var mixed|User[] $users
 */

use App\Model\Entity\Country;
use App\Model\Entity\State;
use App\Model\Entity\StateOwner;
use App\Model\Entity\User;
use App\Model\Entity\UserType;
use App\View\AppView;

$this->assign('title', __('Add New User'));
$this->Html->script(['execute/users/user_connection_selection'], ['block' => true]);
?>

<?= $this->Html->link(__('<i class="material-icons">list</i> All Users'), ['action' => 'index'], [
    'escape' => false,
    'class' => 'btn btn-sm btn-info',
]) ?>
<div class="card">
    <div class="card-header card-header-primary">
        <h2 class="card-title"><?= __($this->fetch('title')) ?></h2>
        <p class="card-category"><?= __('Add a new user to the system.') ?> </p>
    </div>
    <div class="card-body">
        <?= $this->Form->create($user) ?>
        <div class="form-row">
            <div class="col-lg-6 col-md-12">
                <div class="form-group">
                    <?= $this->Form->control('user_first_name', [
                        'class' => 'form-control',
                        'label' => __('First Name'),
                        'required',
                    ]) ?>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="form-group">
                    <?= $this->Form->control('user_last_name', [
                        'class' => 'form-control',
                        'label' => __('Last Name'),
                        'required',
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-lg-6 col-md-12">
                <div class="form-group">
                    <?= $this->Form->control('user_email', [
                        'class' => 'form-control',
                        'label' => __('Email'),
                        'type' => 'email',
                        'required',
                    ]) ?>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="form-group" id="authority-parent">
                    <?= $this->Form->control('authority', [
                        'type' => 'select',
                        'options' => $userTypeOptions,
                        'class' => 'form-control select-2',
                        'empty' => __('(choose one)'),
                        'label' => __('User Type'),
                        'data-parent' => 'authority-parent'
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="form-group">
                    <?= $this->Form->control('user_username', [
                        'class' => 'form-control',
                        'label' => 'Username',
                        'required',
                    ]) ?>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="form-group">
                    <?= $this->Form->control('user_password', [
                        'class' => 'form-control',
                        'label' => 'Password',
                        'type' => 'password',
                        'autofill' => 'new_password',
                        'required',
                    ]) ?>
                </div>
            </div>
        </div>
        <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-success']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>

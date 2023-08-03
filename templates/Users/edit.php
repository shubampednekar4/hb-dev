<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var mixed $operators
 * @var mixed $stateOwners
 * @var array $userTypeOptions
 * @var User $actor
 * @var User $currentUser
 */

use App\Model\Entity\User;
use App\View\AppView;

$this->assign('title', __('Edit User "{0} {1}"', $user->user_first_name, $user->user_last_name));
?>

<?= $this->Html->link('<i class="material-icons">visibility</i> ' . $user->user_first_name . " " . $user->user_last_name, ['action' => 'view', $user->user_id], [
    'escape' => false,
    'class' => 'btn btn-sm btn-primary'
]) ?>
<?php if ($currentUser->is_admin): ?>
    <?= $this->Html->link('<i class="material-icons">list</i> All Users', ['action' => 'index'], [
        'escape' => false,
        'class' => 'btn btn-sm btn-info'
    ]) ?>
    <?= $this->Form->postLink('<i class="material-icons">delete</i> Delete User', ['action' => 'delete'], [
        'escape' => false,
        'class' => 'btn btn-sm btn-danger',
        'confirm' => 'Are you sure you want to delete this user?'
    ]) ?>
<?php endif; ?>

<div class="card">
    <header class="card-header card-header-primary">
        <h2><i class="material-icons">edit</i> <?= __($this->fetch('title')) ?></h2>
        <p>Alter user information.</p>
    </header>
    <section class="card-body">
        <?= $this->Form->create($user, ['autofill' => 'off']) ?>
        <div class="form-row">
            <div class="col-lg-6 col-md-12">
                <div class="form-group">
                    <?= $this->Form->control('user_first_name', [
                        'class' => 'form-control',
                        'label' => 'First Name',
                        'required',
                    ]) ?>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="form-group">
                    <?= $this->Form->control('user_last_name', [
                        'class' => 'form-control',
                        'label' => 'Last Name',
                        'required',
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-lg-6 col-md-12">
                <div class="form-group">
                    <div class="input-group"></div>
                    <?= $this->Form->control('user_email', [
                        'class' => 'form-control',
                        'label' => 'Email',
                        'type' => 'email',
                        'required',
                    ]) ?>
                </div>
            </div>
            <?php if ($actor->is_admin): ?>
            <div class="col-lg-6 col-md-12">
                <div class="form-group">
                <?= $this->Form->select('authority', ['' => 'User Types'] + $userTypeOptions, ['class' => 'form-control']) ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <div class="form-row">
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
                        'value' => '',
                        'autofill' => 'new-password',
                        'required' => false
                    ]) ?>
                </div>
            </div>
        </div>
        <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-success']) ?>
        <?= $this->Form->end() ?>
    </section>
</div>
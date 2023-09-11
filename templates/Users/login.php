<?php
/**
 * @var \App\View\AppView $this
 */

$this->assign('title', "Login");
$this->Html->script('site/show_password.min.js?v=1.0.1', ['block' => true]);
?>
<div class="card">
    <div class="card-header card-header-primary">
        <h2><?= $this->fetch('title') ?></h2>
        <p class="category"><?= __("Enter your username or email address with your password to sign in.") ?></p>
    </div>
    <div class="card-body">
        <?= $this->Flash->render() ?>
        <?= $this->Form->create() ?>
        <div class="form-group">
            <?= $this->Form->control('login', [
                'label' => 'Email Address or Username',
                'class' => 'form-control',
                'required'
            ]) ?>
        </div>
        <div class="form-group">
            <?= $this->Form->control('password', [
                'class' => 'form-control',
                'required'
            ]) ?>
            <?= $this->Form->button("Show Password", ['class' => 'btn btn-sm btn-primary', 'type' => 'button', 'id' => 'showPassword']) ?>
        </div>
        <div class="form-group">
            <?= $this->Form->checkbox('remember_me', ['id' => 'remember_me', 'checked']) ?>
            <label for="rememberMe">Remember Me</label>
        </div>
        <?= $this->Form->button('Log In', ['class' => 'btn btn-success', 'type' => 'submit']) ?>
        <?= $this->Html->link('Forgot Password', ['action' => 'forgotPassword'], ['class' => 'btn btn-danger']) ?>
        <?= $this->Form->end(); ?>
    </div>
</div>
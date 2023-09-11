<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $currentUser
 */

use App\Model\Entity\User;
use App\View\AppView;

$this->assign('title', "Heaven's Best Web App");
$this->Html->script('build/site.bundle.js?v=1.0.0a', ['block' => true]);
?>
<h2><?= __("Hello {0}! Welcome to the Heaven's Best App.", $currentUser->user_first_name) ?></h2>
<p class="lead"><?= __('Please choose one of the following to get started.') ?></p>
<div class="row">
    <?php if ($currentUser->has_manage_access): ?>
    <div class="col-lg-6 col-md-12">
        <div class="card">
            <div class="card-header card-header-image">
                <?= $this->Html->link($this->Html->image('navigation/operators.jpg', [
                    'class' => 'img-fluid card-img'
                ]), [
                    'controller' => 'Operators', 'action' => 'index'
                ], [
                    'escapeTitle' => false,
                ]) ?>
                <h3 class="card-title">Operators</h3>
            </div>
            <div class="card-body">
                <p class="card-text">Manage all operators and their information. This is also where you can associate a
                    user with an operator.</p>
                <?= $this->Html->link('Go To All Operators', ['controller' => 'Operators', 'action' => 'index'], ['class' => 'btn btn-lg btn-primary']) ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php if ($currentUser->is_admin): ?>
    <div class="col-lg-6 col-md-12">
        <div class="card">
            <div class="card-header card-header-image">
                <?= $this->Html->link($this->Html->image('navigation/state_owners.jpg', [
                    'class' => 'img-fluid card-img'
                ]), [
                    'controller' => 'StateOwners', 'action' => 'index'
                ], [
                    'escapeTitle' => false,
                ]) ?>
                <h3 class="card-title">State Owners</h3>
            </div>
            <div class="card-body">
                <p class="card-text">Manage all state owners and their information. This is also where you can associate a user with a
                    state owner.</p>
                <?= $this->Html->link('Go To All State Owners', ['controller' => 'StateOwners', 'action' => 'index'], ['class' => 'btn btn-lg btn-primary']) ?>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-12">
        <div class="card">
            <div class="card-header card-header-image">
                <?= $this->Html->link($this->Html->image('navigation/users.jpg', [
                    'class' => 'img-fluid card-img'
                ]), [
                    'controller' => 'Users', 'action' => 'index'
                ], [
                    'escapeTitle' => false,
                ]) ?>
                <h3 class="card-title">Users</h3>
            </div>
            <div class="card-body">
                <p class="card-text">Manage all users and their information. This includes their usernames, passwords, and other data.</p>
                <?= $this->Html->link('Go To All Users', ['controller' => 'Users', 'action' => 'index'], ['class' => 'btn btn-lg btn-primary']) ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <div class="col-lg-6 col-md-12">
        <div class="card">
            <div class="card-header card-header-image">
                <?= $this->Html->link($this->Html->image('navigation/reports.jpg', [
                    'class' => 'img-fluid card-img'
                ]), [
                    'controller' => 'MonthlyReports', 'action' => 'mainMenu'
                ], [
                    'escapeTitle' => false,
                ]) ?>
                <h3 class="card-title">Reports</h3>
            </div>
            <div class="card-body">
                <p class="card-text">Add, review, edit, and remove reports from the system. This includes monthly franchise reports, and commission reports.</p>
                <?= $this->Html->link('Go To Reports', ['controller' => 'MonthlyReports', 'action' => 'mainMenu'], ['class' => 'btn btn-lg btn-primary']) ?>
            </div>
        </div>
    </div>
</div>
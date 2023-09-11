<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\State $state
 * @var mixed $countries
 */

$this->assign('title', 'Edit State');
?>
<?= $this->Html->link('<i class="fas fa-backward"></i> Go Back', ['action' => 'view', $state->state_id], [
    'escape' => false,
    'class' => 'btn btn-sm btn-default'
]) ?>
<?= $this->Html->link(__('<i class="fas fa-list-ul"></i> All States'), ['action' => 'index'], [
    'escape' => false,
    'class' => 'btn btn-sm btn-primary',
]) ?>
<?= $this->Form->postLink('<i class="fas fa-trash"></i> Delete State', ['action' => 'delete', $state->state_id], [
    'escape' => false,
    'class' => 'btn btn-sm btn-danger',
    'confirm' => 'Are you sure you want to delete this State?'
]) ?>
<div class="card">
    <header class="card-header card-header-primary">
        <h2 class="card-title"><i class="fas fa-edit"></i> <?= __($this->fetch('title')) ?></h2>
            <p class="card-category">Alter State Info</p>
        </header>
    

    <section class="card-body">
        <?= $this->Form->create($state, ['autofill' => 'off']) ?>
            <div class="form-group">
            <?= $this->Form->control('full_name', [
                'class' => 'form-control',
            ]); ?>
        </div>
        
        <div class="form-group">
            <?= $this->Form->control('abbrev', [
                'class' => 'form-control',
            ]); ?>
        </div>
        
        <div class="form-group">
            <?= $this->Form->control('country_id', [
                'options' => $countries,
                'empty' => true,
                'class' => 'form-control',
            ]); ?>
        </div>
        
        <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-success']) ?>
        <?= $this->Form->end() ?>
    </section>
</div>

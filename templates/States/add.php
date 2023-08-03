<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\State $state
 * @var mixed $countries
 */

$this->assign('title', 'Add State');
?>
<?= $this->Html->link('<i class="fas fa-backward"></i> Go Back', ['action' => 'index', $state->state_id], [
'escape' => false,
'class' => 'btn btn-sm btn-default'
]) ?>
<div class="card">
    <header class="card-header card-header-primary">
        <h2 class="card-title"><i class="fas fa-edit"></i> <?= __($this->fetch('title')) ?></h2>
            <p class="card-category">Add New State To The System</p>
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

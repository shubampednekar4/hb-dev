<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\State $state
 */

$this->assign('title', 'View State');
?>

<?= $this->Html->link('<i class="fas fa-backward"></i> Back State', ['action' => 'index'], [
    'escape' => false,
    'class' => 'btn btn-sm btn-default'
]) ?>
<?= $this->Form->postlink('<i class="fas fa-trash"></i> Delete State', ['action' => 'delete'], [
    'escape' => false,
    'class' => 'btn btn-sm btn-danger',
    'confirm' => 'Are you sure you want to delete this item?',
]) ?>
<div class="card">
    <header class="card-header card-header-primary">
        <h2 class="card-title"><?= __($this->fetch('title')) ?></h2>
        <p class="card-category">State Info</p>
    </header>
    <section class="card-body view-info">
                                        
                                            <!-- todo: get new icon and remove the title -->
        <div class="view-info-container">
            <!-- todo: get new icon -->
            <p class="view-info text-muted">
                <i class="fas fa-question"><?= __('Full Name') ?></i> <?= h($state->full_name) ?>
            </p>
        </div>
                                                    <!-- todo: get new icon and remove the title -->
        <div class="view-info-container">
            <!-- todo: get new icon -->
            <p class="view-info text-muted">
                <i class="fas fa-question"><?= __('Abbrev') ?></i> <?= h($state->abbrev) ?>
            </p>
        </div>
                                                                        <!-- todo: get new icon and remove the title -->
        <div class="view-info-container">
            <p class="view-info text-muted">
                <i class="fas fa-question"><?= __('Country') ?></i> <?= $state->
                has('country') ? $this->Html->link($state->country
                ->full_name, ['controller' => 'Countries', 'action' =>
                'view', $state->country->country_id]) : '' ?>
            </p>
        </div>
                                                                        <!-- todo: get new icon and remove the title -->
        <div class="view-info-container">
            <p class="view-info text-muted">
                <i class="fas fa-question"><?= __('State Id') ?></i> <?= $this->
                Number->format($state->state_id) ?>
            </p>
        </div>
                                                            <?php
        echo $this->Html->link('<i class="fas fa-edit"></i> Edit State', [
            'action' => 'edit',
            $state->state_id
        ], ['class' => 'btn btn-primary', 'escape' => false])
        ?>
    </section>
</div>
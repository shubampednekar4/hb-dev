<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\State[]|\Cake\Collection\CollectionInterface $states
 */
?>
<div class="card">
    <!-- todo: change card header semantic coloring -->
    <header class="card-header card-header-primary">
        <h2 class="card-title"><?= __('States') ?></h2>
        <p class="card-category"><?= __('Manage States') ?></p>
    </header>
    <section class="card-body">
        <?= $this->Html->link(__('New State <i class="fas fa-plus-circle"></i>'), ['action' => 'add'], [
            'class' => 'btn btn-info float-right',
            'escape' => false
        ]) ?>
        <table class="table table-full-width table-responsive-md table-striped">
            <thead>
            <tr>
                                    <th><?= $this->Paginator->sort('state_id') ?></th>
                                    <th><?= $this->Paginator->sort('full_name') ?></th>
                                    <th><?= $this->Paginator->sort('abbrev') ?></th>
                                    <th><?= $this->Paginator->sort('country_id') ?></th>
                                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($states as $state): ?>
            <tr>
                                                                                                                                                                                                                                                        <td><?= $this->Number->format($state->state_id) ?></td>
                                                                                                                                                                                                                                                                                                    <td><?= h($state->full_name) ?></td>
                                                                                                                                                                                                                                                                                                    <td><?= h($state->abbrev) ?></td>
                                                                                                                                                                                                                        <td><?= $state->has('country') ? $this->Html->link($state->country->full_name, ['controller' => 'Countries', 'action' => 'view', $state->country->country_id]) : '' ?></td>
                                                                                                                                            <td class="actions">
                    <?= $this->Html->link('<i class="fas fa-eye"></i> ' . __('View'), ['action' => 'view', $state->state_id], ['escape' => false, 'class' => 'btn btn-sm btn-primary']) ?>
                    <?= $this->Html->link('<i class="fas fa-edit"></i> ' . __('Edit'), ['action' => 'edit', $state->state_id], ['escape' => false, 'class' => 'btn btn-sm btn-success']) ?>
                    <?= $this->Form->postLink('<i class="fas fa-trash"></i> ' . __('Delete'), ['action' => 'delete', $state->state_id], ['confirm' => __('Are you sure you want to delete # {0}?', $state->state_id), 'escape' => false, 'class' => 'btn btn-sm btn-danger']) ?>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div class="paginator">
            <ul class="pagination">
                <?= $this->Paginator->first('<span class="btn btn-info"><i class="fas fa-fast-backward"></i></span>', ['escape' => false]) ?>
                <?= $this->Paginator->prev('<span class="btn btn-info"><i class="fas fa-backward"></i></span>', ['escape' => false]) ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next('<span class="btn btn-info"><i class="fas fa-forward"></i></span>', ['escape' => false]) ?>
                <?= $this->Paginator->last('<span class="btn btn-info"><i class="fas fa-fast-forward"></i></span>', ['escape' => false]) ?>
            </ul>
            <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
        </div>
    </section>
</div>


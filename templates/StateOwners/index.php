<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\StateOwner[]|\Cake\Collection\CollectionInterface $stateOwners
 * @var bool $resetNeeded
 * @var string $search
 */

$this->assign('title', $resetNeeded ? __('Results for "{0}"', $search) : __("All State Owners"));
?>
<div class="card">
    <header class="card-header card-header-warning">
        <h2 class="card-title"><i class="material-icons">corporate_fare</i> <?= $this->fetch('title') ?></h2>
        <p class="card-category"><?= $resetNeeded ? "Results Found: (".$stateOwners->count().")" : __("Manage State Owners") ?></p>
    </header>
    <section class="card-body">
        <div class="row">
            <div class="col-lg-4 col-md-12">
                <?= $this->Search->create($resetNeeded, $search) ?>
            </div>
            <div class="col-lg-8 col-md-12">
                <?= $this->Html->link(__('New State Owner').' <i class="material-icons">add_circle</i>',
                    ['action' => 'add'], [
                        'class' => 'btn btn-info float-right', 'escape' => false
                    ]) ?>
            </div>
        </div>
        <table class="table table-full-width table-responsive-md table-striped">
            <thead>
            <tr>
                <th><?= $this->Paginator->sort('state_owner_first_name', 'Name') ?></th>
                <th><?= $this->Paginator->sort('state_owner_email', 'Email') ?></th>
                <th><?= $this->Paginator->sort('state_owner_phone', 'Phone') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($stateOwners as $stateOwner): ?>
                <tr>
                    <td><?= $this->Html->link(h($stateOwner->state_owner_first_name.' '.h($stateOwner->state_owner_last_name)),
                            ['action' => 'view', $stateOwner->state_owner_id]) ?></td>
                    <td><?= $this->Html->link(h($stateOwner->state_owner_email),
                            'mailto:'.h($stateOwner->state_owner_email)) ?></td>
                    <td><?= $this->Html->link(h($stateOwner->state_owner_phone),
                            'tel:'.h($stateOwner->state_owner_phone)) ?></td>
                    <td class="actions">
                        <?= $this->Html->link('<i class="material-icons">visibility</i><span class="sr-only>" '.__('View').'</span>',
                            ['action' => 'view', $stateOwner->state_owner_id],
                            ['escape' => false, 'class' => 'btn btn-sm btn-primary btn-just-icon btn-round']) ?>
                        <?= $this->Html->link('<i class="material-icons">edit</i><span class="sr-only>"'.__('Edit').'</span>',
                            ['action' => 'edit', $stateOwner->state_owner_id],
                            ['escape' => false, 'class' => 'btn btn-sm btn-success btn-just-icon btn-round']) ?>
                        <?= $this->Form->postLink('<i class="material-icons">delete</i><span class="sr-only>"'.__('Delete').'</span>',
                            [
                                'action' => 'delete', $stateOwner->state_owner_id
                            ], [
                                'confirm' => __('Are you sure you want to delete # {0}?', $stateOwner->state_owner_id),
                                'escape'  => false, 'class' => 'btn btn-sm btn-danger btn-just-icon btn-round'
                            ]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div class="paginator">
            <ul class="pagination">
                <?= $this->Paginator->first(__('First'), ['escape' => false]) ?>
                <?= $this->Paginator->numbers(['modulus' => 2]) ?>
                <?= $this->Paginator->last(__('Last'), ['escape' => false]) ?>
            </ul>
            <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} state owner(s) out of {{count}} total')) ?></p>
        </div>
    </section>
</div>


<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Franchise[]|\Cake\Collection\CollectionInterface $franchises
 * @var bool $reset
 * @var array $data
 */

$this->assign('title', 'Manage All')
?>
<?= $this->Html->link('Go Back', ['action' => 'index'], ['class' => 'btn btn-info btn-sm']) ?>

<div class="card">
    <header class="card-header card-header-primary">
        <h2 class="card-title"><?= __($this->fetch('title')) ?></h2>
        <p class="card-description"><?= $reset ? "Results Found: (" . $franchises->count() . ")" : __('Manage Franchises') ?></p>
    </header>
    <section class="card-body">
        <div class="row">
            <div class="col-lg-4 col-md-12">
                <?= $this->Search->create($reset, $data['search'] ?? null) ?>
            </div>
        </div>


        <table class="table table-full-width table-responsive-md table-striped">
            <thead>
            <tr>
                <th><?= $this->Paginator->sort('franchise_name', 'Franchise') ?></th>
                <th><?= $this->Paginator->sort('Operators.operator_first_name', 'Operator') ?></th>
                <th><?= $this->Paginator->sort('StateOwners.state_owner_first_name', 'State Owner') ?></th>
                <th><?= $this->Paginator->sort('franchise_status') ?></th>
                <th><?= $this->Paginator->sort('franchise_number_of_territories') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($franchises as $franchise): ?>
                <?php
                switch ($franchise->franchise_status) {
                    case 'Active':
                        $status = '<span class="badge badge-success">Open</span>';
                        break;
                    case 'Inactive':
                        $status = '<span class="badge badge-danger">Closed</span>';
                        break;
                    case 'For Sale':
                        $status = '<span class="badge badge-warning">For Sale</span>';
                        break;
                    default:
                        $status = '<span class="badge badge-info">No Status Set</span>';
                }
                ?>
                <tr>
                    <td><?= $this->Html->link($franchise->franchise_name, [
                            'action' => 'view',
                            $franchise->franchise_id
                        ]) ?></td>
                    <td><?= $franchise->has('operator') ? $this->Html->link(sprintf("%s (%s)", $franchise->operator->full_name, $franchise->operator_id), ['controller' => 'Operators', 'action' => 'view', $franchise->operator->operator_id]) : '' ?></td>
                    <td><?= $franchise->has('state_owner') ? $this->Html->link($franchise->state_owner->full_name, ['controller' => 'StateOwners', 'action' => 'view', $franchise->state_owner->state_owner_id]) : 'Corporate Account' ?></td>
                    <td><?= $status ?></td>
                    <td><?= $franchise->franchise_number_of_territories ? h($franchise->franchise_number_of_territories) : '<span class="badge badge-warning">Not Set</span>' ?></td>
                    <td class="actions">
                        <?= $this->Html->link('<i class="material-icons">visibility</i>', ['action' => 'view', $franchise->franchise_id], ['escapeTitle' => false, 'class' => 'btn btn-sm btn-primary btn-round btn-just-icon']) ?>
                        <?= $this->Html->link('<i class="material-icons">edit</i>', ['action' => 'edit', $franchise->franchise_id], ['escapeTitle' => false, 'class' => 'btn btn-sm btn-warning btn-round btn-just-icon']) ?>
                        <?= $this->Form->postLink('<i class="material-icons">delete</i>', ['action' => 'delete', $franchise->franchise_id], ['confirm' => __('Are you sure you want to delete "{0}" franchise?', $franchise->franchise_name), 'escapeTitle' => false, 'class' => 'btn btn-sm btn-danger btn-round btn-just-icon']) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div class="paginator">
            <ul class="pagination">
                <?= $this->Paginator->first(__('First'), ['escape' => false]) ?>
                <?= $this->Paginator->numbers(['modulus' => 10]) ?>
                <?= $this->Paginator->last(__('Last'), ['escape' => false]) ?>
            </ul>
            <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} operator(s) out of {{count}} total')) ?></p>
        </div>
    </section>
</div>


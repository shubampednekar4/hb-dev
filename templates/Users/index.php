<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 * @var bool $resetNeeded
 * @var string|null $search
 */

use App\Model\Entity\User;
use App\View\AppView;
use Cake\Collection\CollectionInterface;

$this->assign('title', $resetNeeded ? __('Results for "{0}"', h($search)) : __("All Users"));
?>
<div class="card">
    <div class="card-header card-header-primary">
        <h2 class="card-title"><i class="material-icons">person</i> <?= $this->fetch('title') ?></h2>
        <p class="card-category"><?= $resetNeeded ? "Results Found: (" . $users->count() . ")" : __("Manage Users") ?></p>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-4 col-md-12">
                <?= $this->Search->create($resetNeeded, $search); ?>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="float-right">
                    <?= $this->Html->link(__('New User <i class="material-icons">add_circle</i>'), ['action' => 'add'], [
                        'class' => 'btn btn-info',
                        'escape' => false
                    ]) ?>
                </div>
            </div>
        </div>

        <table class="table table-full-width table-responsive-md table-striped">
            <thead>
            <tr>
                <th><?= $this->Paginator->sort('user_username', 'Username') ?></th>
                <th><?= $this->Paginator->sort('user_first_name', 'First Name') ?></th>
                <th><?= $this->Paginator->sort('user_last_name', 'Last Name') ?></th>
                <th><?= $this->Paginator->sort('user_type_id', 'Type') ?></th>
                <th class="actions"><?= __('Controls') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $this->Html->link(h($user->user_username), ['action' => 'view', $user->user_id]) ?></td>
                    <td><?= h($user->user_first_name) ?></td>
                    <td><?= h($user->user_last_name) ?></td>
                    <td><?= h($user->new_user_type->name ?? $user->user_type) ?></td>
                    <td class="actions">
                        <?= $this->Html->link('<i class="material-icons">visibility</i><span class="sr-only">' . __('View') . '</span>', ['action' => 'view', $user->user_id], [
                            'class' => 'btn btn-just-icon btn-round btn-sm btn-primary',
                            'escape' => false,
                            'title' => __('View {0}', h($user->user_username)),
                        ]) ?>
                        <?= $this->Html->link('<i class="material-icons">edit</i><span class="sr-only">' . __('Edit') . '</span>', ['action' => 'edit', $user->user_id], [
                            'class' => 'btn btn-just-icon btn-round btn-sm btn-success',
                            'escape' => false,
                            'title' => __('Edit {0}', h($user->user_username)),
                        ]) ?>
                        <?= $this->Form->postLink('<i class="material-icons">delete</i>', ['action' => 'delete', $user->user_id], [
                            'confirm' => __('Are you sure you want to delete user: {0}?', h($user->user_username)),
                            'class' => 'btn btn-just-icon btn-round btn-sm btn-danger',
                            'escapeTitle' => false,
                            'title' => __('Delete {0}', h($user->user_username)),
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
            <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} user(s) out of {{count}} total')) ?></p>
        </div>
    </div>
</div>
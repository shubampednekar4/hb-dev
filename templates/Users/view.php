<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var User $currentUser
 */

use App\Model\Entity\User;
use App\View\AppView;

$this->assign('title', __('User Profile'));
?>

<?php if ($currentUser->is_admin): ?>
    <?= $this->Html->link('<i class="material-icons">list</i> All Users', ['action' => 'index'], [
        'escape' => false,
        'class' => 'btn btn-sm btn-info'
    ]) ?>
    <?= $this->Form->postLink('<i class="material-icons">delete</i> Delete User', ['action' => 'delete'], [
        'escapeTitle' => false,
        'class' => 'btn btn-sm btn-danger',
        'confirm' => 'Are you sure you want to delete this user?'
    ]) ?>
<?php endif; ?>
<div class="card">
    <header class="card-header card-header-primary">
        <h2 class="card-title"><i class="material-icons">person</i> <?= __($this->fetch('title')) ?></h2>
        <p class="card-category"><?= __('For {0} {1}', $user->user_first_name, $user->user_last_name) ?></p>
    </header>
    <section class="card-body">
            <p class="card-text"><i class="material-icons">vpn_key</i> <?= h($user->new_user_type->name ?? $user->user_type) ?></p>
            <p class="card-text"><i class="material-icons">alternate_email</i> <?= $this->Html->link(h($user->user_email), 'mailto:' . h($user->user_email)) ?></p>
            <?= $this->Html->link('<i class="material-icons">edit</i> Edit User', [
                'action' => 'edit',
                $user->user_id
            ], ['class' => 'btn btn-primary', 'escape' => false]) ?>
    </section>
</div>
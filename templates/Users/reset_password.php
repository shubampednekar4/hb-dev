<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

use App\Model\Entity\User;
use App\View\AppView;
/**
 * @var AppView $this
 * @var User $user
 */
?>

<h2>Reset Password</h2>
<p><?= sprintf('Thank you %s %s! Now we can reset your password. Enter your desired new password below.', $user->user_first_name, $user->user_last_name) ?></p>
<?= $this->Form->create($user) ?>
<div class="form-group">
    <?= $this->Form->control('user_password', [
        'value' => null,
        'class' => 'form-control',
        'type' => 'password',
        'label' => 'New Password',
    ]) ?>
</div>
<?= $this->Form->button('Reset Password', ['class' => 'btn btn-success']) ?>
<?= $this->Form->end() ?>

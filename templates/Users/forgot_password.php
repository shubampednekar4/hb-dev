<?php
/**
 * @var \App\View\AppView $this
 */

use App\View\AppView;

/**
 * @var AppView $this
 */
?>

<section>
    <div class="container">
        <h2>Forgot Password</h2>
        <p>If you have forgotten your password, don't worry. We can help you reset it from here. Just enter your
            username or email address below and click the button. An email with then be sent to the email address we
            have on hand for you with a special password reset link that you let your finish the password reset
            process. </p>
        <p class="lead"><strong>Make sure you enter your username or password in exactly how it should be in the
                system. <span class="text-uppercase text-danger">This search is case sensitive.</span></strong></p>
        <div class="justify-content-center">
            <?= $this->Form->create() ?>
            <div class="form-group">
                <?= $this->Form->control('username_or_email', [
                    'class' => 'form-control',
                    'type' => 'text',
                    'required'
                ]) ?>
            </div>
            <?= $this->Form->button('Send Reset Email', ['class' => 'btn btn-success']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</section>
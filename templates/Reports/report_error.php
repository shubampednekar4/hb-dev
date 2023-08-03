<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

use App\Model\Entity\User;
use App\View\AppView;

$this->assign('title', 'Cannot Create Report');
?>

<div class="d-block text-center mb-5">
    <?= $this->Html->image('site/logo.png', [
        'class' => 'img-fluid text-align-center',
        'alt' => "Heaven's Best Carpet Cleaning",
        'title' => "Heaven's Best " . __("Logo"),
    ])
    ?>
</div>
<div class="alert alert-danger animated-alert">
    <h2 class="alert-heading"><?= __('Error') ?> </h2>
    <p><?= __("You don't appear to have a operator account associated with your profile. Contact corporate and ask that they either associate your existing operator account with your profile, or create one for you. If you are a state owner, ask them to associate your state owner profile with your profile. If you are not an operator nor state owner, contact support and report this problem.") ?></p>
    <div class="text-center">
        <?= $this->Html->link('<i class="fas fa-backward"></i> ' . __('Go Back'), [
            'action' => 'index'
        ], [
            'class' => 'btn btn-primary',
            'escape' => false,
        ]) ?>
        <?php
        $bodyStr = "Hello%20there%2C%0A%0AMy%20name%20is%20$user->user_first_name%20$user->user_last_name%2C%20and%20would%20like%20access%20to%20create%20monthly%20reports.%20My%20username%20is%20%22$user->user_username%22%2C%20and%20I%20am%20a%2Fan%20%7Bput%20user%20type%20here%2C%20like%20operator%2C%20state%20owner%2C%20or%20administrator%7D.%20Could%20you%20do%20that%20for%20me%20please%3F%0A%0A$user->user_first_name%20$user->user_last_name%20";
        echo $this->Html->link("<i class='fas fa-paper-plane'></i> " . __('Send Report'),
            "mailto:\"Linda\"<linda@heavensbest.com>?subject=Access%20Request&body=$bodyStr", [
                'class' => 'btn btn-success',
                'escapeTitle' => false,
            ]);
        ?>
    </div>
</div>

<?php
/**
 * @var AppView $this;
 * @var User $user;
 * @var string $link;
 */

use App\Model\Entity\User;
use App\View\AppView;

?>

<p><?= sprintf('Hello %s %s!', $user->user_first_name, $user->user_last_name) ?></p>
<p>We received a request to change your email. In order to do that, we need you to use this link. Copy and paste it into your browner, click the link, or use the button to go to our password reset screen.</p>
<p>Thank you for using Heaven's Best Corporate Application.</p>
<p><?= $this->Html->link($link, $link) ?></p>
<?= $this->Html->link('Reset Password', $link, ['class' => 'btn btn-primary']) ?>

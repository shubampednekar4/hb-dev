<?php
declare(strict_types=1);

namespace App\Mailer\Preview;

use Cake\Utility\Security;
use DebugKit\Mailer\MailPreview;

/**
 * @property \App\Model\Table\UsersTable $Users
 */
class PasswordResetPreview extends MailPreview
{
    public function sendLink()
    {
        $this->loadModel('Users');
        $user = $this->Users->find()->first();

        return $this->getMailer('User')
            ->sendLink($user)
            ->set(['token' => Security::randomString(32)]);
    }
}

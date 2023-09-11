<?php
declare(strict_types=1);

namespace App\Mailer;

use App\Model\Entity\User;
use Cake\Mailer\Mailer;

/**
 * PasswordReset mailer.
 */
class PasswordResetMailer extends Mailer
{
    /**
     * Mailer's name.
     *
     * @var string
     */
    public static $name = 'PasswordReset';

    public function sendLink(User $user)
    {
        return $this->addTo('no-reply@heavensbest.com', "Heaven's Best Corporate App")
            ->setTo($user->user_email)
            ->setSubject(sprintf("Here's your password reset link %s %s", $user->user_first_name, $user->user_last_name))
            ->setViewVars(['user' => $user]);
    }
}

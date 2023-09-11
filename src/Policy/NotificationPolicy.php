<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Notification;
use Authorization\IdentityInterface;

/**
 * Notification policy
 */
class NotificationPolicy
{
    public function isAuthor(IdentityInterface $user, Notification $notification) {
        return $user->user_id === $notification->user_id;
    }

    /**
     * Check if $user can add Notification
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Notification $notification
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Notification $notification)
    {
        return true;
    }

    /**
     * Check if $user can edit Notification
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Notification $notification
     * @return bool
     */
    public function canEdit(IdentityInterface $user, Notification $notification)
    {
        return $this->isAuthor($user, $notification);
    }

    /**
     * Check if $user can delete Notification
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Notification $notification
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Notification $notification)
    {
        return $this->isAuthor($user, $notification);
    }

    /**
     * Check if $user can view Notification
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Notification $notification
     * @return bool
     */
    public function canView(IdentityInterface $user, Notification $notification)
    {
        return $this->isAuthor($user, $notification);
    }
}

<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\User;
use App\Model\Table\NotificationsTable;
use Authorization\IdentityInterface;
use Cake\ORM\Query;

/**
 * Notifications policy
 */
class NotificationsTablePolicy
{
    public function canIndex(): bool
    {
        return true;
    }

    public function scopeIndex(User $user, Query $notifications): Query
    {
        return $notifications->where(['user_id' => $user->user_id]);
    }
}

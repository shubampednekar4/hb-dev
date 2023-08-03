<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\User;
use Cake\ORM\Query;

/**
 * Users policy
 */
class UsersTablePolicy
{
    /**
     * @param \App\Model\Entity\User $user
     * @param \Cake\ORM\Query $users
     * @return \Cake\ORM\Query
     */
    public function scopeIndex(User $user, Query $users)
    {
        if (!$user->is_admin) {
            return $users->where(['Users.user_id' => $user->user_id]);
        }

        return $users;
    }
}

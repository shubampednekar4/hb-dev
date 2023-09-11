<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\User;
use Cake\ORM\Query;

/**
 * StateOwners policy
 */
class StateOwnersTablePolicy
{
    /**User
     * Return all or nothing depending on if the user is an admin or not.
     *
     * @param \App\Model\Entity\User $user
     * @param \Cake\ORM\Query $stateOwners
     * @return \Cake\ORM\Query
     */
    public function scopeIndex(User $user, Query $stateOwners)
    {
        if (!$user->is_admin) {
            if ($user->is_state_owner) {
                return $stateOwners->where(['StateOwners.state_owner_id' => $user->state_owner_id]);
            }

            return $stateOwners->where(['StateOwners.state_owner_id' => 0]);
        }

        return $stateOwners;
    }
}

<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\User;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;

/**
 * Operators policy
 */
class OperatorsTablePolicy
{
    /**
     * Filter out operators on a list/index view
     *
     * @param \App\Model\Entity\User $user
     * @param \Cake\ORM\Query $operators
     * @return \Cake\ORM\Query
     */
    public function scopeIndex(User $user, Query $operators)
    {

        if ($user->is_admin) {
            return $operators;
        } elseif ($user->is_state_owner) {
            $states = TableRegistry::getTableLocator()->get('States')->find();
            $state_ids = [];
            foreach ($states as $state) {
                if ($state->state_owner_id === $user->state_owner_id) {
                    $state_ids[] = $state->state_id;
                }
            }
            $operators =  $operators->where([
                'Operators.state_id IN' => $state_ids,
            ]);

            return $operators;
        }

        return $operators->where(['Operators.user_id' => $user->user_id]);
    }
}

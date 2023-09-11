<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\User;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;

/**
 * Franchises policy
 */
class FranchisesTablePolicy
{
    public function scopeList(User $user, Query $franchises): Query
    {
        if ($user->is_admin) {
            return $franchises;
        } elseif ($user->is_state_owner) {
            $states = TableRegistry::getTableLocator()->get('States');
            $state_ids = $states->find()->select('state_id')->where(['state_owner_id' => $user->state_owner_id]);
            foreach ($states as $state) {
                $state_ids[] = $state->state_id;
            }
            $OperatorTable = TableRegistry::getTableLocator()->get('Operators');
            $operators = $OperatorTable->find()->select(['operator_id'])->where(['state_id IN' => $state_ids]);
            $operator_ids = [];
            foreach ($operators as $operator) {
                $operator_ids[] = $operator->operator_id;
            }

            return $franchises->where(['operator_id IN' => $operator_ids]);
        } elseif ($user->operator_id) {
            return $franchises->where(['operator_id' => $user->operator_id]);
        }

        return $franchises->contain(['Operators'])->where(['Operators.user_id' => $user->user_id]);
    }

    public function scopeIndex(User $user, Query $franchises): Query
    {
        return $franchises;
    }
}

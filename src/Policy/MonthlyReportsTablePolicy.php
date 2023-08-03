<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\User;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;

/**
 * MonthlyReports policy
 */
class MonthlyReportsTablePolicy
{
    /**
     * Index scope policy method.
     *
     * @param \App\Model\Entity\User $user
     * @param \Cake\ORM\Query $monthlyReports
     * @return \Cake\ORM\Query
     */
    public function scopeIndex(User $user, Query $monthlyReports)
    {
        if (!$user->is_admin) {
            $operatorsTable = TableRegistry::getTableLocator()->get('Operators');
            if ($user->is_state_owner) {
                $states = TableRegistry::getTableLocator()->get('States')
                    ->find()
                    ->select('state_id')
                    ->where(['state_owner_id' => $user->state_owner_id]);
                $state_ids = [];
                foreach ($states as $state) {
                    $state_ids[] = $state->state_id;
                }
                $operators = $operatorsTable->find()
                    ->select(['operator_id'])
                    ->where(['state_id IN' => $state_ids]);
                $op_ids = [];
                foreach ($operators as $so_operator) {
                    $op_ids[] = $so_operator->operator_id;
                }
                $franchises = TableRegistry::getTableLocator()->get('Franchises');
                $franchises = $franchises->find()
                    ->select(['franchise_id'])
                    ->where(['state_owner_id' => $user->state_owner_id]);
                $franchise_ids = [];
                foreach ($franchises as $franchise) {
                    $franchise_ids[] = $franchise->franchise_id;
                }
                if (!empty($op_ids) && !empty($franchise_ids)) {
                    return $monthlyReports->where([
                        'OR' => [
                            'operator_id IN' => $op_ids,
                            'franchise_id IN' => $franchise_ids,
                        ]]);
                } elseif (!empty($op_ids)) {
                    return $monthlyReports->where([
                        'OR' => [
                            'operator_id IN' => $op_ids,
                        ]]);
                } elseif (!empty($franchise_ids)) {
                    return $monthlyReports->where([
                        'OR' => [
                            'franchise_id IN' => $franchise_ids,
                        ]]);
                } else {
                    return $monthlyReports->where(['operator_id' => '0']);
                }
            } elseif ($user->is_operator) {
                return $monthlyReports->where(['operator_id' => $user->operator_id]);
            } else {
                return $monthlyReports->where(['operator_id' => '0']);
            }
        }

        return $monthlyReports;
    }
}

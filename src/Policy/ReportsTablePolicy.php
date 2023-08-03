<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\User;
use Cake\ORM\Query;

/**
 * Reports policy
 */
class ReportsTablePolicy
{
    /**
     * Score for monthly report index action.
     *
     * @param \App\Model\Entity\User $user
     * @param \Cake\ORM\Query $reports
     * @return \Cake\ORM\Query
     */
    public function scopeMonthlyIndex(User $user, Query $reports)
    {
        if (!$user->is_admin) {
            return $reports->where(['Reports.user_id' => $user->user_id]);
        }

        return $reports;
    }
}

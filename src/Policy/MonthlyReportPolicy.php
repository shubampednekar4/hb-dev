<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\MonthlyReport;
use Authorization\IdentityInterface;
use Authorization\Policy\BeforePolicyInterface;

/**
 * MonthlyReport policy.
 *
 * Monthly report or monthly stats authorization policy.
 * Governs the authorization security side of things.
 * If the user is an administrator or state owner, they are allowed full C.R.U.D. access.
 * If the user is the author of the resource, then they are allowed full C.R.U.D. access.
 * Guests are not allowed any access to any of the materials at this time.
 */
class MonthlyReportPolicy implements BeforePolicyInterface
{
    /**
     * Check if $user can create MonthlyReport
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\MonthlyReport $monthlyReport
     * @return bool
     */
    public function canCreate(IdentityInterface $user, MonthlyReport $monthlyReport): bool
    {
        return true;
    }

    /**
     * Check if $user can update MonthlyReport
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\MonthlyReport $monthlyReport
     * @return bool
     */
    public function canUpdate(IdentityInterface $user, MonthlyReport $monthlyReport): bool
    {
        return $this->isAuthorOfMonthlyReport($user, $monthlyReport);
    }

    /**
     * Check if $user can delete MonthlyReport
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\MonthlyReport $monthlyReport
     * @return bool
     */
    public function canDelete(IdentityInterface $user, MonthlyReport $monthlyReport): bool
    {
        return $this->isAuthorOfMonthlyReport($user, $monthlyReport);
    }

    /**
     * Check if $user can view MonthlyReport
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\MonthlyReport $monthlyReport
     * @return bool
     */
    public function canView(IdentityInterface $user, MonthlyReport $monthlyReport): bool
    {
        return $this->isAuthorOfMonthlyReport($user, $monthlyReport);
    }

    public function isAuthorOfMonthlyReport(IdentityInterface $user, MonthlyReport $monthlyReport): bool
    {
        return $monthlyReport->operator->user_id === $user->user_id;
    }

    /**
     * @param \Authorization\IdentityInterface|null $identity
     * @param mixed $resource
     * @param string $action
     * @return bool|void
     */
    public function before(?IdentityInterface $identity, $resource, $action)
    {
        $user = $identity->getOriginalData();
        /** @var \App\Model\Entity\User $user */
        if ($user->is_admin || $user->is_state_owner) {
            return true;
        }
    }
}

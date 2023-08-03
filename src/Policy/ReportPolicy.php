<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Report;
use Authorization\IdentityInterface;

/**
 * Report policy
 */
class ReportPolicy
{
    /**
     * Check if $user can create Report
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Report $report
     * @return bool
     */
    public function canCreate(IdentityInterface $user, Report $report)
    {
    }

    /**
     * Check if $user can update Report
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Report $report
     * @return bool
     */
    public function canUpdate(IdentityInterface $user, Report $report)
    {
    }

    /**
     * Check if $user can delete Report
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Report $report
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Report $report)
    {
    }

    /**
     * Check if $user can view Report
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Report $report
     * @return bool
     */
    public function canView(IdentityInterface $user, Report $report)
    {
        $oUser = $user->getOriginalData();
        /** @var \App\Model\Entity\User $oUser */
        if ($oUser->is_admin) {
            return true;
        }

        return $oUser->user_id === $report->user_id;
    }
}

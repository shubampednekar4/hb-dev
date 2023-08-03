<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Franchise;
use Authorization\IdentityInterface;

/**
 * Franchise policy
 */
class FranchisePolicy
{
    /**
     * Check if $user can add Franchise
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Franchise $franchise
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Franchise $franchise)
    {
        return $user->is_admin;
    }

    /**
     * Check if $user can edit Franchise
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Franchise $franchise
     * @return bool
     */
    public function canEdit(IdentityInterface $user, Franchise $franchise)
    {
        return $user->is_admin;
    }

    /**
     * Check if $user can delete Franchise
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Franchise $franchise
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Franchise $franchise)
    {
        return $user->is_admin;
    }

    /**
     * Check if $user can view Franchise
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Franchise $franchise
     * @return bool
     */
    public function canView(IdentityInterface $user, Franchise $franchise)
    {
        return true;
    }
}

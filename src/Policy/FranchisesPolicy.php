<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Franchise;
use Authorization\IdentityInterface;
use Authorization\Policy\BeforePolicyInterface;

/**
 * Franchises policy
 */
class FranchisesPolicy implements BeforePolicyInterface
{
    /**
     * Check if $user can add Franchises
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
     * Check if $user can edit Franchises
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
     * Check if $user can delete Franchises
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
     * Check if $user can view Franchises
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Franchise $franchise
     * @return bool
     */
    public function canView(IdentityInterface $user, Franchise $franchise)
    {
        return $user->is_admin;
    }

    public function before(?IdentityInterface $identity, $resource, $action)
    {
        if ($identity->is_admin) {
            return true;
        }
    }
}

<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Location;
use Authorization\IdentityInterface;

/**
 * Location policy
 */
class LocationPolicy
{
    /**
     * Check if $user can add Location
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Location $location
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Location $location)
    {
        return $user->is_admin;
    }

    /**
     * Check if $user can edit Location
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Location $location
     * @return bool
     */
    public function canEdit(IdentityInterface $user, Location $location)
    {
        return $user->is_admin;
    }

    /**
     * Check if $user can delete Location
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Location $location
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Location $location)
    {
        return $user->is_admin;
    }

    /**
     * Check if $user can view Location
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Location $location
     * @return bool
     */
    public function canView(IdentityInterface $user, Location $location)
    {
        return $user->is_admin;
    }
}

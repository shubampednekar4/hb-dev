<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Hbads;
use App\Model\Entity\User;
use Authorization\IdentityInterface;
use Authorization\Policy\BeforePolicyInterface;
use Cake\Collection\Collection;
use Cake\ORM\TableRegistry;

/**
 * Operator policy
 */
class HbadsPolicy implements BeforePolicyInterface
{
    /**
     * Check if $user can create Operator
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Operator $operator
     * @return bool
     */
    public function canCreate(IdentityInterface $user, Hbads $hbads)
    {
        return $this->isAdmin($user);
    }
}
<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\StateOwner;
use Authorization\IdentityInterface;
use Cake\ORM\TableRegistry;

/**
 * StateOwner policy
 */
class StateOwnerPolicy
{
    /**
     * Check if $user can create StateOwner
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\StateOwner $stateOwner
     * @return bool
     */
    public function canCreate(IdentityInterface $user, StateOwner $stateOwner)
    {
        return $this->isAdmin($user);
    }

    /**
     * Check if $user can update StateOwner
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\StateOwner $stateOwner
     * @return bool
     */
    public function canUpdate(IdentityInterface $user, StateOwner $stateOwner)
    {
        return $this->isAdmin($user);
    }

    /**
     * Check if $user can delete StateOwner
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\StateOwner $stateOwner
     * @return bool
     */
    public function canDelete(IdentityInterface $user, StateOwner $stateOwner)
    {
        return $this->isAdmin($user);
    }

    /**
     * Check if $user can view StateOwner
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\StateOwner $stateOwner
     * @return bool
     */
    public function canView(IdentityInterface $user, StateOwner $stateOwner)
    {
        return $this->isAdmin($user);
    }

    /**
     * Check if the user is an administrator.
     *
     * @param \Authorization\IdentityInterface $identity
     * @return bool
     */
    public function isAdmin(IdentityInterface $identity)
    {
        $userTypes = TableRegistry::getTableLocator()->get('UserTypes');
        $adminType = $userTypes->find('all')->where(['UserTypes.name' => 'admin'])->first();
        if ($adminType && $identity->getOriginalData()->get('user_type_id')) {
            return $identity->getOriginalData()->get('user_type_id') === $adminType->id;
        } else {
            return strtolower($identity->getOriginalData()->get('user_type')) === 'admin';
        }
    }
}

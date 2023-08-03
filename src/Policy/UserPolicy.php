<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\User;
use Authorization\IdentityInterface;
use Authorization\Policy\BeforePolicyInterface;
use Cake\ORM\TableRegistry;

/**
 * User policy
 */
class UserPolicy implements BeforePolicyInterface
{
    /**
     * Check if $user can create User
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\User $resource
     * @return bool
     */
    public function canCreate(IdentityInterface $user, User $resource)
    {
        return $this->isAdmin($user);
    }

    /**
     * Check if $user can update User
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\User $resource
     * @return bool
     */
    public function canUpdate(IdentityInterface $user, User $resource)
    {
        return $this->isAuthor($user, $resource);
    }

    /**
     * Check if $user can delete User
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\User $resource
     * @return bool
     */
    public function canDelete(IdentityInterface $user, User $resource)
    {
        return $this->isAuthor($user, $resource);
    }

    /**
     * Check if $user can view User
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\User $resource
     * @return bool
     */
    public function canView(IdentityInterface $user, User $resource)
    {
        return $this->isAuthor($user, $resource);
    }

    /**
     * Checks if the user created the resource
     *
     * @param \Authorization\IdentityInterface $identity
     * @param \App\Model\Entity\User $resource The entity being checked.
     * @return bool
     */
    public function isAuthor(IdentityInterface $identity, User $resource)
    {
        return $resource->user_id === $identity->getIdentifier();
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

    /**
     * @param \Authorization\IdentityInterface|null $identity
     * @param mixed $resource
     * @param string $action
     * @return \Authorization\Policy\ResultInterface|bool|null
     */
    public function before(?IdentityInterface $identity, $resource, $action)
    {
        if ($this->isAdmin($identity)) {
            return true;
        }
    }
}

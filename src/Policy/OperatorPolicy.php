<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Operator;
use Authorization\IdentityInterface;
use Authorization\Policy\BeforePolicyInterface;
use Cake\Collection\Collection;
use Cake\ORM\TableRegistry;

/**
 * Operator policy
 */
class OperatorPolicy implements BeforePolicyInterface
{
    /**
     * Check if $user can create Operator
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Operator $operator
     * @return bool
     */
    public function canCreate(IdentityInterface $user, Operator $operator)
    {
        return $this->isAdmin($user);
    }

    /**
     * Check if $user can update Operator
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Operator $operator
     * @return bool
     */
    public function canUpdate(IdentityInterface $user, Operator $operator)
    {
        return $this->isAuthor($user, $operator);
    }

    /**
     * Check if $user can delete Operator
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Operator $operator
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Operator $operator)
    {
        return $this->isAuthor($user, $operator);
    }

    /**
     * Check if $user can view Operator
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Operator $operator
     * @return bool
     */
    public function canView(IdentityInterface $user, Operator $operator)
    {
        if ($user->is_state_owner) {
            $states = TableRegistry::getTableLocator()->get('States')->find();
            $state_ids = [];
            foreach ($states as $state) {
                if ($state->state_owner_id === $user->state_owner_id) {
                    $state_ids[] = $state->state_id;
                }
            }
            $state_id_collection = new Collection($state_ids);

            return $state_id_collection->contains($operator->state_id);
        }

        return $this->isAuthor($user, $operator);
    }

    /**
     * Checks if the user created the resource
     *
     * @param \Authorization\IdentityInterface $identity
     * @param \App\Model\Entity\Operator $resource The entity being checked.
     * @return bool
     */
    public function isAuthor(IdentityInterface $identity, Operator $resource)
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
        if ($identity->is_admin) {
            return true;
        }
    }

    public function before(?IdentityInterface $identity, $resource, $action)
    {
        if ($this->isAdmin($identity)) {
            return true;
        }
    }
}

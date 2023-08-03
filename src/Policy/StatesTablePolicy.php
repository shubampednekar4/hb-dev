<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\User;
use App\Model\Table\StatesTable;
use Authorization\IdentityInterface;
use Cake\ORM\Query;

/**
 * States policy
 */
class StatesTablePolicy
{
    public function scopeIndex(User $user, Query $query): Query
    {
        return $query;
    }
}

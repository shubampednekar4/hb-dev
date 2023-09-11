<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Authentication\IdentityInterface as AuthenticationIdentity;
use Authorization\AuthorizationServiceInterface;
use Authorization\IdentityInterface as AuthorizationIdentity;
use Authorization\Policy\ResultInterface;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use JeremyHarris\LazyLoad\ORM\LazyLoadEntityTrait;

/**
 * User Entity
 *
 * @property int $user_id
 * @property string $user_username
 * @property string $user_email
 * @property string $user_first_name
 * @property string $user_last_name
 * @property string $user_password
 * @property string $user_type
 * @property string|null $operator_id
 * @property int|null $state_owner_id
 * @property \Cake\I18n\FrozenTime|null $forgot_pw_token_ts
 * @property \Cake\I18n\FrozenTime|null $time_created
 * @property \Cake\I18n\FrozenTime|null $time_updated
 * @property string|null $forgot_pw_token
 * @property int|null $customer_id
 * @property int|null $user_type_id
 *
 * @property \App\Model\Entity\Operator|null $operator
 * @property \App\Model\Entity\StateOwner|null $state_owner
 * @property \App\Model\Entity\UserType|null $new_user_type
 * @property bool $is_admin
 * @property bool $is_state_owner
 * @property bool $is_operator
 * @property bool $has_manage_access
 * @property string $user_type_name
 * @property string $authority
 * @property \App\Model\Entity\Notification[] $notifications
 */
class User extends Entity implements AuthorizationIdentity, AuthenticationIdentity
{
    use LazyLoadEntityTrait;

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'user_username' => true,
        'user_email' => true,
        'user_first_name' => true,
        'user_last_name' => true,
        'user_password' => true,
        'user_type' => true,
        'operator_id' => true,
        'state_owner_id' => true,
        'forgot_pw_token_ts' => true,
        'time_created' => true,
        'time_updated' => true,
        'forgot_pw_token' => true,
        'customer_id' => true,
        'user_type_id' => true,
        'operator' => true,
        'state_owner' => true,
        'new_user_type' => true,
        'authority' => true,
    ];

    public function _getDisplay_name()
    {
        return $this->_fields['user_first_name'] . ' ' . $this->_fields['user_last_name'] . ' (' . $this->_fields['user_username'] . ')';
    }

    /**
     * Authentication identifier method.
     *
     * @return int|mixed|string|null
     */
    public function getIdentifier()
    {
        return $this->user_id;
    }

    /**
     * Authentication original data method.
     *
     * @return $this|array|\ArrayAccess
     */
    public function getOriginalData()
    {
        return $this;
    }

    /**
     * Administrative check
     *
     * @return bool
     */
    public function _getIsAdmin(): bool
    {
        return $this->authority === 'admin' || $this->authority === 'administrator';
    }

    /**
     * State owner check.
     *
     * @return bool
     */
    public function _getIsStateOwner(): bool
    {
        return $this->authority === 'state_owner';
    }

    /**
     * Operator check.
     *
     * @return bool
     */
    public function _getIsOperator(): bool
    {
        return $this->authority === 'operator';
    }

    public function _getHasManageAccess(): bool
    {
        return $this->is_state_owner || $this->is_admin;
    }

    public function _getUserTypeName(): string
    {
        if ($this->user_type) {
            return $this->user_type;
        } else {
            return $this->new_user_type->name;
        }
    }

    public function can($action, $resource): bool
    {
        return $this->authorization->can($this, $action, $resource);
    }

    public function canResult(string $action, $resource): ResultInterface
    {
        return $this->authorization->canResult($this, $action, $resource);
    }

    public function applyScope(string $action, $resource)
    {
        return $this->authorization->applyScope($this, $action, $resource);
    }

    /**
     * Setter to be used by the middleware.
     *
     * @param \Authorization\AuthorizationServiceInterface $service
     * @return \App\Model\Entity\User
     */
    public function setAuthorization(AuthorizationServiceInterface $service)
    {
        $this->authorization = $service;

        return $this;
    }

    /**
     * User level as a string
     *
     * @return string
     */
    public function _getAuthority(): string
    {
        if (!$this->user_type) {
            return $this->new_user_type->name ?? '';
        }

        return $this->user_type;
    }

    /**
     * Set the authority level of the user.
     *
     * @param string $type This is the authority of the user.
     * @return string
     */
    public function _setAuthority(string $type): string
    {
        $this->user_type = $type;
        $user_type = TableRegistry::getTableLocator()->get('UserTypes')
            ->find()
            ->select('id')
            ->where(['name' => $type])
            ->first();
        $this->user_type_id = $user_type->id;

        return $type;
    }

    /**
     * Hash Passwords
     *
     * @param string $password
     * @return false|string
     */
    protected function _setUserPassword(string $password)
    {
        $hasher = new DefaultPasswordHasher();

        return $hasher->hash($password);
    }
}

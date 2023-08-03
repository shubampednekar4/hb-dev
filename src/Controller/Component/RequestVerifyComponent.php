<?php
declare(strict_types=1);

namespace App\Controller\Component;

use Cake\Controller\Component;

/**
 * RequestVerify component
 */
class RequestVerifyComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function OperatorUserData(array $config = []): bool
    {
        if (empty($config)) return false;
        $fields = [
            'email',
            'first_name',
            'last_name',
            'user_login',
            'password',
            'street_address',
            'city',
            'zip',
            'phone',
            'state_id',
        ];
        foreach ($fields as $field) {
            if (!key_exists($field, $config)) {
                return false;
            }
        }
        return true;
    }
}

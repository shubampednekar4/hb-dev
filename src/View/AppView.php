<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     3.0.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\View;

use Cake\View\View;

/**
 * Application View
 *
 * Your application's default view class
 *
 * @link https://book.cakephp.org/4/en/views.html#the-app-view
 * @property \Authentication\View\Helper\IdentityHelper $Identity
 * @property \App\View\Helper\SearchHelper $Search
 * @property \App\View\Helper\AddressHelper $Address
 * @property \App\View\Helper\StringFormatHelper $StringFormat
 * @property \AssetCompress\View\Helper\AssetCompressHelper $AssetCompress
 * @property \App\View\Helper\HBFormHelper $Form
 * @property \App\View\Helper\HBFormHelper $HBForm
 */
class AppView extends View
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading helpers.
     *
     * e.g. `$this->loadHelper('Html');`
     *
     * @return void
     */
    public function initialize(): void
    {
        $this->loadHelper('Authentication.Identity');
        $this->loadHelper('Form', [
            'templates' => 'app_form',
            'errorClass' => 'is-invalid',
            'className' => 'HBForm'
        ]);
        $this->loadHelper('Paginator', ['templates' => 'app_pagination']);
        $this->loadHelper('Search');
        $this->loadHelper('Address');
        $this->loadHelper('StringFormat');
    }
}

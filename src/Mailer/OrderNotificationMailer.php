<?php
declare(strict_types=1);

namespace App\Mailer;

use Cake\Core\Configure;
use Cake\Mailer\Mailer;

/**
 * OrderNotification mailer.
 */
class OrderNotificationMailer extends Mailer
{
    /**
     * Mailer's name.
     *
     * @var string
     */
    public static $name = 'OrderNotification';

    public function __construct($config = null)
    {
        parent::__construct($config);
        $this->setProfile(Configure::read('WooCommerce.email.profile'))
            ->setFrom(Configure::read('WooCommerce.email.from'))
            ->setTo($config['state_owner_email'])
            ->setSubject(Configure::read('WooCommerce.email.order_notification.subject'))
            ->setEmailFormat('both')
            ->setViewVars($config['content'])
            ->viewBuilder()
            ->setHelpers(['Html'])
            ->setLayout('styled')
            ->setTemplate('order-notification');
    }
}

<?php
declare(strict_types=1);

namespace App\Mailer;

use Cake\Core\Configure;
use Cake\Mailer\Mailer;
use Cake\ORM\TableRegistry;

/**
 * CommissionReport mailer.
 */
class CommissionReportMailer extends Mailer
{
    /**
     * Mailer's name.
     *
     * @var string
     */
    public static $name = 'CommissionReport';

    public function __construct($config = null)
    {
        parent::__construct($config);

        $path = join(DS, [ROOT, 'tmp', 'reports', 'commissions', $config['filename']]);
        $user = TableRegistry::getTableLocator()->get('Users')->get($config['user_id']);
        $email = $user->user_email ?: Configure::read('Commissions.email.default_to');
        $name = sprintf("%s %s", $user->user_first_name, $user->user_last_name);

        $this->setProfile(Configure::read('WooCommerce.email.profile'))
            ->setFrom(Configure::read('Commissions.email.default_from'))
            ->setTo($email)
            ->setSubject('Commission Report Created')
            ->setAttachments([
                'commission_report.pdf' => [
                    'file' => $path,
                    'mimetype' => mime_content_type($path),
                ]
            ])
            ->setEmailFormat('text')
            ->setViewVars(['name' => $name])
            ->viewBuilder()
            ->addHelpers(['Html'])
            ->setLayout('styled')
            ->setTemplate('commission');
    }

    public function send(?string $action = null, array $args = [], array $headers = []): array
    {
        return parent::send($action, $args, $headers);
    }
}

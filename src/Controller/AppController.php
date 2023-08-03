<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\EventInterface;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/4/en/controllers.html#the-app-controller
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Dashboard\Controller\Component\DatePresetComponent $DatePreset
 * @property \App\Model\Table\NotificationsTable $Notifications
 */
class AppController extends Controller
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     * @throws \Exception
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('RequestHandler', [
            'viewClassMap' => [
                'json' => 'Json',
                'xml' => 'Xml',
                'ajax' => 'Ajax',
            ],
            'checkHttpCache' => true,
            'enableBeforeRedirect' => false
        ]);
        $this->loadComponent('Flash');
        $this->loadComponent('Authentication.Authentication');
        $this->loadComponent('Authorization.Authorization');
        $this->loadComponent('Dashboard.DatePreset');

        $this->loadModel('Notifications');

        $rUrl = $this->request->getRequestTarget();
        $rParams = Router::getRouteCollection()->parse($rUrl);
        $this->set('controller', $rParams['controller']);
        $this->set('action', $rParams['action']);
    }

    /**
     * @throws \Exception
     */
    public function beforeRender(EventInterface $event)
    {
        parent::beforeRender($event);
        $notifications = [];
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            $identity = $this->Authentication->getIdentity();
            $this->set('currentUser', $this->getTableLocator()->get('Users')->get($identity->getIdentifier()));
            $identifier = $identity->getIdentifier();
            $monthlyReportsTable = $this->getTableLocator()->get('MonthlyReports');
            $user = $monthlyReportsTable->Operators->Users->get($identifier);

            $notification_results = $this->Notifications->find()->orderDesc('created');
            $notification_results = $this->Authorization->applyScope($notification_results, 'index');
            $update = [];
            /** @var \App\Model\Entity\Notification $notification */
            foreach ($notification_results as $notification) {
                $notifications[] = [
                    'link' => $notification->link,
                    'title' => $notification->title,
                    'is_new' => $notification->is_new,
                ];
                // $update[] = $this->Notifications->patchEntity($notification, ['sent' => true]);
            }
            $this->Notifications->saveManyOrFail($update);

            if (!$user->is_admin) {
                $franchises = TableRegistry::getTableLocator()->get('Franchises')->find()->where(['franchise_status' => 'Active']);
                $franchises = $this->Authorization->applyScope($franchises, 'list');
                $operators = TableRegistry::getTableLocator()->get('Operators')->find();
                $operators = $this->Authorization->applyScope($operators, 'index');
                $currentYear = $this->DatePreset->getCurrentYear();
                $monthlyReports = $monthlyReportsTable->find()->where(['AND' => [
                    'month BETWEEN :start AND :end',
                ]])
                    ->bind(':start', $currentYear . '-01-01')
                    ->bind(':end', $currentYear . '-12-31');
                $monthlyReports = $this->Authorization->applyScope($monthlyReports, 'index');
                $months = $this->DatePreset->getAllMonthsUpToCurrent();
                $year = $this->DatePreset->getCurrentYear();
                foreach ($months as $monthNum => $month) {
                    $found = false;
                    foreach ($monthlyReports as $report) {
                        /** @var \App\Model\Entity\MonthlyReport $report */
                        foreach ($franchises as $franchise) {
                            /** @var \App\Model\Entity\Franchise $franchise */
                            if (
                                $report->month->month === $monthNum &&
                                $franchise->franchise_id === $report->franchise_id
                            ) {
                                $found = true;
                                break;
                            }
                        }
                        foreach ($operators as $operator) {
                            /** @var \App\Model\Entity\Operator $operator */
                            if (
                                $report->month->month === $monthNum &&
                                $operator->operator_id === $report->operator_id
                            ) {
                                $op_franchises =  TableRegistry::getTableLocator()->get('Franchises')
                                    ->find()
                                    ->where([
                                        'franchise_status' => 'Active',
                                        'operator_id' => $operator->operator_id,
                                    ]);
                                if ($op_franchises->count() === 1) {
                                    $franchise = $op_franchises->first();
                                }
                                $found = true;
                                break;
                            }
                        }
                    }

                    if (!$found) {
                        if ($user->is_state_owner) {
                            $notifications[] = [
                                'link' => Router::url([
                                    'action' => 'add',
                                    'controller' => 'MonthlyReports',
                                    '?' => [
                                        'month' => $monthNum,
                                    ],
                                ]),
                                'title' => $franchise ? __('{0} is Missing Monthly Stats For {1} {2}', $franchise->franchise_name, $month, $year) :  __('A franchise is Missing Monthly Stats For {1} {2}', $month, $year),
                                'is_new' => true,
                            ];
                        } elseif ($user->is_operator) {
                            $notifications[] = [
                                'link' => Router::url(['action' => 'add', 'controller' => 'MonthlyReports', '?' => ['month' => $monthNum]]),
                                'title' => __('Missing a report For {0} {1}', $month, $year),
                                'is_new' => true,
                            ];
                        }
                    }
                }
            }
        }

        $this->set(compact('notifications'));

        // Load Theme
        $this->viewBuilder()->setTheme('Dashboard');
    }
}

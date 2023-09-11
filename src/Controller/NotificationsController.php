<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Core\Exception\CakeException;

/**
 * Notifications Controller
 *
 * @property \App\Model\Table\NotificationsTable $Notifications
 * @method \App\Model\Entity\Notification[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class NotificationsController extends AppController
{
    /**
     * @return \Cake\Http\Response
     */
    public function commissionReport(): \Cake\Http\Response
    {
        $filename = $this->request->getQuery('filename');
        $hash = $this->request->getQuery('hash');
        $attributes = ['hash' => $hash];
        $attributes = json_encode($attributes);
        $notification = $this->Notifications->find()->where(['attributes' => $attributes])->first();
        $this->Authorization->authorize($notification, 'edit');
        $notification = $this->Notifications->patchEntity($notification, ['is_new' => false]);
        if (!$this->Notifications->save($notification)) {
            $this->Flash->error('Notification issue, contact support immediately');
            return $this->redirect('/');
        }
        $path = join(DS, [ROOT, 'tmp', 'reports', 'commissions', $filename]);
        if (!file_exists($path)) {
            $this->Flash->warning('Commission Report no longer exists on this server, run it again.');
            return $this->redirect(['controller' => 'MonthlyReports', 'action' => 'mainMenu']);
        }
        $this->response = $this->response->withFile($path, ['download' => true, 'name' => 'commission_report.pdf']);
        return $this->response;
    }

    /**
     * @throws \Exception
     */
    public function getNew(): \Cake\Http\Response
    {
        $this->response = $this->response->withType('application/json')
            ->withDisabledCache();
        $notifications = $this->Notifications->find()->where(['sent' => false]);
        $notifications = $this->Authorization->applyScope($notifications, 'index');
        /** @var \App\Model\Entity\Notification $notification */
        if ($notifications->count()) {
            echo "entered with sent as false";
            $update = [];
            foreach ($notifications as $notification) {
                $update[] = $this->Notifications->patchEntity($notification, ['sent' => true]);
            }
            $this->Notifications->saveManyOrFail($update);
            echo "update in notifications";
            return $this->response->withStringBody(json_encode($update));
        }
        else {
            return $this->response->withStringBody(json_encode([]));
        }
    }
}

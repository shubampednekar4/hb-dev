<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Collection\Collection;
use Cake\Event\EventInterface;
use Cake\Http\Response;
use Cake\I18n\FrozenDate;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Log\Log;
use Cake\Utility\Hash;

namespace App\Controller;

use App\Controller\AppController;

class VideosController extends AppController
{
    public function main()
    {
        $videos = $this->Videos->find();

        $this->set(compact('videos'));
    }

    public function view($id = null)
    {
        $video = $this->Videos->get($id);
        $this->Authorization->skipAuthorization();
        $identity = $this->Authentication->getIdentity();
        $identifier = $identity->getIdentifier();
        // $user = $this->AdminHbads->Operators->Users->get($identifier);
        $this->set(compact('video'));
    }
}

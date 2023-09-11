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

class NewsController extends AppController
{
    public function main()
    {
        $newsletters = $this->News->Newsletters->find();

        $this->set(compact('newsletters'));
    }

    public function view($id = null)
    {
        $newsletter = $this->News->Newsletters->get($id);
        $this->Authorization->skipAuthorization();
        $identity = $this->Authentication->getIdentity();
        $identifier = $identity->getIdentifier();
        // $user = $this->AdminHbads->Operators->Users->get($identifier);
        $this->set(compact('newsletter'));
    }
}

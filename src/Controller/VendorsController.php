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

class VendorsController extends AppController
{
    public function index()
    {
        // $videos = $this->Videos->find();
        $vendors = "vendors contact info will come here";

        $this->set(compact('vendors'));
        
    }

    
}

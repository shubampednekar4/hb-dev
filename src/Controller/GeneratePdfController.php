<?php
// src/Controller/GeneratePdfController.php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\EventInterface;
use Cake\Network\Exception\NotFoundException;
use Dompdf\Dompdf;

class GeneratePdfController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->Authentication->allowUnauthenticated(['index']);
    }

    public function index()
    {
        if ($this->request->getParam('param')) {
            $tableHTML = $this->request->getParam('param');
        
           
            $dompdf = new Dompdf();
    
            
            $dompdf->loadHtml($tableHTML);
            
         
            $dompdf->setPaper('A4', 'portrait');
            
            
            $dompdf->render();
            
            
            $dompdf->stream('filename.pdf', ['Attachment' => false]);
        }else{
            echo "test";
        } 
    }
}

<?php
declare(strict_types=1);

namespace App\Controller;

use App\Mailer\OrderNotificationMailer;
use Authorization\Exception\Exception as AuthorizationException;
use Cake\Core\Configure;
use Cake\Datasource\Exception\InvalidPrimaryKeyException;
use Cake\Event\EventInterface;
use Cake\Http\Response;
use Cake\I18n\FrozenTime;
use Cake\ORM\TableRegistry;
use Cake\Console\ShellDispatcher;
use App\Queue\Task\ComputeOrderCommissionsTask;
use App\Controller\GenerateReportController;



/**
 * Woocommerce Controller
 *
 * @property \App\Controller\Component\WoocommerceComponent $Woocommerce
 * @property \Queue\Model\Table\QueuedJobsTable $QueuedJobs
 * @property \App\Model\Table\PdfsTable $Pdfs
 */
class WoocommerceController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Security');
        $this->loadComponent('Authentication.Authentication');
        $this->loadComponent('Woocommerce');
        $this->fetchTable('Queue.QueuedJobs');
        $this->fetchTable('Pdfs');
		$this->loadModel('Queue.QueuedJobs'); 
		
		$this->generateReport = new GenerateReportController();
		
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        // Disable security validation as it will never send data to the controller.
        $this->Security->setConfig('validatePost', false);
        // Remove the methods from authentication.
        $this->Authentication->allowUnauthenticated(['sendOrderEmail']);
    }

    /**
     * Send email to state owner when the operator puts in an order.
     *
     * @return \Cake\Http\Response
     */
    public function sendOrderEmail(): Response
    {
        // Security Configuration
        $this->Authorization->skipAuthorization();
        $this->request->allowMethod(['POST']);

        // Get Woocommerce Header
        $signature = $this->request->getHeader(Configure::read('WooCommerce.webhook.headers.signature'));
        if (is_array($signature)) {
            $signature = $this->request->getHeader(Configure::read('WooCommerce.webhook.headers.signature'))[0];
        }

        // Setup Response Type
        $this->response = $this->response->withType('application/json')
            ->withDisabledCache();

        // Process
        if ($this->request->getData('webhook_id')) {
            return $this->response->withStringBody(json_encode(['response' => 'ping was good']));
        } else {
            $body = json_encode($this->request->getData());
            if ($body) {
                if ($this->Woocommerce->validateSignature($signature, $body)) {
                    $products = $this->request->getData('line_items');
                    if ($this->Woocommerce->isOrderCompleted($this->request->getData('status'))) {
                        $state_owner = TableRegistry::getTableLocator()
                            ->get('StateOwners')
                            ->find()
                            ->where(['state_owner_first_name' => 'Corporate'])
                            ->first();
                        try {
                            $state_owner = $this->Woocommerce->getStateOwner($this->request->getData('customer_id'));
                        } catch (InvalidPrimaryKeyException $e) {
                            $customer_id = $this->request->getData('customer_id');
                            $this->log("Customer with customer ID $customer_id unable to be found");
                            $this->response = $this->response->withStringBody('State Owner Not Found, but order was good.');
                        }

                        $operator = $this->Woocommerce->getOperator($this->request->getData('customer_id'));
                        $line_items = $this->Woocommerce->getLineItems($products);
                        $commission = $this->Woocommerce->getCommission($line_items);
                        $order = $this->request->getData();
                        $content = compact('state_owner', 'order', 'operator', 'line_items', 'commission');

                        $mailer = new OrderNotificationMailer([
                            'state_owner_email' => $state_owner->state_owner_email,
                            'content' => $content,
                        ]);
                        $data = ['settings' => $mailer];

                        $this->QueuedJobs->createJob('Queue.Email', $data);

                        return $this->response->withStringBody(json_encode(['response' => 'email sent']));
                    } // No response if the order is not completed other than a 200 yes.
                } else {
                    $this->response = $this->response->withStatus(401, 'Signature not valid or missing.');
                }
            } else {
                $this->response = $this->response->withStatus(400, 'nothing was sent.');
            }

            // Send only when there is something wrong with the request. This will ignore any non completed order.
            return $this->response->withStringBody(json_encode(['response' => 'no action taken']));
        }
    }

    /**
     * Order Page Count Fetcher
     *
     * Get the number of pages that a query for orders will require.
     * This is used for ajax calls for performance reasons.
     * Only administrators allowed to use this action.
     *
     * @return \Cake\Http\Response JSON with key value pair for "pages".
     */
    public function getOrderPages(): Response
    {
        $this->Authorization->skipAuthorization();
        if (!$this->Authentication->getIdentity()->is_admin) {
            throw new AuthorizationException('Only administrators are permitted on this action.');
        }
        $this->request->allowMethod(['GET']);
        $start_date = new FrozenTime($this->request->getQuery('startDate'));
        $end_date = new FrozenTime($this->request->getQuery('endDate'));
        $pages = $this->Woocommerce->filterOrderPages($start_date, $end_date);

        return $this->response->withType('application/json')
            ->withDisabledCache()
            ->withStringBody(json_encode(['pages' => $pages]));
    }

    /**
     * Commission Report Generator
     *
     * Start the process for creating and emailing out a commission report.
     * Time Range must be specified, no assumptions allowed.
     * Only allowed by administrators.
     * Must run via POST or PUT.
     *
     * @return \Cake\Http\Response Job IDS to be used on status updates on future features.
     * @throws \Exception If there is a problem with the Shop response.
     */
    public function startCommissionReport(): Response
    {
        
    try{
        $this->Authorization->skipAuthorization();
        if (!$this->Authentication->getIdentity()->is_admin) {
            throw new AuthorizationException('Only administrators are permitted on this action.');
        }

        // Change this to "get" if needing to do a practical test.
        
        $this->request->allowMethod(['POST', 'PUT']);
        $start_date = new FrozenTime($this->request->getData('startDate'));
        $end_date = new FrozenTime($this->request->getData('endDate'));
        $orders = $this->Woocommerce->filterOrders($start_date, $end_date);
        $pdf_jobs = [];
        
        
		//$pdf = $this->Pdfs->newEntity();
		$this->loadModel('Pdfs');
        //$pdf = $this->Pdfs->newEmptyEntity();
        $pdf = $this->Pdfs->newEntity([
            'user_id' => $this->Authentication->getIdentity()->getIdentifier(),
            'startDate' => $start_date,
            'endDate' => $end_date,
        ]);
        $this->Pdfs->saveOrFail($pdf);
        $job_resp = [];
        foreach ($orders as $order){
            $job = $this->QueuedJobs->createJob('ComputeOrderCommissions', [
                    'order_id' => $order->id,
                    'pdf_id' => $pdf->id,
                ]);
                
            $job_resp[] = ['order_id' => $order->id, 'pdf_id' => $pdf->id,'queued_job_id' => $job->id];
                
            $pdf_jobs[] = $this->Pdfs->PdfJobs->newEntity([
                'pdf_id' => $pdf->id,
                'queued_job_id' => $job->id,
            ]);
        }
        
        $this->Pdfs->PdfJobs->saveManyOrFail($pdf_jobs);
        return $this->response->withType('application/json')
            ->withDisabledCache()
            ->withStringBody(json_encode(["pdf_jobs"=>$pdf_jobs,"jobs_resp"=>$job_resp]));
    }catch(Exception $e){
            print_r($e->getMessage());
        }
    }
    
}

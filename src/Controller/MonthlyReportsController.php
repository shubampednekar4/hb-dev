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
/**
 * MonthlyReports Controller
 *
 * @property \App\Model\Table\MonthlyReportsTable $MonthlyReports
 * @method \App\Model\Entity\MonthlyReport[]|\App\Controller\ResultSetInterface paginate($object = null, array $settings = [])
 * @property \Dashboard\Controller\Component\DatePresetComponent $DatePreset
 */
class MonthlyReportsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Dashboard.DatePreset');
    }

    public function beforeRender(EventInterface $event)
    {
        parent::beforeRender($event);
        $this->viewBuilder()->setTheme('Dashboard');
    }


        public function index()
{
    $identity = $this->Authentication->getIdentity();
    $identifier = $identity->getIdentifier();
    $user = $this->MonthlyReports->Operators->Users->get($identifier);
    $admin = false;
        if ($user->is_admin) {
        $this->Authorization->skipAuthorization();
        $admin = true;
    }
    $this->set(compact('admin'));
    // // Get all operators for the dropdown
    //     $operators = $this->MonthlyReports->Operators->find('list', [
    //     'order' => ['operator_first_name' => 'ASC']
    // ])->toArray();
    // // $operators = $this->Operators->find();
    // $this->set(compact('operators'));
    
    // // Get all state owners for the dropdown
    // $state_owners = $this->MonthlyReports->StateOwners->find('list', [
    //     'order' => ['state_owner_first_name' => 'ASC']
    // ])->toArray();
    // $this->set(compact('state_owners'));
    
    // $monthlyReports = $this->MonthlyReports->find()
    //     ->orderDesc('month');
    
    // // Apply scope based on user's role
    // $monthlyReports = $this->Authorization->applyScope($monthlyReports, 'index');
    
    // // Apply filter based on selected operator
    // $operatorId = $this->request->getQuery('operator_id');
    // if ($operatorId) {
    //     $monthlyReports = $monthlyReports->where(['operator_id' => $operatorId]);
    // }
    
        // Get operator_id and state_owners_id from request
        $operatorId = $this->request->getQuery('operator_id');
        $stateOwnersId = $this->request->getQuery('state_owner_id');
        $startDate = $this->request->getQuery('start_date');
        $endDate = $this->request->getQuery('end_date');
        $flag = false;
        $msg = '';

    // Get all operators for the dropdown
    
if ($stateOwnersId) {
    $state = $this->MonthlyReports->StateOwners->States->find()
        ->select(['state_id'])
        ->where(['States.state_owner_id' => $stateOwnersId])
        ->toArray();

        if(empty($state)){
             $msg = "No operators for this State Owners";
             $operators = $this->MonthlyReports->Operators->find()
        ->order(['operator_first_name' => 'ASC'])
        ->toArray();
        }else{
            $stateIds = Hash::extract($state, '{n}.state_id');
            
    $operators = $this->MonthlyReports->Operators->find()
        ->where(['state_id IN' => $stateIds])
        ->order(['operator_first_name' => 'ASC'])
        ->toArray();
        $flag = true;
        // print_r($operators);    
    }
        
     
} else {
    $operators = $this->MonthlyReports->Operators->find('list', [
        'order' => ['operator_first_name' => 'ASC']
    ])->toArray();
}
$this->set(compact('msg'));
$this->set(compact('flag'));
$this->set(compact('operators'));

// Get all state owners for the dropdown

    $state_owners = $this->MonthlyReports->StateOwners->find('list', [
        'order' => ['state_owner_first_name' => 'ASC']
    ])->toArray();

$this->set(compact('state_owners'));
    
    

    $monthlyReports = $this->MonthlyReports->find()
        ->orderDesc('month');
    // $monthlyReports = $this->MonthlyReports->find()
    // ->orderDesc('receipt_total')
    // ->orderDesc('month')
    // ->group(['franchise_id']);
    
    // Apply scope based on user's role
    $monthlyReports = $this->Authorization->applyScope($monthlyReports, 'index');
    
    // Apply filter based on selected operator
if ($operatorId) {
    $monthlyReports = $monthlyReports->where(['operator_id' => $operatorId]);
} elseif ($stateOwnersId) {
    
    $operatorsIds = Hash::extract($operators, '{n}.operator_id');
    $monthlyReports = $monthlyReports->where(['operator_id IN' => $operatorsIds]);
    
}
if ($startDate && $endDate) {
    $monthlyReports = $monthlyReports->where(function ($exp) use ($startDate, $endDate) {
        return $exp->between('month', $startDate, $endDate, 'date');
    });
}
    
    
    if($stateOwnersId){
        $monthlyReports = $this->paginate($monthlyReports, ['limit' => 100]);
    }elseif($operatorId){
        $monthlyReports = $this->paginate($monthlyReports, ['limit' => 80]);
    }else{
        $monthlyReports = $this->paginate($monthlyReports);
    }
    $currentYear = $this->DatePreset->getCurrentYear();
    $months = $this->DatePreset->getAllMonthsUpToCurrent();
    $receiptSeries = [];
    $advertisingSeries = [];
    foreach ($months as $monthNum => $monthName) {
        foreach ($monthlyReports as $monthlyReport) {
            if ($monthlyReport->month->month === $monthNum && $monthlyReport->month->year === $currentYear) {
                $receiptSeries[$monthNum] = $monthlyReport->receipt_total;
                $advertisingSeries[$monthNum] = $monthlyReport->advertising_cost;
                break;
            }
            $receiptSeries[$monthNum] = 0;
            $advertisingSeries[$monthNum] = 0;
        }
    }
    $receiptChartData = ['labels' => $months, 'series' => $receiptSeries];
    $receiptChartData = json_encode($receiptChartData);
    $advertisingChartData = ['labels' => $months, 'series' => $advertisingSeries];
    $advertisingChartData = json_encode($advertisingChartData);
    if($startDate && $endDate){
        $this->set(compact('startDate','endDate'));
    }
    $this->set(compact('monthlyReports', 'currentYear', 'receiptChartData', 'advertisingChartData'));
}

    /**
     * View method
     *
     * @param string|null $id Monthly Report id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $monthlyReport = $this->MonthlyReports->get($id, [
            'contain' => ['Operators', 'Franchises'],
        ]);
        $this->Authorization->authorize($monthlyReport, 'view');
        $this->set(compact('monthlyReport'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $monthlyReport = $this->MonthlyReports->newEmptyEntity();
        $this->Authorization->authorize($monthlyReport, 'create');
        $today = FrozenDate::today();
        $month = $today->format('m');
        $year = $today->format('Y');
        $franchise_id = null;
        $operator_id = null;
        if (!$this->request->is('post')) {
            $month = $this->request->getQuery('month') ?? $month;
            $franchise_id = $this->request->getQuery('franchise_id');
            if ($franchise_id) {
                $franchise = $this->MonthlyReports->Franchises->get($franchise_id);
                $operator_id = $franchise->operator_id;
            }
        }
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['carpet_cleaning_res'] = $data['carpet_cleaning_res'] !== '' ? $data['carpet_cleaning_res'] : 0;
            $data['tile_grout_res'] = $data['tile_grout_res'] !== '' ? $data['tile_grout_res'] : 0;
            $data['carpet_cleaning_comm'] = $data['carpet_cleaning_comm'] !== '' ? $data['carpet_cleaning_comm'] : 0;
            $data['tile_grout_comm'] = $data['tile_grout_comm'] !== '' ? $data['tile_grout_comm'] : 0;
            $data['upholstery_cleaning'] = $data['upholstery_cleaning'] !== '' ? $data['upholstery_cleaning'] : 0;
            $data['hardwood_floor'] = $data['hardwood_floor'] !== '' ? $data['hardwood_floor'] : 0;
            $data['fabric_protectant'] = $data['fabric_protectant'] !== '' ? $data['fabric_protectant'] : 0;
            $data['miscellaneous'] = $data['miscellaneous'] !== '' ? $data['miscellaneous'] : 0;
            $data['receipt_total'] = $data['receipt_total'] !== '' ? $data['receipt_total'] : 0;
            $data['advertising_cost'] = $data['advertising_cost'] !== '' ? $data['advertising_cost'] : 0;
            $data['advertising_percentage'] = $data['advertising_percentage'] !== '' ? $data['advertising_percentage'] : 0;
            $data['month'] = new FrozenDate($this->request->getData('month'));
            $year = $data['month']->format('Y');
            $month = $data['month']->format('m');
            $data['month'] = $data['month']->toDateString();
            $monthlyReport = $this->MonthlyReports->patchEntity($monthlyReport, $data);
            if ($this->MonthlyReports->save($monthlyReport)) {
                $this->Flash->success(__('The monthly report has been saved.'));
                $monthlyReport = $this->MonthlyReports->get($monthlyReport->report_id, ['contain' => ['Operators', 'Operators.States.StateOwners']]);
                $operator = $monthlyReport->operator;
                $name = $operator->full_name;
                $content = $name . ' Has entered a monthly report for ' . $monthlyReport->month->format('M Y') . PHP_EOL;
                $content .= sprintf("Their revenue total is $%s", $monthlyReport->receipt_total);

                $data = [
                    'settings' => [
                        'to' => $monthlyReport->operator->state->state_owner->state_owner_email ?? 'linda@heavensbest.com',
                        'from' => 'no_reply@heavensbest.com',
                        'subject' => sprintf('[Report Entered] %s has entered a monthly report for (%s, %s).', $name, $month, $year),
                    ],
                    'content' => $content,
                ];
                $queuedJobsTable = TableRegistry::getTableLocator()->get('Queue.QueuedJobs');
                $queuedJobsTable->createJob('Email', $data);

                return $this->redirect(['controller' => 'MonthlyReports', 'action' => 'mainMenu']);
            }
            $this->Flash->error(__('The monthly report could not be saved. Please, try again.'));
        }
        $operators = $this->MonthlyReports->Operators->find('list');
        $operators = $this->Authorization->applyScope($operators, 'index');
        $franchises = $this->MonthlyReports->Franchises->find('list');
        $franchises = $this->Authorization->applyScope($franchises, 'list');
        if ($franchises->count() === 0) {
            $this->Flash->warning(__("You don't have any franchises. Contact corporate to add your franchises."));

            return $this->redirect('/');
        }

        $identity = $this->Authentication->getIdentity();
        $identifier = $identity->getIdentifier();
        $user = $this->MonthlyReports->Operators->Users->get($identifier);
        $operator = $this->MonthlyReports->Operators->find()->where(['user_id' => $identifier])->first();
        if (!$operator_id) {
            if ($operator) {
                /** @var \App\Model\Entity\Operator $operator */
                $operator_id = $operator->operator_id;
            }
        }
        if ($operator_id && !$user->has_manage_access) {
            $operators = $operators->where(['operator_id' => $operator_id]);
        }
        $this->set(compact('monthlyReport', 'operators', 'franchises', 'user', 'operator_id', 'month', 'year', 'franchise_id'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Monthly Report id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $monthlyReport = $this->MonthlyReports->get($id, [
            'contain' => ['Operators', 'Operators.Users', 'Operators.Users.UserTypes'],
        ]);
        $this->Authorization->authorize($monthlyReport, 'update');
        $identity = $this->Authentication->getIdentity();
        $identifier = $identity->getIdentifier();
        $user = $this->MonthlyReports->Operators->Users->get($identifier);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $data['month'] = new FrozenDate($this->request->getData('month'));
            $data['month'] = $data['month']->toDateString();
            $monthlyReport = $this->MonthlyReports->patchEntity($monthlyReport, $data);
            if ($this->MonthlyReports->save($monthlyReport)) {
                $this->Flash->success(__('The monthly report has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The monthly report could not be saved. Please, try again.'));
        }
        $operators = $this->MonthlyReports->Operators->find('list');
        $operators = $this->Authorization->applyScope($operators, 'index');
        $franchises = $this->MonthlyReports->Franchises->find('list');
        $franchises = $this->Authorization->applyScope($franchises, 'list');
        $this->set(compact('monthlyReport', 'operators', 'franchises', 'user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Monthly Report id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $monthlyReport = $this->MonthlyReports->get($id, ['contain' => ['Operators', 'Operators.Users']]);
        $this->Authorization->authorize($monthlyReport);
        if ($this->MonthlyReports->delete($monthlyReport)) {
            $this->Flash->success(__('The monthly report has been deleted.'));
        } else {
            $this->Flash->error(__('The monthly report could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'main-menu', 'controller' => 'MonthlyReports']);
    }

    /**
     * Display main menu.
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function mainMenu()
    {
        $user_id = $this->Authentication->getIdentity()->getIdentifier();
        $user = $this->MonthlyReports->Operators->Users->get($user_id);
        $reportsIndexLink = !$user->has_manage_access ?
            Router::url(['action' => 'index']) :
            Router::url(['action' => 'index']);
            // 'https://corp.heavensbest.com/company/site/admin/reports/new_admin_report.php';
        $franchises = $this->MonthlyReports->Franchises->find()->where(['franchise_status' => 'Active']);
        $franchises = $this->Authorization->applyScope($franchises, 'list');
        $currentYear = $this->DatePreset->getCurrentYear();
        $monthlyReports = $this->MonthlyReports->find()
            ->where(['AND' => [
                'month BETWEEN :start AND :end',
            ]])
            ->bind(':start', $currentYear . '-01-01')
            ->bind(':end', $currentYear . '-12-31');
        $monthlyReports = $this->Authorization->applyScope($monthlyReports, 'index');
        $months = $this->DatePreset->getAllMonthsUpToCurrent();
        $numMonths = count($months);
        $franchiseCount = $franchises->count();
        $monthlyReportCount = $monthlyReports->count();
        $totalReportsPossible = ($numMonths - 1) * $franchiseCount;
        $receiptTotal = $monthlyReports->sumOf('receipt_total');
        $advertisingCost = $monthlyReports->sumOf('advertising_cost');

        $receiptSeries = [];
        $advertisingSeries = [];
        $reportCollection = new Collection($monthlyReports);
        $groupedReports = $reportCollection->groupBy(function ($monthlyReport) {
            /** @var \App\Model\Entity\MonthlyReport $monthlyReport */
            return $monthlyReport->month->month;
        });
        foreach ($months as $monthNum => $monthName) {
            $found = false;
            foreach ($groupedReports as $key => $reportGroup) {
                if ($key === $monthNum) {
                    $group = new Collection($reportGroup);
                    $receiptSeries[0][] = ['meta' => __('Receipt Total'),
                        'value' => $group->sumOf('receipt_total'),
                    ];
                    $advertisingSeries[0][] = $group->sumOf('advertising_cost');
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $receiptSeries[0][] = [
                    'meta' => __('Receipt Total'),
                    'value' => 0,
                ];
                $advertisingSeries[0][] = 0;
            }
        }

        $receiptData = json_encode([
            'labels' => $months,
            'series' => $receiptSeries,
        ]);

        $advertisingData = json_encode([
            'labels' => $months,
            'series' => $advertisingSeries,
        ]);

        $commission_amount = 100.00;

        $this->set(compact('reportsIndexLink', 'user', 'monthlyReportCount', 'totalReportsPossible', 'receiptTotal', 'advertisingCost', 'receiptData', 'advertisingData', 'commission_amount'));
    }

    public function products()
    {
        $this->Authorization->skipAuthorization();
    }

    
    
    
}

<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MonthlyReport[]|\Cake\Collection\CollectionInterface $monthlyReports
 * @var string $receiptChartData
 * @var string $advertisingChartData
 * @var string $currentYear
 */
// 
use App\Model\Entity\MonthlyReport;
use App\View\AppView;
use Cake\Collection\CollectionInterface;

$this->assign('title', __("Your Monthly Stats"));

$this->Html->script('execute/reports/monthly/index_charts_generator.min.js?v1.0.10b', [
    'once' => true,
    'block' => true,
]);
$this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js', [
    'once' => true,
    'block' => true,
]);
$this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.3.1/purify.min.js', [
    'once' => true,
    'block' => true,
]);
$this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js', [
    'once' => true,
    'block' => true,
]);

 

?>
<?= $this->Html->link('<i class="material-icons">fast_rewind</i> Go Back', ['action' => 'mainMenu'], [
    'escape' => false,
    'class' => 'btn btn-sm btn-default'
]) ?>
<?= $this->Form->control('receipt_chart_data', ['type' => 'hidden', 'value' => $receiptChartData]) ?>
<?= $this->Form->control('advertising_chart_data', ['type' => 'hidden', 'value' => $advertisingChartData]) ?>

<?php if ($monthlyReports->count() !== 0): ?>
<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="card card-chart">
            <div class="card-header card-header-primary">
                <div class="ct-chart" id="monthlyReceiptTotals"></div>
            </div>
            <div class="card-body">
                <h4 class="card-title"><?= __('Receipt Totals for {0}', $currentYear) ?></h4>
                <p class="card-category">For the year <?= $currentYear ?></p>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-12">
        <div class="card card-chart">
            <div class="card-header card-header-danger">
                <div class="ct-chart" id="monthlyAdvertisingCosts"></div>
            </div>
            <div class="card-body">
                <h4 class="card-title"><?= __('Advertising Costs for {0}', $currentYear) ?></h4>
                <p class="card-category">For the year <?= $currentYear ?></p>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <?= $this->Html->link(__('Add Monthly Stats <i class="material-icons">add_circle</i>'), ['action' => 'add'], [
                    'class' => 'btn btn-danger float-right',
                    'escape' => false
                ]) ?>
                
                <?php if($admin) : ?>
                
                    <div class="row">
                    <?= $this->Form->create(null,['id' => 'filter-form', 'url' => ['controller' => 'MonthlyReports', 'action' => 'index'], 'type' => 'get']) ?>
                    <?= $this->Form->select('operator_id', ['' => 'Filter by Operators'] + $operators, ['class' => 'form-control', 'onChange' => 'submitForm()']) ?>
                    <?= $this->Form->select('state_owner_id', ['' => 'Filter by State Owners'] + $state_owners, ['class' => 'form-control', 'onChange' => 'submitForm()']) ?>
                    <?= $this->Form->date('start_date', ['id' => 'start-date', 'class' => 'form-control', 'onClick' => 'setFormSubmitted(false)', 'onBlur' => 'checkFormSubmission(event)', 'value' => isset($startDate) ? $startDate : '']) ?>
                    <?= $this->Form->date('end_date', ['id' => 'end-date', 'class' => 'form-control', 'onClick' => 'setFormSubmitted(false)', 'onBlur' => 'checkFormSubmission(event)', 'value' => isset($endDate) ? $endDate : '']) ?>
                    <?= $this->Form->button('Reset', ['type' => 'reset', 'onClick' => 'resetForm()']) ?>
                    <?= $this->Form->button('Generate PDF', ['onClick' => 'generatePdf(event)']) ?>

                <?= $this->Form->end() ?>
               
                </div>
                <script>
                    var isFormSubmitted = false;
                    var operators = <?= json_encode($operators) ?>;
                    var stateOwners = <?= json_encode($state_owners) ?>;
                   
                    function setFormSubmitted(value) {
                        isFormSubmitted = value;
                    }

                    function checkFormSubmission(event) {
                        event.preventDefault();
                        var startDate = document.getElementById('start-date').value;
                        var endDate = document.getElementById('end-date').value;
                        if (!isFormSubmitted && startDate && endDate && startDate <= endDate) {
                            isFormSubmitted = true; // Set the flag to true to prevent multiple submissions
                            submitForm();
                        }
                    }
                    
                    function submitForm() {
                        console.log('submitting form');
                                        // Get the "wrapper" element
                    var wrapperElement = document.querySelector('.wrapper');
                
                    // Set opacity to 0.5
                    wrapperElement.style.opacity = '0.5';
                
                    // Set pointer-events to none
                    wrapperElement.style.pointerEvents = 'none';
                        document.getElementById('filter-form').submit();
                    }

                    function resetForm() {
                        document.getElementById('filter-form').reset();
                        isFormSubmitted = false;
                        window.location.href = '<?= $this->Url->build(['controller' => 'MonthlyReports', 'action' => 'index']) ?>';
                    }
                    
                     function getObjectName(id, objectList) {
                     for (var key in objectList) {
                       if (key === id) {
                         return objectList[key];
                       }
                     }
                     return null; // Return null if ID not found
                   }
                   
                   
                    
                      function generatePdf(event) {
                         event.preventDefault();
                         console.log("stateowners", stateOwners);
                         console.log("operator", operators);
                       
                         // Get the URL and create a URLSearchParams object
                         var url = new URL(window.location.href);
                         var searchParams = new URLSearchParams(url.search);
                       
                         var operatorId = searchParams.get('operator_id');
                         var stateownerId = searchParams.get('state_owner_id');
                         var startDate = searchParams.get('start_date');
                         var endDate = searchParams.get('end_date');
                         var operatorName = getObjectName(operatorId, operators);
                         var stateownerName = getObjectName(stateownerId, stateOwners);
                         console.log(operatorName);
                         console.log(stateownerName);
                         console.log(startDate, endDate);
                       
                         window.jsPDF = window.jspdf.jsPDF;
                         var doc = new jsPDF();
                       
                         doc.setFontSize(6); // Set font size for the additional information
                       
                         // Add operator name, state owner, start date, and end date to the PDF if they are selected
                         var yPos = 25; // Initial y position for the additional information
                         if (operatorName) {
                           doc.text('Operator Name:', 15, yPos);
                           doc.text(operatorName, 50, yPos);
                           yPos += 10; // Increase y position after displaying the text
                         }
                         if (stateownerName) {
                           doc.text('State Owner:', 15, yPos);
                           doc.text(stateownerName, 50, yPos);
                           yPos += 10;
                         }
                         if (startDate) {
                           doc.text('Start Date:', 15, yPos);
                           doc.text(startDate, 50, yPos);
                           yPos += 10;
                         }
                         if (endDate) {
                           doc.text('End Date:', 15, yPos);
                           doc.text(endDate, 50, yPos);
                           yPos += 10;
                         }
                       
                         // Source HTMLElement or a string containing HTML.
                         var table = document.getElementById('monthlyReportsTable');
                         var tableHtml = table.innerHTML;
                       
                         tableHtml = tableHtml.replace(/<\/tr>/g, '</tr><br>');
                         tableHtml = tableHtml.replace(/<\/th>/g, '</th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
                         tableHtml = tableHtml.replace(/<\/td>/g, '</td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
                       
                         console.log(tableHtml);
                         doc.html(tableHtml, {
                           callback: function(doc) {
                             // Save the PDF
                             doc.save('sample-document.pdf');
                           },
                           x: 15,
                           y: yPos + 10, // Adjust the y position to leave space for the additional information
                           width: 100, // target width in the PDF document
                           windowWidth: 800 // window width in CSS pixels
                         });
                       }
                       
               
                    function toggleSubReports(element) {
                    var nextElement = element.nextElementSibling;
                            while (nextElement) {
                            if (nextElement.classList.contains('dropdown-row')) {
                              break;
                            }
                            if(nextElement.style.display === 'none') {
                                 nextElement.style.display = 'table-row';
                             } else {
                                 nextElement.style.display = 'none';
                             }
                            
                            nextElement  = nextElement.nextElementSibling;
                          }
                          
                    // var nextElement = element.nextElementSibling;
                    //   if (nextElement && nextElement.className == "sub-reports-row") {
                       
                    //          if(nextElement.style.display === 'none') {
                    //              nextElement.style.display = 'table-row';
                    //          } else {
                    //              nextElement.style.display = 'none';
                    //          }
                    //   }
                    
                }
                // function toggleSubReports(element) {
                //       var nextElements = document.getElementsByClassName('sub-reports-row');
                      
                //       var startIndex = Array.from(nextElements).indexOf(element.nextElementSibling);
                      
                //       for (var i = startIndex; i < nextElements.length; i++) {
                //         var nextElement = nextElements[i];
                        
                //         if (nextElement.style.display === 'none') {
                //           nextElement.style.display = 'table-row';
                //         } else {
                //           nextElement.style.display = 'none';
                //         }
                //       }
                //     }



                

                </script>

                <?php endif; ?>
               
                <?php ob_start(); ?>
                <table id='monthlyReportsTable' class="table table-striped table-responsive-md">
                    <thead>
                    <tr>
                        <th><?= $this->Paginator->sort('Franchise') ?></th>
                        <th><?= $this->Paginator->sort('month') ?></th>
                        <th><?= $this->Paginator->sort('receipt_total') ?></th>
                        <th><?= $this->Paginator->sort('advertising_cost') ?></th>
                        <th><?= $this->Paginator->sort('advertising_percentage') ?></th>
                        <!--<th><?= __('Actions') ?></th>-->
                    </tr>
                    </thead>
                    <tbody>
                        
                        <?php
                        $groupedReports = []; // Create an empty array to store the grouped reports
                        $lowerReceiptReports = [];
                        // Group the reports by franchise name and keep track of the highest receipt total
                        foreach ($monthlyReports as $monthlyReport) {
                            $franchise = $monthlyReport->franchise->franchise_name;
                            $receiptTotal = $monthlyReport->receipt_total;

                            // If the franchise is already in the grouped reports array, compare receipt totals
                            if (isset($groupedReports[$franchise])) {
                                if ($receiptTotal > $groupedReports[$franchise]->receipt_total) {
                                    $lowerReceiptReports[$franchise][] = $groupedReports[$franchise];
                                    $groupedReports[$franchise] = $monthlyReport;
                                }else{
                                    $lowerReceiptReports[$franchise][] = $monthlyReport;
                                }
                            } else { // If the franchise is not yet in the grouped reports array, add it
                                $groupedReports[$franchise] = $monthlyReport;
                                // $subReport[$franchise][0] = $monthlyReport;
                            }
                        }
                        
                        ?>
                        <?php function compareDatesDescending($a, $b) {
                                return strtotime($b->month) - strtotime($a->month);
                            }
                            
                            // Sort the array using the custom comparison function while maintaining keys
                            uasort($groupedReports, 'compareDatesDescending');
                            ?>
                        
                    
                    <?php foreach ($groupedReports as $franchise => $monthlyReport): ?>
                       
                        <tr onclick="toggleSubReports(this)" class="dropdown-row">
                            <td>
                            <div class="franchise-name" >
                                <?= $monthlyReport->franchise->franchise_name ?>
                                <?php if(isset($lowerReceiptReports[$franchise])) : ?>
                                <i class="material-icons">arrow_drop_down</i>
                                <?php endif; ?>
                            </div>
                            </td>
                            <td><?= $this->Html->link($monthlyReport->month->format('F Y'), [
                                    'action' => 'view',
                                    $monthlyReport->report_id,
                                ]) ?></td>
                            <td><?= $this->Number->currency(h($monthlyReport->receipt_total), 'USD') ?></td>
                            <td><?= $this->Number->currency(h($monthlyReport->advertising_cost), 'USD') ?></td>
                            <td><?= $this->Number->toPercentage(h($monthlyReport->advertising_percentage)) ?></td>
                           
                        </tr>
                        <?php if (isset($lowerReceiptReports[$franchise])): ?>
                        
                            <?php foreach ($lowerReceiptReports[$franchise] as $subReport) : ?>
                        <tr class="sub-reports-row" style="display:none;" >
                            <!--<td colspan="5">-->
                                <!--<table class="sub-reports-table" style="width:90%;">-->
                                    
                                        <!--<tr>-->

                                            <td><?= $subReport->franchise->franchise_name ?></td>
                                            <td><?= $this->Html->link($subReport->month->format('F Y'), [
                                                'action' => 'view',
                                                $subReport->report_id,
                                            ]) ?></td>
                                            <td><?= $this->Number->currency(h($subReport->receipt_total), 'USD') ?></td>
                                            <td><?= $this->Number->currency(h($subReport->advertising_cost), 'USD') ?></td>
                                            <td><?= $this->Number->toPercentage(h($subReport->advertising_percentage)) ?></td>

                                        <!--</tr>-->
                                    
                                <!--</table>-->
                            <!--</td>-->
                        </tr>
                        <?php endforeach ;?>
                    <?php endif; ?>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td class="lead text-success">Totals/Averages</td>
                        <td class="lead text-success"></td>
                        <td class="lead text-success"><?= $this->Number->currency($monthlyReports->sumOf('receipt_total'), 'USD') ?></td>
                        <td class="lead text-success"><?= $this->Number->currency($monthlyReports->sumOf('advertising_cost'), 'USD') ?></td>
                        <td class="lead text-success"><?= $this->Number->toPercentage($monthlyReports->avg('advertising_percentage')) ?></td>
                    </tr>
                    </tfoot>
                </table>
                <?php $tableHTML = ob_get_contents(); 
                ob_end_clean();
                echo $tableHTML;
                ?>
                
                
                <div class="paginator">
                    <ul class="pagination">
                        <?= $this->Paginator->first(__('First'), ['escape' => false]) ?>
                        <?= $this->Paginator->numbers(['modulus' => 2]) ?>
                        <?= $this->Paginator->last(__('Last'), ['escape' => false]) ?>
                    </ul>
                    <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} report(s) out of {{count}} total')) ?></p>
                </div>
            </div>
        </div>
    </div>
</div>


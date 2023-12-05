<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MonthlyReport[]|\Cake\Collection\CollectionInterface $monthlyReports
 * @var string $receiptChartData
 * @var string $advertisingChartData
 * @var string $currentYear
 */

use App\Model\Entity\MonthlyReport;
use App\View\AppView;
use Cake\Collection\CollectionInterface;


$this->assign('title', __("Heavens Best Advertising"));
$this->Html->script('build/site.bundle.js?v=1.0.0a', ['block' => true]);
?>
<h2><?= __("Heaven's Best Marketing Materials." )?></h2>
<p class="lead"><?= __('Click on Ad for more info.') ?></p>
<div class="row">
<?php foreach ($hbads as $hbad): ?>
    
        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="card-header card-header-image">
                <?= 
                    $this->Html->image($hbad->image_location, ['width' => '400', 'height' => '400','pathPrefix' => '/webroot/img/uploads/', 'alt' => $hbad->title]);
                     ?>
                    <h3 class="card-title"><?= h($hbad->title) ?></h3>
                </div>
                <div class="card-body">
                    <p class="card-text"><?= h($hbad->description) ?></p>
                    <?= $this->Html->link(__('More'), [
                                'action' => 'view',
                                $hbad->hbad_id
                            ], ['class' => 'btn btn-lg btn-primary']) ?>
                </div>
            </div>
        </div>
   
<?php endforeach; ?>
</div>




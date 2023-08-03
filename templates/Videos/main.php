
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


$this->assign('title', __("Heavens Best Training Videos"));
$this->Html->script('build/site.bundle.js?v=1.0.0a', ['block' => true]);
?>
<h2><?= __("Heaven's Best Training Videossss." )?></h2>
<p class="lead"><?= __('Click on videos to watch.') ?></p>
<div class="row">
<?php foreach ($videos as $video): ?>
    
        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="card-header card-header-image">
                <?= $this->Html->link(
                        $this->Html->image($video->thumbnail_location, ['pathPrefix' => '/webroot/videos/uploads/', 'alt' => $video->title]),
                        ['action' => 'view', $video->video_id],
                        ['escapeTitle' => false]
                    ) ?>
                    <h3 class="card-title"><?= h($video->title) ?></h3>
                </div>
                <div class="card-body">
                    <p class="card-text"><?= h($video->description) ?></p>
                    <?= $this->Html->link(__('Watch Video on Youtube'), $video->video_location, ['class' => 'btn btn-lg btn-primary', 'target' => '_blank']) ?>

                </div>
            </div>
        </div>
   
<?php endforeach; ?>
</div>




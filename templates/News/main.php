

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


$this->assign('title', __("Heavens Best Newsletters"));
$this->Html->script('build/site.bundle.js?v=1.0.0a', ['block' => true]);
?>
<h2><?= __("Heaven's Best Newsletters." )?></h2>
<p class="lead"><?= __('Click to Read.') ?></p>
<div class="row">
<?php foreach ($newsletters as $newsletter): ?>
    
        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="card-header card-header-image">
                <?= $this->Html->link(
                        $this->Html->image($newsletter->newsletter_location, ['pathPrefix' => '/webroot/newsletter/uploads/', 'alt' => $newsletter->title]),
                        ['action' => 'view', $newsletter->newsletter_id],
                        ['escapeTitle' => false]
                    ) ?>
                    <h3 class="card-title"><?= h($newsletter->title) ?></h3>
                </div>
                <div class="card-body">
                    <p class="card-text"><?= h($newsletter->description) ?></p>
                    <?= $this->Html->link(__('Read'), $newsletter->newsletter_location, ['class' => 'btn btn-lg btn-primary', 'target' => '_blank']) ?>

                </div>
            </div>
        </div>
   
<?php endforeach; ?>
</div>




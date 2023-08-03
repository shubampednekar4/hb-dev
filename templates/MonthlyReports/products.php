<?php
/**
 * @var \App\View\AppView $this
 */

use Cake\I18n\FrozenDate;

$this->assign('title', 'Products & Orders Report');
$this->Html->script('build/productOrderReport.bundle.js?v=1.0.0a', ['block' => true]);
$date = new FrozenDate();
?>
<h2 class="sr-only"><?= __($this->fetch('title')) ?></h2>
<div id="report">
    <div class="row justify-content-center">
        <div class="col-xl-6 col-md-12">
            <span class="h1 text-info">Loading Report...</span>
        </div>
    </div>
</div>


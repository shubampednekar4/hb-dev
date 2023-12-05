<?php
/**
 * @var \App\View\AppView $this
 */

use App\View\AppView;

$this->assign('title', 'Reports');
?>

<h2><?= __($this->fetch('title')) ?></h2>

<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="card">
            <div class="card-header card-header-primary" data-background-image="<?= $this->Url->image('site/logo.png') ?>">
                <h4 class="card-title"><i class="far fa-calendar-alt"></i> <?= __('Monthly Reports') ?></h4>
                <p class="card-category"><?= __('Monthly Statistics for Franchises and Operators') ?></p>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <?= $this->Html->link('<i class="fas fa-plus-circle"></i> ' . __('Add Monthly Report'), ['action' => 'addMonthly'], [
                            'class' => 'btn btn-danger',
                            'escape' => false,
                        ]) ?>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <?= $this->Html->link('<i class="fas fa-eye"></i> ' . __('Review Monthly Reports'), ['action' => 'viewAllMonthly'], [
                            'class' => 'btn btn-primary',
                            'escape' => false,
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-12">
        <div class="card">
            <div class="card-header card-header-success">
                <h4 class="card-title"><i class="fas fa-comment-dollar"></i> <?= __('Commission Reports') ?></h4>
                <p class="card-category"><?= __('Commission Payments Owed to State Owners') ?></p>
            </div>
            <div class="card-body">
                <p class="card-text text-success lead"><i class="fas fa-thumbs-up"></i> <?= __('Coming Soon!') ?> <i class="fas fa-thumbs-up"></i></p>
            </div>
        </div>
    </div>
</div>

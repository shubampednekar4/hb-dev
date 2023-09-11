<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Operator $operator
 * @var mixed $states
 * @var mixed $users
 * @var mixed $countries
 * @var mixed $stateOptions
 * @var mixed $countryOptions
 */

use App\Model\Entity\Operator;
use App\View\AppView;

$this->assign('title', 'Add Training Videos');
?>
<?= $this->Html->link('<i class="material-icons">fast_rewind</i> Go Back', ['action' => 'index',], [
    'escapeTitle' => false,
    'class' => 'btn btn-sm btn-info'
]) ?>
<div class="card">
    <header class="card-header card-header-danger">
        <h2 class="card-title"><i class="material-icons">add_circle</i> <?= __($this->fetch('title')) ?></h2>
        <p class="card-category">Add New Training Videos To The System</p>
    </header>


    <section class="card-body">
    <?= $this->Form->create($video, ['enctype' => 'multipart/form-data']) ?>

        <h3>Add Training Videos</h3>
        <div class="row">
            <div class="form-group col-md-6 col-sm-12">
                <?= $this->Form->control('title', [
                    'class' => 'form-control',
                    'label' => 'Title',
                ]); ?>
            </div>
            <div class="form-group col-md-12">
            <?= $this->Form->control('description', [
    'class' => 'form-control',
    'label' => 'Description',
    'type' => 'textarea',
]); ?>
            </div>
        </div>
        <div class="row">
        <div class="form-group col-md-6 col-sm-12">
        <?= $this->Form->control('video_location', [
                    'class' => 'form-control',
                    'label' => 'Video Url',
                ]); ?>
        </div>
        <div class="form-group col-md-6 col-sm-12">
        <?= $this->Form->control('thumbnail_location', [
    'class' => 'form-control',
    'label' => 'Image',
    'type' => 'file',
]); ?>
        </div>
</div>

        <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-success']) ?>
        <?= $this->Form->end() ?>
    </section>
</div>

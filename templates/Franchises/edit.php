<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var mixed $operators
 * @var mixed $stateOwners
 * @var array $userTypeOptions
 * @var User $actor
 * @var User $currentUser
 */

use App\Model\Entity\User;
use App\Model\Entity\Newsletter;
use App\View\AppView;

$this->assign('title', __('Edit Franchise "{0}"', $franchise->title));
?>

<?= $this->Html->link('<i class="material-icons">visibility</i> ' . $->title , ['action' => 'view', $franchise->franchise_id], [
    'escape' => false,
    'class' => 'btn btn-sm btn-primary'
]) ?>


<div class="card">
    <header class="card-header card-header-primary">
        <h2><i class="material-icons">edit</i> <?= __($this->fetch('title')) ?></h2>
        <p>Change Franchise Owner.</p>
    </header>
    <section class="card-body">
        <?= $this->Form->create($franchise, ['autofill' => 'off']) ?>
        <div class="form-row">
            <div class="col-lg-6 col-md-12">
                <div class="form-group">
                    <?= $this->Form->control('title', [
                        'class' => 'form-control',
                        'label' => 'Title',
                        'required',
                    ]) ?>
                </div>
            </div>
       
        </div>
        <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-success']) ?>
        <?= $this->Form->end() ?>
    </section>
</div>
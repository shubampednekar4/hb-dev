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
use App\Model\Entity\Hbads;
use App\View\AppView;

$this->assign('title', __('Edit Ads "{0}"', $hbad->title));
?>

<?= $this->Html->link('<i class="material-icons">visibility</i> ' . $hbad->title , ['action' => 'view', $hbad->hbad_id], [
    'escape' => false,
    'class' => 'btn btn-sm btn-primary'
]) ?>
<?php if ($currentUser->is_admin): ?>
    <?= $this->Html->link('<i class="material-icons">list</i> All Ads', ['action' => 'index'], [
        'escape' => false,
        'class' => 'btn btn-sm btn-info'
    ]) ?>
    <?= $this->Form->postLink('<i class="material-icons">delete</i> Delete Ad', ['action' => 'delete',$hbad->hbad_id], [
        'escapeTitle' => false,
        'class' => 'btn btn-sm btn-danger',
        'confirm' => 'Are you sure you want to delete this Ad?'
    ]) ?>
<?php endif; ?>

<div class="card">
    <header class="card-header card-header-primary">
        <h2><i class="material-icons">edit</i> <?= __($this->fetch('title')) ?></h2>
        <p>Alter Ad information.</p>
    </header>
    <section class="card-body">
        <?= $this->Form->create($hbad, ['autofill' => 'off']) ?>
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
            <div class="col-lg-6 col-md-12">
                <div class="form-group">
                    <?= $this->Form->control('description', [
                        'class' => 'form-control',
                        'label' => 'Description',
                        'required',
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-lg-6 col-md-12">
                <div class="form-group">
                    <div class="input-group"></div>
                    <?= 
                    $this->Html->image($hbad->image_location, ['width' => '50', 'height' => '50', 'pathPrefix' => '/webroot/img/uploads/', 'alt' => $hbad->title]);
                ?>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="form-group">
                <?= 
                    $this->Html->image($hbad->image_location, ['width' => '50', 'height' => '50', 'pathPrefix' => '/webroot/img/uploads/', 'alt' => $hbad->title]);
                ?>
                </div>
            </div>
        </div>
        <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-success']) ?>
        <?= $this->Form->end() ?>
    </section>
</div>
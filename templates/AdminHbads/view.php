<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var User $currentUser
 */

use App\Model\Entity\User;
use App\Model\Entity\Hbads;
use App\View\AppView;

$this->assign('title', __('Advertisment Details'));
?>

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
        <h2 class="card-title"><i class="material-icons">person</i> <?= __($this->fetch('title')) ?></h2>
        <p class="card-category"><?= __('For {0} ', $hbad->title) ?></p>
    </header>
    <section class="card-body">
            <p class="card-text"><i class="material-icons">vpn_key</i> <?= h($hbad->description) ?></p>
            <p class="card-text"><i class="material-icons">alternate_email</i> 
            <?= 
                        $this->Html->image($hbad->image_location,
                         ['width' => '100', 'height' => '100','pathPrefix' => '/webroot/img/uploads/', 'alt' => $hbad->title]);
                     ?>
        </p>
            <?= $this->Html->link('<i class="material-icons">edit</i> Edit Ad', [
                'action' => 'edit',
                $hbad->hbad_id
            ], ['class' => 'btn btn-primary', 'escape' => false]) ?>
    </section>
</div>
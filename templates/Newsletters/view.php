<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var User $currentUser
 */

use App\Model\Entity\User;
use App\Model\Entity\Newsletters;
use App\View\AppView;

$this->assign('title', __('Newsletter Details'));
?>

<?php if ($currentUser->is_admin): ?>
    <?= $this->Html->link('<i class="material-icons">list</i> All Newsletters', ['action' => 'index'], [
        'escape' => false,
        'class' => 'btn btn-sm btn-info'
    ]) ?>
    <?= $this->Form->postLink('<i class="material-icons">delete</i> Delete Newsletter', ['action' => 'delete',$newsletter->newsletter_id], [
        'escapeTitle' => false,
        'class' => 'btn btn-sm btn-danger',
        'confirm' => 'Are you sure you want to delete this Newsletter?'
    ]) ?>
<?php endif; ?>
<div class="card">
    <header class="card-header card-header-primary">
        <h2 class="card-title"><i class="material-icons">person</i> <?= __($this->fetch('title')) ?></h2>
        <p class="card-category"><?= __('For {0} ', $newsletter->title) ?></p>
    </header>
    <section class="card-body">
            <p class="card-text"><i class="material-icons">description</i> <?= h($newsletter->description) ?></p>
            <p class="card-text"><i class="material-icons">image</i> 
            <?= $this->Html->link(
                        h($newsletter->newsletter_location),
                    ) ?>
        </p>
           
            <?= $this->Html->link('<i class="material-icons">edit</i> Edit Newsletter', [
                'action' => 'edit',
                $newsletter->newsletter_id
            ], ['class' => 'btn btn-primary', 'escape' => false]) ?>
    </section>
</div>
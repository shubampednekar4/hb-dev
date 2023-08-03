<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var User $currentUser
 */

use App\Model\Entity\User;
use App\Model\Entity\Videos;
use App\View\AppView;

$this->assign('title', __('Video Details'));
?>

<?php if ($currentUser->is_admin): ?>
    <?= $this->Html->link('<i class="material-icons">list</i> All Videos', ['action' => 'index'], [
        'escape' => false,
        'class' => 'btn btn-sm btn-info'
    ]) ?>
    <?= $this->Form->postLink('<i class="material-icons">delete</i> Delete Video', ['action' => 'delete',$video->video_id], [
        'escapeTitle' => false,
        'class' => 'btn btn-sm btn-danger',
        'confirm' => 'Are you sure you want to delete this Video?'
    ]) ?>
<?php endif; ?>
<div class="card">
    <header class="card-header card-header-primary">
        <h2 class="card-title"><i class="material-icons">person</i> <?= __($this->fetch('title')) ?></h2>
        <p class="card-category"><?= __('For {0} ', $video->title) ?></p>
    </header>
    <section class="card-body">
            <p class="card-text"><i class="material-icons">description</i> <?= h($video->description) ?></p>
            <p class="card-text"><i class="material-icons">image</i> 
            <?= $this->Html->link(
                        h($video->video_location),
                    ) ?>
        </p>
            <p class="card-text"><i class="material-icons">image</i> 
            <?= $this->Html->link(
                        $this->Html->image($video->thumbnail_location, ['pathPrefix' => '/webroot/videos/uploads/', 'alt' => $video->title]),
                        ['action' => 'view', $video->video_id],
                        ['escapeTitle' => false]
                    ) ?>
        </p>
            <?= $this->Html->link('<i class="material-icons">edit</i> Edit Video', [
                'action' => 'edit',
                $video->video_id
            ], ['class' => 'btn btn-primary', 'escape' => false]) ?>
    </section>
</div>
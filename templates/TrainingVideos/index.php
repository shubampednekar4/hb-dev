
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Operator[]|\Cake\Collection\CollectionInterface $operators
 * @var bool $resetNeeded
 * @var string|null $search
 * @var User $currentUser
 */

use App\Model\Entity\User;

$this->assign('title', $resetNeeded ? __('Results for "{0}"', h($search)) : __("Training Videos"));
?>
<div class="card">
    <header class="card-header card-header-danger">
        <h2 class="card-title"><i class="material-icons">home_repair_service</i> <?= $this->fetch('title') ?></h2>
        <p class="card-category"><?= $resetNeeded ? "Results Found: (".$hbads->count().")" : __("Manage Training Videos") ?></p>
    </header>
    <section class="card-body">
        <div class="row">
            <div class="col-lg-4 col-md-12">
                <?= $this->Search->create($resetNeeded, $search); ?>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="float-right">
                    <?php if ($currentUser->is_admin): ?>
                        <?= $this->Html->link(__('New Add <i class="material-icons">add_circle</i>'),
                            ['action' => 'add'], [
                                'class'  => 'btn btn-info float-right',
                                'escape' => false
                            ]) ?>
                    <?php endif ?>
                </div>
            </div>
        </div>
        <table class="table table-responsive-md table-striped">
            <thead>
            <tr>
                <th class="d-none d-md-table-cell">Title</th>
                <th class="d-none d-md-table-cell">Description</th>
                <th class="d-none d-md-table-cell">Video Url</th>
                <th class="d-none d-md-table-cell">Video Thumbnail</th>
                <!-- <th class="d-none d-md-table-cell"><?= $this->Paginator->sort('title', 'Title') ?></th>
                <th class="d-none d-md-table-cell"><?= $this->Paginator->sort('description', 'Description') ?></th>
                <th class="d-none d-md-table-cell"><?= $this->Paginator->sort('image_location', 'Image') ?></th> -->
                <th class="actions d-none d-md-table-cell"><?= __('Actions') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($videos as $video): ?>
                <?php
                $skip = false;
                // if ($operator->franchises) {
                //     foreach ($operator->franchises as $franchise) {
                //         if ($franchise->franchise_status === 'Inactive') {
                //             $skip = true;
                //             break;
                //         }
                //     }
                // }
                // if ($skip) {
                //     continue;
                // }
                ?>

                <tr>
                    <td class="d-sm-block d-md-table-cell">
                        <?= $this->Html->link(h($video->title), [
                            'action' => 'view',
                            $video->video_id,
                        ]) ?>
                        <div class="d-md-none d-sm-block justify-content-between">
                            <?= $this->Html->link('<i class="material-icons">visibility</i> '.'<span class="sr-only">'.__('View').'</span>',
                                [
                                    'action' => 'view',
                                    $video->video_id
                                ], [
                                    'escape' => false,
                                    'class'  => 'btn btn-sm btn-primary btn-round btn-just-icon'
                                ]) ?>
                            <?php if ($currentUser->is_admin): ?>
                                <?= $this->Html->link('<i class="material-icons">edit</i> '.'<span class="sr-only">'.__('Edit').'</span>',
                                    [
                                        'action' => 'edit',
                                        $video->video_id
                                    ], [
                                        'escape' => false,
                                        'class'  => 'btn btn-sm btn-success btn-round btn-just-icon'
                                    ]) ?>
                                <?= $this->Form->postLink('<i class="material-icons">delete</i> '.'<span class="sr-only">'.__('Delete').'</span>',
                                    [
                                        'action' => 'delete',
                                        $video->video_id
                                    ], [
                                        'confirm'     => __('Are you sure you want to remove {0} from Video database?',
                                            $video->title),
                                        'escapeTitle' => false,
                                        'class'       => 'btn btn-sm btn-danger btn-round btn-just-icon'
                                    ]) ?>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td class="d-none d-md-table-cell"><?= $this->Html->link(h($video->title),
                            'mailto:'.h($video->description)) ?></td>
                    <td class="d-none d-md-table-cell">
                    <?= $this->Html->link(
                        h($video->video_location),
                    ) ?>
                    </td>
                    <td class="d-none d-md-table-cell">
                    <?= $this->Html->link(
                        $this->Html->image($video->thumbnail_location, ['width' => '50', 'height' => '50','pathPrefix' => '/webroot/videos/uploads/', 'alt' => $video->title]),
                        ['action' => 'view', $video->video_id],
                        ['escapeTitle' => false]
                    ) ?>
                    </td>
                    <td class="d-none d-md-table-cell actions">
                        <?= $this->Html->link('<i class="material-icons">visibility</i> '.'<span class="sr-only">'.__('View').'</span>',
                            [
                                'action' => 'view',
                                $video->video_id
                            ], [
                                'escape' => false,
                                'class'  => 'btn btn-sm btn-primary btn-round btn-just-icon'
                            ]) ?>
                        <?php if ($currentUser->is_admin): ?>
                            <?= $this->Html->link('<i class="material-icons">edit</i> '.'<span class="sr-only">'.__('Edit').'</span>',
                                [
                                    'action' => 'edit',
                                    $video->video_id
                                ], [
                                    'escape' => false,
                                    'class'  => 'btn btn-sm btn-success btn-round btn-just-icon'
                                ]) ?>
                            <?= $this->Form->postLink('<i class="material-icons">delete</i> '.'<span class="sr-only">'.__('Delete').'</span>',
                                [
                                    'action' => 'delete',
                                    $video->video_id,
                                ], [
                                    'confirm' => __('Are you sure you want to remove {0} from Video database?',
                                        $video->title),
                                    'escapeTitle'  => false,
                                    'class'   => 'btn btn-sm btn-danger btn-round btn-just-icon'
                                ]) ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div class="paginator">
           
        </div>
    </section>
</div>


<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Navigation $navigation
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Navigation'), ['action' => 'edit', $navigation->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Navigation'), ['action' => 'delete', $navigation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $navigation->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Navigation'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Navigation'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="navigation view content">
            <h3><?= h($navigation->title) ?></h3>
            <table>
                <tr>
                    <th><?= __('Title') ?></th>
                    <td><?= h($navigation->title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Controller') ?></th>
                    <td><?= h($navigation->controller) ?></td>
                </tr>
                <tr>
                    <th><?= __('Action') ?></th>
                    <td><?= h($navigation->action) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($navigation->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($navigation->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($navigation->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>

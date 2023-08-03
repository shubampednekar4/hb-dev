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
            <?= $this->Html->link(__('List Navigation'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="navigation form content">
            <?= $this->Form->create($navigation) ?>
            <fieldset>
                <legend><?= __('Add Navigation') ?></legend>
                <?php
                    echo $this->Form->control('title');
                    echo $this->Form->control('controller');
                    echo $this->Form->control('action');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

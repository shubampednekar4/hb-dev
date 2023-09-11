<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Operator $operator
 * @var \App\Model\Entity\User $user
 */

use App\Model\Entity\Operator;
use App\Model\Entity\User;
use App\View\AppView;

$this->assign('title', __('Operator  info 2'));
?>


<?php if ($user->is_admin): ?>
    <?= $this->Html->link('<i class="material-icons">list</i> All Operators', ['action' => 'index'], [
        'escape' => false,
        'class' => 'btn btn-sm btn-info'
    ]) ?>
    <?= $this->Form->postlink('<i class="material-icons">delete</i> Delete Operator', [
        'action' => 'delete',
        $operator->operator_id,
    ], [
        'escapeTitle' => false,
        'class' => 'btn btn-sm btn-danger',
        'confirm' => 'Are you sure you want to delete this item?',
    ]) ?>
<?php elseif ($user->has_manage_access): ?>
    <?= $this->Html->link('<i class="material-icons">list</i> All Operators', ['action' => 'index'], [
        'escape' => false,
        'class' => 'btn btn-sm btn-info'
    ]) ?>
<?php else: ?>
    <?= $this->Html->link('<i class="material-icons">fast_rewind</i> Go Back', '/', [
        'escape' => false,
        'class' => 'btn btn-sm btn-info'
    ]) ?>
<?php endif; ?>
<div class="card">
    <header class="card-header card-header-danger">
        <h2 class="card-title"><i class="material-icons">home_repair_service</i> <?= __($this->fetch('title')) ?></h2>
        <p class="card-category"><?= __('Operator Info for {0} {1}', $operator->operator_first_name, $operator->operator_last_name) ?></p>
    </header>
    <section class="card-body view-info">
        <p class="card-text">
            <i class="material-icons d-md-inline d-block">push_pin</i> <?= $operator->has('state') ? h($operator->state->full_name) : '<span class="text-danger">No State Selected</span>' ?>
        </p>
        <p class="card-text">
            <i class="material-icons d-md-inline d-block">alternate_email</i> <?= $this->Html->link(h($operator->operator_email), 'mailto:' . h($operator->operator_email)) ?>
        </p>
        <p class="card-text">
            <i class="material-icons d-md-inline d-block">phone</i> <?= $this->Html->link(h($operator->operator_phone), 'tel:' . $operator->operator_phone) ?>
        </p>
        <p class="card-text">
            <i class="material-icons d-md-inline d-block">location_on</i>
            <span class="d-md-inline d-none">
                <?php
                $link = $this->Address->getAddressLink([
                    'street_address' => $operator->operator_address,
                    'city' => $operator->operator_city,
                    'state' => $operator->operator_state,
                    'zip' => $operator->operator_zip
                ]);
                $title = sprintf('%s, %s, %s %s', h($operator->operator_address), h($operator->operator_city), h($operator->operator_state), h($operator->operator_zip));
                echo $this->Html->link($title, $link, ['target' => '_blank']);
                ?>
            </span>
            <span class="d-sm-inline d-md-none small">
                <?php
                $title = sprintf('%s<br>%s, %s %s', h($operator->operator_address), h($operator->operator_city), h($operator->operator_state), h($operator->operator_zip));
                echo $this->Html->link($title, $link, ['escapeTitle' => false, 'target' => '_blank']);
                ?>
            </span>
        </p>
        <?php if ($user->is_admin) {
            echo $this->Html->link('<i class="material-icons"></i> Edit Operator', [
                'action' => 'edit',
                $operator->operator_id
            ], ['class' => 'btn btn-primary', 'escape' => false]);
        }
        ?>
    </section>
</div>
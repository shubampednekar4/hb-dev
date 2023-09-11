<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\StateOwner $stateOwner
 * @var mixed $stateOwnerStates
 */

use App\Model\Entity\State;
use App\Model\Entity\StateOwner;
use App\View\AppView;

$this->assign('title', __('Review State Owner'));
?>

<?= $this->Html->link('<i class="material-icons">list</i> All State Owners', ['action' => 'index'], [
    'escape' => false,
    'class' => 'btn btn-sm btn-info'
]) ?>
<?= $this->Form->postlink('<i class="material-icons">delete</i> Delete State Owner', ['action' => 'delete'], [
    'escapeTitle' => false,
    'class' => 'btn btn-sm btn-danger',
    'confirm' => 'Are you sure you want to delete this item?',
]) ?>
<div class="card">
    <header class="card-header card-header-warning">
        <h2 class="card-title"><i class="material-icons">visibility</i> <?= __($this->fetch('title')) ?></h2>
        <p class="card-category"><?= __('State Owner Information for {0} {1}', h($stateOwner->state_owner_first_name), h($stateOwner->state_owner_last_name)) ?></p>
    </header>
    <section class="card-body view-info">
        <div class="view-info-container">
            <h3 class="card-title"><?= __('States:') ?></h3>
            <p class="card-text">
                <?php
                $stateNames = [];
                /** @var State $state */
                foreach ($stateOwnerStates as $state) {
                    $stateNames[] = $state->full_name;
                }
                echo join(', ', $stateNames);
                ?>
            </p>
        </div>
        <hr>
        <div class="view-info-container">
            <p class="card-text">
                <i class="material-icons">alternate_email</i> <?= $stateOwner->state_owner_email !== ""
                    ? $this->Html->link(h($stateOwner->state_owner_email), 'mailto:' . h($stateOwner->state_owner_email))
                    : '<span class="text-danger">' . __('No Email') . '</span>' ?>
            </p>
        </div>
        <div class="view-info-container">
            <p class="card-text">
                <i class="material-icons">call</i>
                <?= $stateOwner->state_owner_phone !== '' ? $this->Html->link(h($stateOwner->state_owner_phone),
                    'tel:+1' . $stateOwner->state_owner_phone)
                    : '<span class="text-danger">' . __('No Phone') . '</span>' ?>
            </p>
        </div>
        <div class="view-info-container">
            <p class="card-text">
                <i class="material-icons">location_on</i>
                <?php
                if (!empty($stateOwner->state_owner_address) && !empty($stateOwner->state_owner_city && !empty($stateOwner->state->full_name) && !empty($stateOwner->state_owner_zip))) {
                    $data = [
                        'street_address' => $stateOwner->state_owner_address,
                        'city' => $stateOwner->state_owner_city,
                        'state' => $stateOwner->state->full_name,
                        'zip' => $stateOwner->state_owner_zip
                    ];
                    $mapLink = $this->Address->getAddressLink($data);
                    $mapStr = sprintf('%s, %s, %s, %s', h($stateOwner->state_owner_address), h($stateOwner->state_owner_city), h($stateOwner->state->abbrev), h($stateOwner->state_owner_zip));
                    echo $this->Html->link($mapStr, $mapLink, ['target' => '_blank']);
                }
                ?>
            </p>
        </div>
        <?php
        echo $this->Html->link('<i class="material-icons">edit</i> ' . __('Edit {0} {1}\'s Information', h($stateOwner->state_owner_first_name), h($stateOwner->state_owner_last_name)), [
            'action' => 'edit',
            $stateOwner->state_owner_id
        ], ['class' => 'btn btn-primary', 'escape' => false])
        ?>
    </section>
</div>
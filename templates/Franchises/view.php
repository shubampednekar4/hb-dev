<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Franchise $franchise
 * @var \App\Model\Entity\StateOwner[]|\Cake\Datasource\ResultSetInterface $state_owners
 * @var \App\Model\Entity\State[]|\Cake\Datasource\ResultSetInterface $states
 * @var object $value
 */

use Cake\Collection\Collection;

$this->assign('title', __($franchise->franchise_name));
switch ($franchise->franchise_status) {
    case 'Active':
        $status = '<span class="badge badge-success">Open</span>';
        break;
    case 'Inactive':
        $status = '<span class="badge badge-danger">Closed</span>';
        break;
    case 'For Sale':
        $status = '<span class="badge badge-warning">For Sale</span>';
        break;
    default:
        $status = '<span class="badge badge-info">No Status Set</span>';
}
$this->Html->script([
    'execute/franchises/edit.js?v=1.0.0b',
    'execute/franchises/common.js?v=1.0.0b',
], ['block' => true]);
?>

<?= $this->Html->link(__('Go Back'), ['action' => 'manage'], [
    'escape' => false,
    'class' => 'btn btn-sm btn-info'
]) ?>
<div class="card">
    <header class="card-header card-header-primary">
        <h2 class="card-title"><span id="staticTitle"><?= $this->fetch('title') ?></span></h2>
        <p class="card-description"><?= __("Review franchise information and edit it if needed. You can also close or open a franchise. Caution: deleting a franchise is different than closing one. Deletion is permanent and cannot be undone. When in doubt, it is best to close the franchise rather than delete it.") ?></p>
        <?= $franchise->franchise_status !== 'Active' ?
            $this->Form->postLink(__('Open'), [
                'action' => 'open',
                $franchise->franchise_id,
            ], [
                'escapeTitle' => false,
                'class' => 'btn btn-sm btn-success',
                'confirm' => __('Are you sure you want to open the "{0}" franchise? It will accessible to outside searches. This can be undone.', $franchise->franchise_name),
            ]) :
            $this->Form->postLink(__('Close'), [
                'action' => 'close',
                $franchise->franchise_id,
            ], [
                'escapeTitle' => false,
                'class' => 'btn btn-sm btn-warning',
                'confirm' => __('Are you sure you want to close the "{0}" franchise? It will not longer be accessible to outside searches. This can be undone.', $franchise->franchise_name),
            ]) ?>
        <?= $this->Form->postlink(__('Delete'), ['action' => 'delete', $franchise->franchise_id], [
            'escapeTitle' => false,
            'class' => 'btn btn-sm btn-danger',
            'confirm' => __('Are you sure you want to delete the "{0}" franchise? This cannot be undone', $franchise->franchise_name),
        ]) ?>
    </header>
    <section class="card-body">
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title"><?= __('Franchise Information') ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="collapse multi-collapse show" id="franchise-info">
                            <div class="row">
                                <div class="col-12 my-2">
                                    <span class="lead">
                                        <span class="font-weight-bold"><?= __('Name') ?>:</span>
                                        <span id="staticFranchiseName"><?= $franchise->franchise_name ?></span>
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 my-2">
                                    <span class="lead">
                                        <span class="font-weight-bold"><?= __('Status') ?>:</span>
                                        <span id="staticFranchiseStatus"><?= $status ?></span>
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 my-2">
                                    <span class="lead">
                                        <span class="font-weight-bold"><?= __('State Owner') ?>:</span>
                                        <span id="staticFranchiseStateOwnerName">
                                            <?= $this->Html->link($franchise->state_owner->full_name, [
                                                'controller' => 'StateOwners',
                                                'action' => 'view',
                                                $franchise->state_owner_id
                                            ]) ?>
                                        </span>
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 my-2">
                                    <span class="lead">
                                        <span class="font-weight-bold"><?= __('Description') ?>:</span>
                                        <span id="staticFranchiseDescription"><?= $franchise->franchise_description ?></span>
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 my-2">
                                    <span class="lead">
                                        <span class="font-weight-bold"><?= __('Number Of Territories') ?>:</span>
                                        <span id="staticFranchiseTerritories"><?= $franchise->franchise_number_of_territories ?></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="collapse multi-collapse" id="franchise-form">
                            <?= $this->Form->create($franchise, ['id' => 'franchise-form-element']) ?>
                            <div class="form-row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <?= $this->Form->control('franchise_name', [
                                            'class' => 'form-control'
                                        ]) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12">
                                    <div class="form-group" id="franchise-parent">
                                        <?= $this->Form->control('franchise_status', [
                                            'class' => 'select2',
                                            'options' => [
                                                'Active' => 'Open',
                                                'Inactive' => 'Closed',
                                                'For Sale' => 'For Sale'
                                            ],
                                            'label' => 'Status',
                                            'data-parent' => 'franchise-parent'
                                        ]) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12">
                                    <div class="form-group" id="state-parent">
                                        <?= $this->Form->control('state_owner_id', [
                                            'class' => 'select2',
                                            'data-parent' => 'state-parent',
                                            'options' => $state_owners
                                        ]) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <?= $this->Form->control('franchise_description', ['class' => 'form-control']) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <?= $this->Form->control('franchise_number_of_territories', [
                                            'class' => 'form-control',
                                            'type' => 'number',
                                            'step' => 1.00,
                                        ]) ?>
                                    </div>
                                </div>
                            </div>
                            <?= $this->Form->end() ?>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button id="edit-franchise" class="btn btn-sm btn-primary edit-btn" type="button"
                                data-toggle="collapse" data-target=".multi-collapse" aria-expanded="false"
                                aria-controls="franchise-form franchise-info"
                                data-form-open="false"
                                data-form-type="franchise"><?= __('Edit') ?></button>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title"><?= __('Operator Information') ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="collapse show operator-toggle" id="operator-info">
                            <div class="row">
                                <div class="col-12 my-2">
                                <span class="lead">
                                    <span class="font-weight-bold"><?= __('Name:') ?></span>
                                    <span class="staticOp" id="staticOpName">
                                        <?= $this->Html->link($franchise->operator->full_name, [
                                            'controller' => 'Operators',
                                            'action' => 'view',
                                            $franchise->operator_id
                                        ]) ?>
                                    </span>
                                </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 my-2">
                                <span class="lead">
                                    <span class="font-weight-bold"><?= __('Email:') ?></span>
                                    <span class="staticOp" id="staticOpEmail">
                                        <?= $this->Text->autoLinkEmails($franchise->operator->operator_email) ?>
                                    </span>
                                </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 my-2">
                                <span class="lead">
                                    <span class="font-weight-bold"><?= __('Phone:') ?></span>
                                    <span class="staticOp" id="staticOpPhone">
                                        <?= $this->Html->link($franchise->operator->operator_phone, 'tel:' . $franchise->operator->operator_phone) ?>
                                    </span>
                                </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 my-2">
                                    <span class="lead">
                                        <span class="font-weight-bold"><?= __('Address:') ?></span>
                                        <br>
                                        <span class="staticOp" id="staticOpAddress">
                                            <?= $franchise->operator->operator_address ?><br>
                                            <?= $franchise->operator->operator_city ?>,
                                            <?= $franchise->operator->state->abbrev ?>
                                            <?= $franchise->operator->operator_zip ?>
                                        </span>
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 my-2">
                                    <span class="lead">
                                        <span class="font-weight-bold"><?= __('Username/Login:') ?></span>
                                        <span class="staticOp" id="staticOpUsername">
                                            <?= $this->Html->link($franchise->operator->user->user_username, [
                                                'controller' => 'Users',
                                                'action' => 'view',
                                                $franchise->operator->user_id
                                            ]) ?>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="collapse operator-toggle" id="operator-form">
                            <?= $this->Form->create($franchise->operator, ['id' => 'operator-form-element']) ?>
                            <div class="form-row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <?= $this->Form->control('operator_first_name', [
                                            'class' => 'form-control',
                                            'label' => 'First Name'
                                        ]) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <?= $this->Form->control('operator_last_name', [
                                            'class' => 'form-control',
                                            'label' => 'Last Name'
                                        ]) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <?= $this->Form->control('operator_email', [
                                            'class' => 'form-control',
                                            'label' => 'Email Address'
                                        ]) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <?= $this->Form->control('operator_phone', [
                                            'class' => 'form-control',
                                            'label' => 'phone'
                                        ]) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <?= $this->Form->control('operator_address', [
                                            'class' => 'form-control',
                                            'label' => 'Street Address'
                                        ]) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <?= $this->Form->control('operator_city', [
                                            'class' => 'form-control',
                                            'label' => 'City'
                                        ]) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12">
                                    <div class="form-group" id="operatorStateParent">
                                        <?= $this->Form->control('state_id', [
                                            'class' => 'select2',
                                            'label' => 'State',
                                            'data-parent' => 'operatorStateParent',
                                            'options' => $states,
                                        ]) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <?= $this->Form->control('operator_zip', [
                                            'class' => 'form-control',
                                            'label' => "Zip Code"
                                        ]) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <?= $this->Form->control('user.user_username', [
                                            'class' => 'form-control',
                                            'label' => 'Username/Login'
                                        ]) ?>
                                    </div>
                                </div>
                            </div>
                            <?= $this->Form->end(); ?>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button id="edit-operator" data-form-open="false" class="btn btn-sm btn-primary edit-btn"
                                type="button" data-toggle="collapse" data-target=".operator-toggle"
                                aria-expanded="false" aria-controls="operator-form"
                                data-form-type="operator"><?= __('Edit') ?></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card" id="location-card">
                    <div class="card-header card-header-info card-header-tabs">
                        <span class="nav-tabs-title">Locations</span>
                        <ul class="nav nav-tabs" data-tabs="tabs" id="locationTabs">
                            <?php foreach ($franchise->locations as $key => $location): ?>
                                <li class="nav-item location-tab" data-location-id="<?= $location->location_id ?>">
                                    <a href="#location<?= $location->location_id ?>"
                                       class="nav-link location-tab-btn<?= $key === 0 ? ' active' : null ?>"
                                       data-toggle="tab"
                                       data-key="<?= $location->location_id ?>"
                                       id="location<?= $location->location_id ?>-tab"><?= $location->location_name ?></a>
                                </li>
                            <?php endforeach; ?>
                            <button type="button" id="add-location-btn"
                                    class="ml-2 bg-white text-dark btn btn-round btn-sm btn-just-icon">
                                <i class="material-icons">add</i>
                            </button>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="location-panes">
                            <?php $first = 0; ?>
                            <?php foreach ($franchise->locations as $key => $location): ?>
                                <?php if ($key === 0) $first = $location->location_id; ?>
                                <div class="tab-pane<?= $key === 0 ? ' active' : null ?>"
                                     id="location<?= $location->location_id ?>">
                                    <div class="location-info location-toggle collapse show"
                                         id="location-info-<?= $location->location_id ?>">
                                        <div class="row">
                                            <div class="col-12 lead my-2">
                                                <span class="font-weight-bold">Location Name: </span>
                                                <span id="staticLocationName-<?= $location->location_id ?>">
                                                    <?= $location->location_name ?>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 lead my-2">
                                                <span class="font-weight-bold">Address: </span><br/>
                                                <span id="staticLocationAddress-<?= $location->location_id ?>">
                                                    <?= $location->location_address ?><br/>
                                                    <?= $location->main_city->city_name ?>,
                                                    <?= $location->state->abbrev ?>
                                                    <?= $location->main_zip->zip_code ?>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 lead my-2">
                                                <span class="font-weight-bold">Cities: </span>
                                                <span id="staticLocationCities-<?= $location->location_id ?>">
                                                    <?php
                                                    $cities = [];
                                                    foreach ($location->assoc_cities as $assoc_city) {
                                                        $cities[] = $assoc_city->city_name;
                                                    }
                                                    ?>
                                                    <?= join(', ', $cities) ?>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 lead my-2">
                                                <span class="font-weight-bold">Zip Codes: </span>
                                                <span id="staticLocationZips-<?= $location->location_id ?>">
                                                    <?php
                                                    $zips = [];
                                                    foreach ($location->assoc_zips as $assoc_zips) {
                                                        $zips[] = $assoc_zips->zip_code;
                                                    }
                                                    ?>
                                                    <?= join(', ', $zips) ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="location-form location-toggle collapse"
                                         id="location-form-<?= $location->location_id ?>">
                                        <?= $this->Form->create($location) ?>
                                        <?= $this->Form->hidden('location_id') ?>
                                        <div class="form-row">
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <?= $this->Form->control('location_name', ['class' => 'form-control']) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <?= $this->Form->control('location_address', ['class' => 'form-control']) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <?= $this->Form->control('main_city.city_name', [
                                                        'class' => 'form-control',
                                                        'label' => 'city'
                                                    ]) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group"
                                                     id="location<?= $location->location_id ?>StateParent">
                                                    <?= $this->Form->control('state_id', [
                                                        'class' => 'location-select2',
                                                        'data-parent' => 'location' . $location->location_id . 'StateParent',
                                                        'id' => 'location-' . $location->location_id . '-state_id'
                                                    ]) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <?= $this->Form->control('main_zip.zip_code', [
                                                        'class' => 'form-control'
                                                    ]) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group"
                                                     id="<?= 'location-' . $location->location_id . '-cities-city-namesParent' ?>">
                                                    <?php
                                                    $city_collection = new Collection($location->assoc_cities);
                                                    $city_options = $city_collection->map(function ($value, $key) {
                                                        return [
                                                            'value' => $value->city_name,
                                                            'text' => $value->city_name,
                                                            'selected' => true,
                                                        ];
                                                    });
                                                    ?>
                                                    <?= $this->Form->control('cities.city_name', [
                                                        'class' => 'location-select2',
                                                        'multiple' => true,
                                                        'id' => 'location-' . $location->location_id . '-cities-city-names',
                                                        'data-parent' => 'location-' . $location->location_id . '-cities-city-namesParent',
                                                        'options' => $city_options,
                                                    ]) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group"
                                                     id="<?= 'location-' . $location->location_id . '-zips-zip-codesParent' ?>">
                                                    <?php
                                                    $zip_collection = new Collection($location->assoc_zips);
                                                    $zip_options = $zip_collection->map(function ($value, $key) {
                                                        return [
                                                            'value' => $value->zip_code,
                                                            'text' => $value->zip_code,
                                                            'selected' => true,
                                                        ];
                                                    });
                                                    ?>
                                                    <?= $this->Form->control('zips.zip_code', [
                                                        'class' => 'location-select2',
                                                        'multiple' => true,
                                                        'id' => 'location-' . $location->location_id . '-zips-zip-codes',
                                                        'data-parent' => 'location-' . $location->location_id . '-zips-zip-codesParent',
                                                        'options' => $zip_options,
                                                    ]) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?= $this->Form->end() ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="button-container">
                            <button type="button" id="variable-edit-btn"
                                    class="btn btn-sm btn-primary variable-edit-btn" data-current-tab="<?= $first ?>">
                                Edit
                            </button>
                            <?php if (count($franchise->locations) <= 1): ?>
                                <button class="btn btn-sm btn-danger delete-btn" id="location-delete-btn" disabled>
                                    Cannot Remove Only Location
                                </button>
                            <?php else: ?>
                                <button class="btn btn-sm btn-danger delete-btn" id="location-delete-btn">Remove
                                    Location
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
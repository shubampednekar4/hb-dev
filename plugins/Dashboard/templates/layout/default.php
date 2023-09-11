<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 * @var mixed $controller
 * @var array $notifications
 * @var \App\Model\Entity\User $currentUser
 */

use Cake\I18n\FrozenDate;

$siteName = "Heaven's Best";
?>
<!DOCTYPE html>
<html lang="en-us">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $siteName ?> &raquo;
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <link rel="stylesheet" type="text/css"
          href="https://fonts.googleapis.com/css?family=Roboto:30,0400,500,700|Roboto+Slab:400,700|Material+Icons"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">


    <?= $this->Html->css('https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css') ?>
    <?= $this->Html->css([
        'https://cdn.jsdelivr.net/chartist.js/latest/chartist.min.css',
        'scss/material-dashboard.css?v2.1.4',
        'https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css',
        'custom-style.css?v1.0.3c'
    ], ['once' => true]) ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
    <?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js') ?>
    <? $this->Html->script('https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js', [
    'once' => true,
    'block' => true,
]); ?>
    <?= $this->Html->scriptBlock(sprintf('let csrfToken = %s;', json_encode($this->request->getAttribute('csrfToken')))) ?>
</head>
<body>
<div class="wrapper">
    <div class="sidebar" data-color="danger" data-background-color="black" >
        <div class="logo text-center">
            <?= $this->Html->link($this->Html->image('navigation/small-logo.png', [
                'alt' => "Heaven's Best Carpet Cleaning",
                'class' => 'img-fluid',
            ]), '/', [
                'class' => 'logo-normal',
                'escapeTitle' => false
            ]) ?>
        </div>
        <div  class="sidebar-wrapper" style="height: 80% !important;">
            <ul class="nav">
                <li class="nav-item<?= $controller === 'Pages' ? ' active' : null ?>">
                    <?= $this->Html->link('<i class="material-icons">home</i> <p>Home</p>', '/', [
                        'class' => 'nav-link',
                        'escape' => false
                    ]) ?>
                </li>
                <?php if ($this->Identity->isLoggedIn()): ?>
                    <li class="nav-item <?= $controller === 'Users' ? ' active' : null ?>">
                        <?php if ($currentUser->is_admin): ?>
                            <?= $this->Html->link('<i class="material-icons">person</i> <p>Users</p>', [
                                'controller' => 'Users',
                                'action' => 'index',
                            ], [
                                'class' => 'nav-link',
                                'escape' => false,
                            ]) ?>
                        <?php endif; ?>
                    </li>
                    <?php if ($currentUser->has_manage_access): ?>
                        <li class="nav-item<?= $controller === 'Operators' ? ' active' : null ?>">
                            <?= $this->Html->link('<i class="material-icons">home_repair_service</i> <p>Operators</p>', [
                                'controller' => 'Operators',
                                'action' => 'index'
                            ], [
                                'class' => 'nav-link',
                                'escape' => false,
                            ]) ?>
                        </li>
                    <?php endif; ?>
                    <?php if ($currentUser->is_admin): ?>
                        <li class="nav-item dropdown<?= in_array($controller, ['StateOwners', 'Franchises', 'AdminHbads', 'TrainingVideos', 'Newsletters']) ? ' active' : '' ?>">
                            <a class="nav-link" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="material-icons">arrow_drop_down</i> <p>Admin</p> 
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="adminDropdown" style="background:#3C4858;">
                                <li class="nav-item<?= $controller === 'StateOwners' ? ' active' : '' ?>">
                                    <?= $this->Html->link('<i class="material-icons">corporate_fare</i> <p>State Owners</p>', [
                                        'controller' => 'StateOwners',
                                        'action' => 'index'
                                    ], [
                                        'class' => 'nav-link',
                                        'escape' => false,
                                    ]) ?>
                                </li>
                                <li class="nav-item<?= $controller === 'Franchises' ? ' active' : '' ?>">
                                    <?= $this->Html->link('<i class="material-icons">storefront</i> <p>Franchises</p>', [
                                        'controller' => 'Franchises',
                                        'action' => 'index'
                                    ], [
                                        'class' => 'nav-link',
                                        'escape' => false,
                                    ]) ?>
                                </li>
                                <li class="nav-item<?= $controller === 'AdminHbads' ? ' active' : '' ?>">
                                    <?= $this->Html->link('<i class="material-icons">campaign</i> <p>Add HB Ads</p>', [
                                        'controller' => 'AdminHbads',
                                        'action' => 'index'
                                    ], [
                                        'class' => 'nav-link',
                                        'escape' => false,
                                    ]) ?>
                                </li>
                                <li class="nav-item<?= $controller === 'TrainingVideos' ? ' active' : '' ?>">
                                    <?= $this->Html->link('<i class="material-icons">videocam</i> <p>Add Videos</p>', [
                                        'controller' => 'TrainingVideos',
                                        'action' => 'index',
                                    ], [
                                        'escape' => false,
                                        'class' => 'nav-link'
                                    ]) ?>
                                </li>
                                <li class="nav-item<?= $controller === 'Newsletters' ? ' active' : '' ?>">
                                    <?= $this->Html->link('<i class="material-icons">article</i> <p>Add Newsletters</p>', [
                                        'controller' => 'Newsletters',
                                        'action' => 'index',
                                    ], [
                                        'escape' => false,
                                        'class' => 'nav-link'
                                    ]) ?>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item<?= $controller === 'HbAds' ? ' active' : null ?>">
                        <?= $this->Html->link('<i class="material-icons">campaign</i> <p>HB Ads</p>', [
                            'controller' => 'Hbads',
                            'action' => 'index',
                        ], [
                            'escape' => false,
                            'class' => 'nav-link'
                        ]) ?>
                    </li>
                    <li class="nav-item<?= $controller === 'Videos' ? ' active' : null ?>">
                        <?= $this->Html->link('<i class="material-icons">videocam</i> <p>Training Videos</p>', [
                            'controller' => 'Videos',
                            'action' => 'main',
                        ], [
                            'escape' => false,
                            'class' => 'nav-link'
                        ]) ?>
                    </li>
                    <li class="nav-item<?= $controller === 'News' ? ' active' : null ?>">
                        <?= $this->Html->link('<i class="material-icons">article</i> <p>Newsletters</p>', [
                            'controller' => 'News',
                            'action' => 'main',
                        ], [
                            'escape' => false,
                            'class' => 'nav-link'
                        ]) ?>
                    </li>
                    <li class="nav-item<?= $controller === 'Vendors' ? ' active' : null ?>">
                        <?= $this->Html->link('<i class="material-icons">group</i> <p>Our Vendors</p>', [
                            'controller' => 'Vendors',
                            'action' => 'index',
                        ], [
                            'escape' => false,
                            'class' => 'nav-link'
                        ]) ?>
                    </li>
                 
                    <li class="nav-item<?= $controller === 'MonthlyReports' ? ' active' : null ?>">
                        <?= $this->Html->link('<i class="material-icons">assessment</i> <p>Reports</p>', [
                            'controller' => 'MonthlyReports',
                            'action' => 'mainMenu',
                        ], [
                            'escape' => false,
                            'class' => 'nav-link'
                        ]) ?>
                    </li>
                    <li class="nav-item">
                        <a href="https://corp.heavensbest.com/shop" class="nav-link"><i class="material-icons">storefront</i> <p>Store 	Login</p></a>
                    </li>
                <?php endif; ?>
        </div>
    </div>
    <div class="main-panel">
        <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top">
            <div class="container-fluid">
                <div class="navbar-wrapper">
                    <a class="navbar-brand" href="javascript:"><?= __($this->fetch('title')) ?></a>
                </div>
                <?php
                $notificationCount = 0;
                foreach ($notifications as $notification) {
                    if ($notification['is_new']) {
                        $notificationCount++;
                    }
                }
                ?>
                <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="navbar-toggler-icon icon-bar"></span>
                    <span class="navbar-toggler-icon icon-bar"></span>
                    <span class="navbar-toggler-icon icon-bar"></span>
                    <?= $notificationCount ? "<span class='notification sidebar-notification'>$notificationCount</span>" : "<span class='notification sidebar-notification d-none'>$notificationCount</span>" ?>
                </button>
                <div class="collapse navbar-collapse justify-content-end">
                    <form action="" class="navbar-form"></form>
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <?= $this->Html->link("<i class='material-icons'>notifications</i>" .
                                (($notificationCount) ? ("<span class='notification bell-notification'>$notificationCount</span>") : ("<span class='notification d-none bell-notification'></span>")) .
                                "<span class='d-lg-inline d-none'>Notifications</span> <p class='d-lg-none d-md-block'>Notifications</p>", 'javascript:;', [
                                'escapeTitle' => false,
                                'class' => 'nav-link',
                                'id' => 'navbarDropdownNotifications',
                                'data-toggle' => 'dropdown',
                                'aria-haspopup' => 'true',
                                'aria-expanded' => 'false',
                            ]) ?>
                            <div class="dropdown-menu dropdown-menu-right"
                                 aria-labelledby="navbarDropdownNotifications" id="notification-list">
                                <?php if (sizeof($notifications) !== 0): ?>
                                    <?php
                                    foreach ($notifications as $notification): ?>
                                        <?php
                                        $class = "dropdown-item notification-item";
                                        if ($notification["is_new"]) {
                                            $class .= " bg-info text-light";
                                        }
                                        ?>
                                        <?= $this->Html->link($notification['title'], $notification['link'], ['class' => $class]) ?>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="mt-2">
                                        <div class="col-12 text-center">
                                            <p class="h2 text-info"><i class="material-icons">notification_important</i>
                                            </p class=text-info">
                                            <p class="text-info">No Notifications</p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <?= $this->Html->link('<i class="material-icons">person</i><span class="d-lg-inline d-none">User</span><p class="d-lg-none d-md-block">User</p>', 'javascript:;', [
                                'escapeTitle' => false,
                                'class' => 'nav-link',
                                'id' => 'profileDropDown',
                                'data-toggle' => 'dropdown',
                                'aria-haspopup' => 'true',
                                'aria-expanded' => 'false',
                            ]) ?>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDropDown">
                                <?= $this->Html->link('Profile', ['controller' => 'Users', 'action' => 'view', $currentUser->user_id], ['class' => 'dropdown-item' . (($controller === 'Users' && $action = 'view') ? ' active' : null)]) ?>
                                <?= $this->Html->link('Settings', 'javascript:;', ['class' => 'dropdown-item']) ?>
                                <div class="dropdown-divider"></div>
                                <?= $this->Html->link('Log out', [
                                    'controller' => 'Users',
                                    'action' => 'logout',
                                ], [
                                    'escapeTitle' => false,
                                    'confirm' => 'Are you sure you want to sign out?',
                                    'class' => 'dropdown-item',
                                ]) ?>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="content">
            <noscript>
                <div class="alert alert-danger" role="alert">
                    <h3 class="alert-heading">Your Browser is Disabling Javascript.</h3>
                    <p>Many aspects of this website do not work without Javascript. These include back navigation
                        buttons, charts, and many other elements. Please turn it back on in order to view your monthly
                        stats correctly.</p>
                </div>
            </noscript>
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
        <footer class="footer">
            <div class="container-fluid">
                <div class="copyright">
                    <?php $date = new FrozenDate() ?>
                    <?= __("&copy {0} Heaven's Best Carpet Cleaning", $date->format('Y ')) ?>
                </div>
            </div>
        </footer>
    </div>
</div>
<?= $this->Html->script([
    'core/jquery.min',
    'https://cdn.jsdelivr.net/npm/sweetalert2@10',
    'core/popper.min',
    'https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js',
    'execute/select2.config.min',
    'execute/inputMask.plugin.config',
    'core/bootstrap-material-design.min',
    'plugins/perfect-scrollbar.jquery.min',
    'plugins/moment.min',
    'plugins/jquery.validate.min',
    'plugins/jquery.bootstrap-wizard',
    'plugins/bootstrap-selectpicker',
    'plugins/bootstrap-datetimepicker.min',
    'plugins/jquery.dataTables.min',
    'plugins/bootstrap-tagsinput',
    'plugins/jasny-bootstrap.min',
    'plugins/fullcalendar.min',
    'plugins/nouislider.min',
    'https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js',
    'plugins/arrive.min.js',
    'https://buttons.github.io/buttons.js',
    'plugins/chartist.min.js',
    'plugins/chartist-plugin-tooltip',
    'plugins/bootstrap-notify.js',
    'material-dashboard.min.js?v=2.1.2',
    'ion_sound/ion.sound.js',
    'site/notification.js?v=1.0.2a',
]) ?>
<?= $this->Html->script("https://code.jquery.com/ui/1.12.0/jquery-ui.min.js", [
    'integrity' => 'sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=',
    'crossorigin' => 'anonymous'
]) ?>
<?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js', [
    'integrity' => 'sha512-0XDfGxFliYJPFrideYOoxdgNIvrwGTLnmK20xZbCAvPfLGQMzHUsaqZK8ZoH+luXGRxTrS46+Aq400nCnAT0/w==',
    'crossorigin' => "anonymous"
]) ?>
<?= $this->fetch('script') ?>
</body>
</html>

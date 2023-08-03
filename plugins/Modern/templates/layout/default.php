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
 * @var AppView $this
 * @var mixed $controller
 */

use App\View\AppView;

$siteName = 'Heaven\'s Best';
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

    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700|Material+Icons" rel="stylesheet">

    <?= $this->Html->css('https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css') ?>
    <?= $this->Html->css([
        'jquery-ui.min',
        'https://cdn.jsdelivr.net/chartist.js/latest/chartist.min.css',
        'styles.css?v1.6.7',
    ], ['once' => true]) ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->Html->script('https://kit.fontawesome.com/005ae3c71c.js', ['crossorigin' => 'anonymous']) ?>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-sticky bg-primary navbar-light">
    <div class="container">
        <div class="navbar-wrapper">
            <h1 class="sr-only">Heaven's Best Carpet Cleaning</h1>
            <a class="navbar-brand"
               href="<?= $this->Url->build('/') ?>"><?= $this->Html->image('site/logo.png', ['class' => 'logo']); ?></a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#topNav" aria-controls="topNav"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="topNav">
            <ul class="navbar-nav nav">
                <li class="nav-item<?= $controller === 'Pages' ? ' active' : null ?>">
                    <?= $this->Html->link('<i class="fas fa-home"></i> Home', '/', [
                        'class' => 'nav-link',
                        'escape' => false
                    ]) ?>
                </li>
                <?php if ($this->Identity->isLoggedIn()): ?>
                    <li class="nav-item dropdown<?= $controller === 'Users' || $controller === 'Operators' || $controller === 'StateOwners' ? ' active' : null ?>">
                        <?= $this->Html->link('<i class="fas fa-users"></i> People', '#', [
                            'class' => 'nav-link dropdown-toggle',
                            'escape' => false,
                            'role' => 'button',
                            'aria-haspopup' => true,
                            'aria-expanded' => false,
                            'data-toggle' => 'dropdown'
                        ]) ?>
                        <div class="dropdown-menu">
                            <?= $this->Html->link('<i class="fas fa-user mr-2"></i> Users', [
                                'controller' => 'Users',
                                'action' => 'index',
                            ], [
                                'class' => 'dropdown-item',
                                'escape' => false,
                            ]) ?>
                            <?= $this->Html->link('<i class="fas fa-hard-hat mr-2"></i>Operators', [
                                'controller' => 'Operators',
                                'action' => 'index'
                            ], [
                                'class' => 'dropdown-item',
                                'escape' => false,
                            ]) ?>
                            <?= $this->Html->link('<i class="fas fa-user-tie mr-2"></i>State Owners', [
                                'controller' => 'StateOwners',
                                'action' => 'index'
                            ], [
                                'class' => 'dropdown-item',
                                'escape' => false,
                            ]) ?>
                        </div>
                    </li>
                    <li class="nav-item<?= $controller === 'MonthlyReports' ? ' active' : null ?>">
                        <?= $this->Html->link('<i class="far fa-clipboard"></i> Reports', [
                            'controller' => 'MonthlyReports',
                            'action' => 'mainMenu',
                        ], [
                            'escape' => false,
                            'class' => 'nav-link'
                        ]) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link('<i class="fas fa-power-off"></i> Logout', [
                            'controller' => 'Users',
                            'action' => 'logout'
                        ], [
                            'class' => 'nav-link btn btn-danger',
                            'escape' => false,
                            'confirm' => 'Are you sure you want to log out?'
                        ]) ?>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <?= $this->Html->link('<i class="fas fa-sign-in-alt"></i> Log in', [
                            'controller' => 'Users',
                            'action' => 'login'
                        ], [
                            'class' => 'nav-link btn text-warning btn-outline-warning',
                            'escape' => false,
                        ]) ?>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<main class="main">
    <div class="container">
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
    </div>
</main>
<?= $this->Html->script('https://code.jquery.com/jquery-3.5.1.min.js', [
    'integrity' => 'sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=',
    'crossorigin' => 'annonymous'
]) ?>
<?= $this->Html->script([
    'core/jquery.min',
    'https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js',
    'execute/select2.config.min.js?v=1.0.0',
    'core/popper.min',
    'core/bootstrap-material-design.min',
    'plugins/moment.min',
    'plugins/nouislider.min',
    'plugins/jquery.maskMoney.min',
    "https://cdn.jsdelivr.net/chartist.js/latest/chartist.min.js",
    'material-kit.js?v=2.0.7',
]) ?>
<?= $this->Html->script("https://code.jquery.com/ui/1.12.0/jquery-ui.min.js", [
        'integrity' => 'sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=',
        'crossorigin' => 'anonymous'
    ]) ?>
<?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js', [
    'integrity' => 'sha512-0XDfGxFliYJPFrideYOoxdgNIvrwGTLnmK20xZbCAvPfLGQMzHUsaqZK8ZoH+luXGRxTrS46+Aq400nCnAT0/w==',
    'crossorigin' => "anonymous"
]) ?>
<?= $this->Html->script('execute/inputMask.plugin.config.js?v1.0.6') ?>
<?= $this->fetch('script') ?>
</body>
</html>

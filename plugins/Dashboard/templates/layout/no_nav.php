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
 * @var array $notifications
 * @var User $currentUser
 */

use App\Model\Entity\User;
use App\View\AppView;
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
          href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons"/>

    <?= $this->Html->css('https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css') ?>
    <?= $this->Html->css([
        'https://cdn.jsdelivr.net/chartist.js/latest/chartist.min.css',
        'scss/material-dashboard.css?v2.1.4',
        'https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css',
        'custom-style.css?v1.0.2'
    ], ['once' => true]) ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>

</head>
<body>
<div class="container-fluid">
        <noscript>
            <div class="alert alert-danger" role="alert">
                <h3 class="alert-heading">Your Browser is Disabling Javascript.</h3>
                <p>Many aspects of this website do not work without Javascript. These include back navigation
                    buttons, charts, and many other elements. Please turn it back on in order to view your monthly
                    stats correctly.</p>
            </div>
        </noscript>
        <div class="row pt-5">
            <div class="col-4"></div>
            <div class="col-lg-4 col-md-12">
                <?= $this->Flash->render() ?>
                <?= $this->fetch('content') ?>
            </div>
            <div class="col-4"></div>
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
<?= $this->Html->script([
    'core/jquery.min',
    'core/popper.min',
    'https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js',
    'execute/select2.config.min',
    'execute/inputMask.plugin.config',
    'core/bootstrap-material-design.min',
    'plugins/perfect-scrollbar.jquery.min',
    'plugins/moment.min',
    'plugins/sweetalert2',
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

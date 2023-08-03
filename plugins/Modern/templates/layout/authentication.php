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
 */

use App\View\AppView;

$siteName = 'Heaven\'s Best Carpet Cleaning';
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

    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">

    <?= $this->Html->css(['styles']) ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
<nav class="top-nav">
    <div class="container-fluid header-container">
        <div class="top-nav-title">
            <h1 class="hidden-logo">Heaven's Best Carpet Cleaning</h1>
            <a href="<?= $this->Url->build('/') ?>"><?= $this->Html->image('site/logo.png', ['class' => 'logo']); ?></a>
        </div>
        <div class="top-nav-links">
            <a href=<?= $this->Url->build(['controller' => 'users', 'action' => 'login']) ?>>Login</a>
        </div>
    </div>
</nav>
<main class="main">
    <div class="container">
        <?= $this->fetch('content') ?>
    </div>
</main>
<footer>
</footer>
<?= $this->Html->script('https://code.jquery.com/jquery-3.5.1.slim.min.js', [
    'integrity' => 'sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj',
    'crossorigin' => 'anonymous'
]) ?>
<?= $this->Html->script('https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js', [
    'integrity' => 'sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN',
    'crossorigin' => 'anonymous',
]) ?>
<?= $this->Html->script('https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', [
    'integrity' => 'sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV',
    'crossorigin' => 'anonymous',
]) ?>
<?= $this->Html->script('material-dashboard.min') ?>
</body>
</html>

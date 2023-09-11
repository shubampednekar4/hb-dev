<?php
/**
 * @var AppView $this
 */

use App\View\AppView;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
    <title><?= $this->fetch('title') ?></title>
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">
</head>
<body>

<main class="main">
    <div class="container">
        <h1>Heaven's Best Carpet Cleaning</h1>
        <?= $this->fetch('content') ?>
    </div>
</main>
</body>
</html>

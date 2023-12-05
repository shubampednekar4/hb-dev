
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Operator[]|\Cake\Collection\CollectionInterface $operators
 * @var bool $resetNeeded
 * @var string|null $search
 * @var User $currentUser
 */

use App\Model\Entity\User;

$this->assign('title', __("Heavens Best Vendors"));
?>
<div class="card">
    <header class="card-header card-header-danger">
        <h2 class="card-title"><i class="material-icons">home_repair_service</i> <?= $this->fetch('title') ?></h2>
        <p class="card-category"><?= __("HeavensBest Vendors") ?></p>
    </header>
    <p> <?= $vendors ?></p>
</div>


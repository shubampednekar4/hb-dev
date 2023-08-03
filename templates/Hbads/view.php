<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var User $currentUser
 */

use App\Model\Entity\User;
use App\Model\Entity\Hbads;
use App\View\AppView;

$this->assign('title', __('Advertisment Details'));
?>


<div class="card">
    <header class="card-header card-header-primary">
        <h2 class="card-title"><i class="material-icons">person</i> <?= __($this->fetch('title')) ?></h2>
        <p class="card-category"><?= __('For {0} ', $hbad->title) ?></p>
    </header>
    <section class="card-body">
            <p class="card-text"><i class="material-icons">description</i> <?= h($hbad->description) ?></p>
            <p class="card-text"><i class="material-icons">image</i> 
            <?= 
                        $this->Html->image($hbad->image_location,
                         ['width' => '100', 'height' => '100','pathPrefix' => '/webroot/img/uploads/', 'alt' => $hbad->title]);
                     ?>
        </p>
            <p class="card-text"><i class="material-icons">picture_as_pdf</i> 
            <?= $this->Html->link('Download PDF', '/webroot/pdf/uploads/' . $hbad->pdf_location, ['target' => '_blank']) ?>

        </p>
    </section>
</div>
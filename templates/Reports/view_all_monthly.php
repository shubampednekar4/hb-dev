<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Report[]|\Cake\Collection\CollectionInterface $reports
 */

use App\Model\Entity\Report;
use App\View\AppView;

?>
<?= $this->Html->link('<i class="fas fa-backward"></i> Go Back', ['action' => 'index'], [
    'escape' => false,
    'class' => 'btn btn-sm btn-default'
]) ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header card-header-primary">
                <h2 class="card-title"><?= __("Monthly Reports") ?></h2>
            </div>
            <div class="card-body">
                <?= $this->Html->link(__('New Monthly Report <i class="fas fa-plus-circle"></i>'), ['action' => 'addMonthly'], [
                    'class' => 'btn btn-info float-right',
                    'escape' => false
                ]) ?>
                <table class="table table-striped table-responsive-md">
                    <thead>
                    <tr>
                        <th><?= $this->Paginator->sort('franchise_id') ?></th>
                        <th><?= __('Revenue') ?></th>
                        <th><?= $this->Paginator->sort('advertising_cost') ?></th>
                        <th><?= $this->Paginator->sort('month') ?></th>
                        <th><?= __('Actions') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($reports as $report): ?>
                        <tr>
                            <td><?= $report->franchise->franchise_name ?></td>
                            <td><?= $this->Number->currency($report->revenue, 'USD') ?></td>
                            <td><?= $this->Number->currency($report->advertising_cost, 'USD') ?></td>
                            <td><?= $report->month->format('F Y') ?></td>
                            <td>
                                <?= $this->Html->link('<i class="fas fa-eye"></i> ' . '<span class="sr-only">' . __('View') . '</span>', [
                                    'action' => 'viewMonthly',
                                    $report->id
                                ], [
                                    'escape' => false,
                                    'class' => 'btn btn-sm btn-primary'
                                ]) ?>
                                <?= $this->Html->link('<i class="fas fa-edit"></i> ' . '<span class="sr-only">' . __('Edit') . '</span>', [
                                    'action' => 'editMonthly',
                                    $report->id
                                ], [
                                    'escape' => false,
                                    'class' => 'btn btn-sm btn-success'
                                ]) ?>
                                <?= $this->Form->postLink('<i class="fas fa-trash"></i> ' . '<span class="sr-only">' . __('Delete') . '</span>', [
                                    'action' => 'deleteMonthly',
                                    $report->id
                                ], [
                                    'confirm' => __('Are you sure you want to delete this monthly report?'),
                                    'escape' => false,
                                    'class' => 'btn btn-sm btn-danger'
                                ]) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="paginator">
                    <ul class="pagination">
                        <?= $this->Paginator->first(__('First'), ['escape' => false]) ?>
                        <?= $this->Paginator->numbers(['modulus' => 2]) ?>
                        <?= $this->Paginator->last(__('Last'), ['escape' => false]) ?>
                    </ul>
                    <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} report(s) out of {{count}} total')) ?></p>
                </div>
            </div>
        </div>
    </div>
</div>


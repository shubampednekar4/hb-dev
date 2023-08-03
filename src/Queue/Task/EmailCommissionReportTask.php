<?php

namespace App\Queue\Task;

use App\Mailer\CommissionReportMailer;
use Queue\Queue\Task;

class EmailCommissionReportTask extends Task
{

    /**
     * @param array $data The array passed to QueuedJobsTable::createJob()
     * @param int $jobId The id of the QueuedJob entity
     * @return void
     */
    public function run(array $data, int $jobId): void
    {
        $mailer = new CommissionReportMailer($data);
        $mailer->deliver();
    }

}

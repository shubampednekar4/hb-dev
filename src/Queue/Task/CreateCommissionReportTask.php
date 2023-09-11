<?php
declare(strict_types=1);

namespace App\Queue\Task;

use App\Mailer\CommissionReportMailer;
use App\Model\Entity\PdfGroup;
use Cake\Collection\Collection;
use Cake\Core\Configure;
use Cake\Http\Exception\NotAcceptableException;
use Cake\I18n\FrozenTime;
use Cake\Log\Log;
use Cake\ORM\TableRegistry;
use Cake\Routing\Route\Route;
use Cake\Routing\Router;
use Cake\Utility\Security;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use Mpdf\HTMLParserMode;
use Mpdf\Mpdf;
use Mpdf\MpdfException;
use Queue\Model\QueueException;
use Queue\Queue\Task;

/**
 * Create PDF Task
 */
class CreateCommissionReportTask extends Task
{
    /**
     * Default locale.
     *
     * @var string
     */
    public const LOCALE = 'en_US';

    /**
     * @param array $data The array passed to QueuedJobsTable::createJob()
     * @param int $jobId The id of the QueuedJob entity
     * @return void
     */
    public function run(array $data, int $jobId): void
    {
        $mpdf = $this->createPdf($data);
        $path = join(DS, [ROOT, 'tmp', 'reports', 'commissions']);
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
        $filename = Security::randomString(8) . '.pdf';
        $full_path = $path . DS . $filename;
        try {
            $mpdf->Output($full_path);
        } catch (MpdfException $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            throw new QueueException('Could not save PDF file.');
        }

        $pdfs_table = TableRegistry::getTableLocator()->get('Pdfs');
        $pdf = $pdfs_table->get($data['pdf_id']);
        $pdf = $pdfs_table->patchEntity($pdf, ['is_done' => true]);
        $pdfs_table->saveOrFail($pdf);
        $this->QueuedJobs->createJob('EmailCommissionReport', [
            'filename' => $filename,
            'user_id' => $pdf->user_id,
        ]);
        $notifications_table = TableRegistry::getTableLocator()->get('Notifications');
        $hash = Security::randomString(16);
        $attributes = [
            'hash' => $hash
        ];
        $time = new FrozenTime();
        $notification = $notifications_table->newEntity([
            'user_id' => $pdf->user_id,
            'title' => 'Commission Report Finished on ' . $time->format('j F Y') . ' at ' . $time->format("h:i a"),
            'link' => Router::url([
                'controller' => 'notifications',
                'action' => 'commissionReport',
                '?' => [
                    'filename' => $filename,
                    'hash' => $hash
                ]
            ]),
            'attributes' => json_encode($attributes),
        ]);
        $notifications_table->saveOrFail($notification);
    }

    /**
     * PDF generator and Saver.
     *
     * @param array $data Data from task, pass directly.
     * @return \Mpdf\Mpdf Object for debugging and testing.
     */
    public function createPdf(array $data): Mpdf
    {
        $pdf_groups = TableRegistry::getTableLocator()->get('PdfGroups')->find()->where(['pdf_id' => $data['pdf_id']]);

        $html = [];
        $html[] = $this->createHeader($data);
        $html[] = "<div class='body'>";
        foreach ($pdf_groups as $pdf_group) {
            $html[] = $this->createStateOwnerGroup($pdf_group);
        }
        $html[] = "</div>";

        $html = join(PHP_EOL, $html);
        $stylesheet = file_get_contents(join(DS, [
            ROOT,
            'plugins',
            'Dashboard',
            'webroot',
            'css',
            'pdf-styles.css'
        ]));

        try {
            $defaultConfig = (new ConfigVariables())->getDefaults();
            $fontDirs = $defaultConfig['fontDir'];
            $defaultFontConfig = (new FontVariables())->getDefaults();
            $fontData = $defaultFontConfig['fontdata'];

            $mpdf = new Mpdf([
                'fontDir' => array_merge($fontDirs, [
                    ROOT . '/plugins/Dashboard/webroot/fonts/Roboto',
                ]),
                'fontData' => $fontData + [
                    'Roboto' => [
                        'R' => 'Roboto-Regular.ttf',
                        'B' => 'Roboto-Bold.tff',
                        'L' => 'Roboto-Light.tff',
                        'T' => 'Roboto-Thin',
                    ]
                ],
                'default_font' => 'Roboto',
            ]);

            $mpdf->WriteHTML($stylesheet, HTMLParserMode::HEADER_CSS);
            $mpdf->WriteHTML($html, HTMLParserMode::HTML_BODY);
            return $mpdf;
        } catch (MpdfException $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            throw new QueueException('Could not run the task.');
        }
    }

    /**
     * Create the header for the PDF
     *
     * Includes Logo, title, and date range for which when the report was generated.
     *
     * @param array $data Data passed to the task.
     * Best to simply pass the array.
     * @return string An HTML string of the header to be included in the PDF
     */
    public function createHeader(array $data): string
    {
        $imagePath = Configure::read('Commissions.logo.path');
        $title = __("Commission Report");
        $pdf = TableRegistry::getTableLocator()->get('Pdfs')->get($data['pdf_id']);
        $date = sprintf('%s - %s', $pdf->startDate->format('j F Y'), $pdf->endDate->format('j F Y'));

        $html = "<header class='header'>";
        $html .= "<table class='container'>";
        $html .= "<tr>";
        $html .= "<td class='logo-container'>";
        $html .= "<img class='logo' src='$imagePath' alt='Heavens Best Logo'>";
        $html .= "</td>";
        $html .= "<td>";
        $html .= "<p class='header-title'>$title</p>";
        $html .= "<p class='header-date'>$date</p>";
        $html .= "</td>";
        $html .= "</tr>";
        $html .= "</table>";
        $html .= "</header>";
        return $html;
    }

    /**
     * State Owner Group Html String Generator
     *
     * Create a html string that contains:
     *  1. Title (State Owner name and Commission Amount)
     *  2. Orders Table
     *
     * @param \App\Model\Entity\PdfGroup $pdf_group Group entity with order data and State Owner Reference.
     * @return string An HTML string to be added to the PDF.
     */
    public function createStateOwnerGroup(PdfGroup $pdf_group): string
    {
        $pdf_meta_table = TableRegistry::getTableLocator()->get('PdfMeta');
        $pdf_meta = $pdf_meta_table->find()->where(['pdf_group_id' => $pdf_group->id]);

        $state_owner = TableRegistry::getTableLocator()->get('StateOwners')->get($pdf_group->state_owner_id);
        $raw_orders = [];
        $commission = 0.00;
        /** @var \App\Model\Entity\PdfMetum $item */
        foreach ($pdf_meta as $item) {
            $order = json_decode($item->value, true);
            $commission += $order['commission'];
            $raw_orders[] = $order;
        }
        $commission = $this->currency($commission, 'USD');

        $order_collection = new Collection($raw_orders);
        $orders = $order_collection->sortBy(function ($order) {
            return $order['date'];
        }, SORT_ASC, SORT_STRING);

        $headers = ['date', 'order', 'name', 'total', 'commission'];

        $html = [];
        $html[] = "<div class='state-owner-group'>";
        $html[] = sprintf('<p class="title">%s - %s</p>', $state_owner->state_owner_first_name . " " . $state_owner->state_owner_last_name, $commission);
        $html[] = "<table>";
        $html[] = "<tr>";
        foreach ($headers as $header) {
            $html[] = sprintf("<th class='%s'>%s</th>", $header, ucfirst($header));
        }
        $html[] = "</tr>";
        $row = 0;
        foreach ($orders as $order) {
            if ($row % 2 === 0) {
                $html[] = "<tr class='data-row'>";
            } else {
                $html[] = "<tr class='data-row gray'>";
            }
            $row++;
            foreach ($order as $key => $value) {
                if ($key === 'total' || $key === 'commission') {
                    $html[] = sprintf("<td class='%s'>%s</td>", $key, $this->currency($value, 'USD'));
                } else {
                    $html[] = sprintf("<td class='%s'>%s</td>", $key, $value);
                }

            }
            $html[] = "</tr>";
        }
        $html[] = "</table>";
        $html[] = "</div>";

        return join(PHP_EOL, $html);
    }

    /**
     * Format As Currency
     *
     * Format a string, integer, or float into a USD formatted string.
     * First character will be '$'.
     * The value before the decimal is annotated with commas.
     * The value after the decimal is limited to two spaces.
     * The value after the decimal will always have two digits, even if one of them is 0.
     *
     * @param string|int|float $raw_value Value to be converted into currency form.
     * @param string $currency
     * @return string Currency formatted value.
     */
    public function currency($raw_value, string $currency): string
    {
        $float_value = floatval($raw_value);
        $format = numfmt_create(self::LOCALE, 2);
        $result = numfmt_format_currency($format, $float_value, $currency);
        if ($result) {
            return $result;
        } else {
            throw new NotAcceptableException("Value $raw_value could not be converted into a currency form.");
        }
    }
}

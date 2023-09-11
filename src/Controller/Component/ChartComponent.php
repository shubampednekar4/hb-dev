<?php
declare(strict_types=1);

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\TableRegistry;

/**
 * Chart component
 */
class ChartComponent extends Component
{
    const YEAR = 'year';
    const MONTH = 'month';
    const WEEK = 'week';

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    /**
     * @param string $interval
     * @param \App\Model\Entity\Franchise[]|\Cake\Collection\Collection|\Cake\ORM\Query $franchises
     * @return string
     */
    public function franchise(string $interval, $franchises): string
    {
        switch ($interval) {
            case static::YEAR:
                $result = $franchises->groupBy(function($franchise) {
                    return $franchise->time_created->format('Y');
                });
                break;
            case static::MONTH:
                $result = $franchises->groupBy(function($franchise) {
                    return $franchise->time_created->format('M Y');
                });
                break;
            case static::WEEK:
                $result = $franchises->groupBy(function($franchise) {
                    return $franchise->time_created->format('W Y');
                });
                break;
            default:
                $result = [];
        }
        $data = [
            'labels' => [],
            'series' => [],
        ];
        $years = [];
        $total = 0;
        foreach ($result->toArray() as $year => $item) {
            $years[] = $year;
            $total += count($item);
            $data['series'][] = $total;
        }
        foreach ($years as $index => $year) {
            $data['labels'][$index + 1] = (string)$year;
        }
        return json_encode($data);
    }

    /**
     * @param \App\Model\Entity\Franchise[]|\Cake\Collection\Collection $franchises
     * @return string
     */
    public function getEarliestYear($franchises): string
    {
        $earliest = $franchises->min(function ($franchise) {
            /** @var \App\Model\Entity\Franchise $franchise */
            return $franchise->time_created;
        });
        /** @var \App\Model\Entity\Franchise $earliest */
        return $earliest->time_created->format('Y');
    }
}

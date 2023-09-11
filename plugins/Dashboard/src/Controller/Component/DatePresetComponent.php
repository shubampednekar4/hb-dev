<?php
declare(strict_types=1);

namespace Dashboard\Controller\Component;

use App\Model\Entity\Franchise;
use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\I18n\FrozenDate;

/**
 * DatePreset component
 */
class DatePresetComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function getAllMonths() {
        return [
            1 => __('Jan'),
            2 => __('Feb'),
            3 => __('Mar'),
            4 => __('Apr'),
            5 => __('May'),
            6 => __('Jun'),
            7 => __('Jul'),
            8 => __('Aug'),
            9 => __('Sep'),
            10 => __('Oct'),
            11 => __('Nov'),
            12 => __('Dec'),
        ];
    }

    public function getAllMonthsUpToCurrent()
    {
        $date = new FrozenDate();
        $currentMonth = $date->month;
        return $this->getAllMonthsUpTo($currentMonth);
    }

    public function getAllMonthsUpTo($monthIndex)
    {
        $months = $this->getAllMonths();
        $result = [];
        foreach ($months as $key => $month) {
            if ($key <= $monthIndex) {
                $result[$key]  = $month;
            }
        }
        return $result;
    }

    public function getCurrentYear()
    {
        $date = new FrozenDate();
        return $date->year;
    }

    /**
     * @param Franchise[]|\Cake\Collection\Collection|\Cake\ORM\Query $franchises
     * @return array
     */
    public function getAllFranchiseYears($franchises): array
    {
        return $franchises->toArray();
    }
}

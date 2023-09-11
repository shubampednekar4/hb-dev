<?php
declare(strict_types=1);

namespace App\View\Helper;

use Cake\View\Helper;

/**
 * Search helper
 *
 * @property \Cake\View\Helper\FormHelper $Form
 * @property \Cake\View\Helper\HtmlHelper $Html
 */
class SearchHelper extends Helper
{
    public $helpers = ['Form', 'Html'];
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    /**
     * @param bool $resetNeeded
     * @param string|null $prevSearch
     * @return string
     */
    public function create(bool $resetNeeded, ?string $prevSearch): string
    {
        $result = $this->Form->create(null, [
            'type' => 'get',
            'class' => 'card-form-horizontal',
        ]);
        $result .= '<div class="input-group">';
        $result .= $this->Form->control('search', [
            'required',
            'class' => 'form-control',
            'label' => false,
            'name' => 'search',
            'value' => __($prevSearch ?? ''),
        ]);
        $result .= $this->Form->button('<i class="material-icons">search</i>', [
            'escapeTitle' => false,
            'type' => 'submit',
            'class' => 'btn btn-round btw-white btn-just-icon',
        ]);
        $result .= $resetNeeded ? $this->Html->link(__('Reset'), [
            '?' => ['search' => '']], [
            'escapeTitle' => false,
            'class' => 'btn btn-danger btn-round',
            ]) : null;
        $result .= '</div>';
        $result .= $this->Form->end();

        return $result;
    }
}

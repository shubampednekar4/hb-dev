<?php
declare(strict_types=1);

namespace App\View\Helper;

use Cake\Utility\Hash;
use Cake\View\Helper\FormHelper;

/**
 * HB Form Helper
 *
 * @property \Cake\View\Helper\UrlHelper $Url
 * @property \Cake\View\Helper\HtmlHelper $Html
 */
class HBFormHelper extends FormHelper {
    /**
     * Returns a string to be used as onclick handler for confirm dialogs.
     *
     * @param string $message Message which should be shown
     * @param string $okCode Code to be executed after user chose 'OK'
     * @param string $cancelCode Code to be executed after user chose 'Cancel'
     * @return string "onclick" JS code
     */
    protected function _swalconfirm(string $message, string $okCode, string $cancelCode): string
    {
        $swal    = [
            'title'            => __('Are you sure?'),
            'text'             => $message,
            'icon'             => 'warning',
            'showCancelButton' => true,
            'cancelButtonText' => __('Cancel'),
        ];
        $confirm = "(function(e,obj){ 
      e.preventDefault(); 
      e.stopPropagation(); 
      Swal.fire(" . json_encode($swal) . ")
        .then(function(res){ 
          if(res.value){ " . $okCode . " }
          else{ " . $cancelCode . " }
        }); 
      })(event,this);";
        $escape = isset($options['escape']) && $options['escape'] === false;
        if ($escape) {
            $confirm = h($confirm);
        }

        return $confirm;
    }

    /**
     * Creates an HTML link, but access the URL using the method you specify
     * (defaults to POST). Requires javascript to be enabled in browser.
     *
     * This method creates a `<form>` element. If you want to use this method inside of an
     * existing form, you must use the `block` option so that the new form is being set to
     * a view block that can be rendered outside of the main form.
     *
     * If all you are looking for is a button to submit your form, then you should use
     * `FormHelper::button()` or `FormHelper::submit()` instead.
     *
     * ### Options:
     *
     * - `data` - Array with key/value to pass in input hidden
     * - `method` - Request method to use. Set to 'delete' to simulate
     *   HTTP/1.1 DELETE request. Defaults to 'post'.
     * - `confirm` - Confirm message to show. Form execution will only continue if confirmed then.
     * - `block` - Set to true to append form to view block "postLink" or provide
     *   custom block name.
     * - Other options are the same of HtmlHelper::link() method.
     * - The option `onclick` will be replaced.
     *
     * @param string $title The content to be wrapped by <a> tags.
     * @param string|array|null $url Cake-relative URL or array of URL parameters, or
     *   external URL (starts with http://)
     * @param array $options Array of HTML attributes.
     * @return string An `<a />` element.
     * @link https://book.cakephp.org/4/en/views/helpers/form.html#creating-standalone-buttons-and-post-links
     */
    public function postLink(string $title, $url = null, array $options = []): string
    {
        $options += ['block' => null, 'confirm' => null];

        $requestMethod = 'POST';
        if (!empty($options['method'])) {
            $requestMethod = strtoupper($options['method']);
            unset($options['method']);
        }

        $confirmMessage = $options['confirm'];
        unset($options['confirm']);

        $formName = str_replace('.', '', uniqid('post_', true));
        $formOptions = [
            'name' => $formName,
            'style' => 'display:none;',
            'method' => 'post',
        ];
        if (isset($options['target'])) {
            $formOptions['target'] = $options['target'];
            unset($options['target']);
        }
        $templater = $this->templater();

        $restoreAction = $this->_lastAction;
        $this->_lastAction($url);
        $restoreFormProtector = $this->formProtector;

        $action = $templater->formatAttributes([
            'action' => $this->Url->build($url),
            'escape' => false,
        ]);

        $out = $this->formatTemplate('formStart', [
            'attrs' => $templater->formatAttributes($formOptions) . $action,
        ]);
        $out .= $this->hidden('_method', [
            'value' => $requestMethod,
            'secure' => static::SECURE_SKIP,
        ]);
        $out .= $this->_csrfField();

        $formTokenData = $this->_View->getRequest()->getAttribute('formTokenData');
        if ($formTokenData !== null) {
            $this->formProtector = $this->createFormProtector($formTokenData);
        }

        $fields = [];
        if (isset($options['data']) && is_array($options['data'])) {
            foreach (Hash::flatten($options['data']) as $key => $value) {
                $fields[$key] = $value;
                $out .= $this->hidden($key, ['value' => $value, 'secure' => static::SECURE_SKIP]);
            }
            unset($options['data']);
        }
        $out .= $this->secure($fields);
        $out .= $this->formatTemplate('formEnd', []);

        $this->_lastAction = $restoreAction;
        $this->formProtector = $restoreFormProtector;

        if ($options['block']) {
            if ($options['block'] === true) {
                $options['block'] = __FUNCTION__;
            }
            $this->_View->append($options['block'], $out);
            $out = '';
        }
        unset($options['block']);

        $url = '#';
        $onClick = 'document.' . $formName . '.submit();';
        if ($confirmMessage) {
            $onClick                         = $this->_swalconfirm($confirmMessage, $onClick, '');
            $onClick                         = $onClick . 'event.returnValue = false; return false;';
            $onClick                         = $this->templater()
                ->format('confirmJs', [
                    'confirmMessage' => h($confirmMessage),
                    'formName'       => $formName,
                    'confirm'        => $onClick,
                ]);
            $options['data-confirm-message'] = $confirmMessage;
        } else {
            $onClick .= ' event.returnValue = false; return false;';
        }
        $options['onclick'] = $onClick;

        $out .= $this->Html->link($title, $url, $options);

        return $out;
    }
}
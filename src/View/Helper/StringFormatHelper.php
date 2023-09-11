<?php
declare(strict_types=1);

namespace App\View\Helper;

use Cake\Http\Exception\NotAcceptableException;
use Cake\View\Helper;
use NumberFormatter;

/**
 * StringFormat helper
 */
class StringFormatHelper extends Helper
{
    /**
     * Default locale.
     *
     * @var string
     */
    public const LOCALE = 'en_US';
    /**
     * Default Currency.
     *
     * @var string
     */
    public const CURRENCY = 'USD';
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

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
     * @return string Currency formatted value.
     */
    public function currency($raw_value): string
    {
        $float_value = floatval($raw_value);
        $format = numfmt_create(self::LOCALE, NumberFormatter::CURRENCY);
        $result = numfmt_format_currency($format, $float_value, self::CURRENCY);
        if ($result) {
            return $result;
        } else {
            throw new NotAcceptableException("Value ${raw_value} could not be converted into a currency form.");
        }
    }
}

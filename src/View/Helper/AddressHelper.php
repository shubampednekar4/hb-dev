<?php
declare(strict_types=1);

namespace App\View\Helper;

use App\Dto\AddressDto;
use Cake\Core\Configure;
use Cake\Log\Log;
use Cake\Routing\Router;
use Cake\View\Helper;
use InvalidArgumentException;

/**
 * Address helper
 */
class AddressHelper extends Helper
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    /**
     * Google Maps Link
     *
     * Create a link from the data for a Google Maps link.
     * The link is an HTML string.
     *
     * @param array{street_address: string, city: string, state: string, zip: string} $data Data from which link is
     * created.
     * @return string HTML source code with Link.
     */
    public function getAddressLink(array $data): string
    {
        $base = Configure::read('Google.url_base.maps');
        try {
            $address = new AddressDto([
                'streetAddress' => $data['street_address'],
                'city' => $data['city'],
                'state' => $data['state'],
                'zip' => $data['zip'],
            ]);
        } catch (InvalidArgumentException $e) {
            Log::warning('Address is incomplete, no link generated.');
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return 'javascript:;';
        }
        $parameters = sprintf('%s, %s, %s %s', $address->streetAddress, $address->city, $address->state, $address->zip);
        $parameters = urlencode($parameters);

        return Router::url(join('', [$base, $parameters]), true);
    }
}

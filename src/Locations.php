<?php declare(strict_types=1);

namespace Smartbnb\RemoteLockApi;

use Smartbnb\RemoteLockApi\Client\Concrete\LocationClient;
use Smartbnb\RemoteLockApi\Client\Concrete\LocationsClient;
use Smartbnb\RemoteLockApi\Client\Method;

class Locations extends BaseEndpoint
{
    /**
     * @return LocationsClient
     * @see https://developer.remotelock.com/api/docs#locations-get-all-locations
     */
    public function all(): LocationsClient
    {
        return $this->createClientUsing(
            LocationsClient::class,
            Method::GET(),
            'locations'
        );
    }

    /**
     * @return LocationClient
     * @see https://developer.remotelock.com/api/docs#locations-get-a-location
     */
    public function get(string $locationId): LocationClient
    {
        return $this->createClientUsing(
            LocationClient::class,
            Method::GET(),
            "locations/{$locationId}"
        );
    }
}

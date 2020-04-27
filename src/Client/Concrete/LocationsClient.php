<?php declare(strict_types=1);

namespace Smartbnb\RemoteLockApi\Client\Concrete;

use Smartbnb\RemoteLockApi\Client\Client;
use Smartbnb\RemoteLockApi\Client\ClientInterface;
use Psr\Http\Client\ClientExceptionInterface;
use Smartbnb\RemoteLockApi\Collections\LocationCollection;
use Smartbnb\RemoteLockApi\Entities\Location;
use Smartbnb\RemoteLockApi\Entities\User;
use Smartbnb\RemoteLockApi\Exceptions\Client\ClientResponseException;
use Smartbnb\RemoteLockApi\Exceptions\Client\ResponseException;
use Smartbnb\RemoteLockApi\Exceptions\Client\ServerResponseException;

class LocationsClient extends Client implements ClientInterface
{
    /**
     * Execute the request and return collection.
     *
     * @return User
     * @throws ClientExceptionInterface
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws ResponseException
     */
    public function execute(): LocationCollection
    {
        $response = $this->sendRequest($this->request);
        $responseData = json_decode((string) $response->getBody(), true);

        $map = array_map(function ($item) {
            return new Location($item);
        }, $responseData['data']);

        return new LocationCollection($map, ($responseData['meta'] ?? null));
    }
}

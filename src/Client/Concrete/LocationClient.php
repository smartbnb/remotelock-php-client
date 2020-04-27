<?php declare(strict_types=1);

namespace Smartbnb\RemoteLockApi\Client\Concrete;

use Smartbnb\RemoteLockApi\Client\Client;
use Smartbnb\RemoteLockApi\Client\ClientInterface;
use Psr\Http\Client\ClientExceptionInterface;
use Smartbnb\RemoteLockApi\Entities\Location;
use Smartbnb\RemoteLockApi\Exceptions\Client\ClientResponseException;
use Smartbnb\RemoteLockApi\Exceptions\Client\ResponseException;
use Smartbnb\RemoteLockApi\Exceptions\Client\ServerResponseException;

class LocationClient extends Client implements ClientInterface
{
    /**
     * Execute the request and return entity.
     *
     * @return Location
     * @throws ClientExceptionInterface
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws ResponseException
     */
    public function execute(): Location
    {
        $response = $this->sendRequest($this->request);

        return new Location(
            json_decode((string) $response->getBody(), true)['data']
        );
    }
}

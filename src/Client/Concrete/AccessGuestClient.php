<?php declare(strict_types=1);

namespace Smartbnb\RemoteLockApi\Client\Concrete;

use Smartbnb\RemoteLockApi\Client\Client;
use Smartbnb\RemoteLockApi\Client\ClientInterface;
use Smartbnb\RemoteLockApi\Entities\AccessGuest;
use Psr\Http\Client\ClientExceptionInterface;
use Smartbnb\RemoteLockApi\Exceptions\Client\ClientResponseException;
use Smartbnb\RemoteLockApi\Exceptions\Client\ResponseException;
use Smartbnb\RemoteLockApi\Exceptions\Client\ServerResponseException;

class AccessGuestClient extends Client implements ClientInterface
{
    /**
     * Execute the request and return collection.
     *
     * @return AccessGuest
     * @throws ClientExceptionInterface
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws ResponseException
     */
    public function execute(): AccessGuest
    {
        $response = $this->sendRequest($this->request);

        return new AccessGuest(
            json_decode((string) $response->getBody(), true)['data']
        );
    }
}

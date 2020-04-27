<?php declare(strict_types=1);

namespace Smartbnb\RemoteLockApi\Client\Concrete;

use Smartbnb\RemoteLockApi\Client\Client;
use Smartbnb\RemoteLockApi\Client\ClientInterface;
use Psr\Http\Client\ClientExceptionInterface;
use Smartbnb\RemoteLockApi\Entities\AccessPersonAccess;
use Smartbnb\RemoteLockApi\Exceptions\Client\ClientResponseException;
use Smartbnb\RemoteLockApi\Exceptions\Client\ResponseException;
use Smartbnb\RemoteLockApi\Exceptions\Client\ServerResponseException;

class AccessPersonAccessClient extends Client implements ClientInterface
{
    /**
     * Execute the request and return an AccessPersonAccess entity.
     *
     * @return AccessPersonAccess
     * @throws ClientExceptionInterface
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws ResponseException
     */
    public function execute(): AccessPersonAccess
    {
        $response = $this->sendRequest($this->request);

        return new AccessPersonAccess(
            json_decode($response->getBody(), true)['data']
        );
    }
}

<?php declare(strict_types=1);

namespace Smartbnb\RemoteLockApi\Client\Concrete;

use Smartbnb\RemoteLockApi\Client\Client;
use Smartbnb\RemoteLockApi\Client\ClientInterface;
use Psr\Http\Client\ClientExceptionInterface;
use Smartbnb\RemoteLockApi\Entities\User;
use Smartbnb\RemoteLockApi\Exceptions\Client\ClientResponseException;
use Smartbnb\RemoteLockApi\Exceptions\Client\ResponseException;
use Smartbnb\RemoteLockApi\Exceptions\Client\ServerResponseException;

class UserClient extends Client implements ClientInterface
{
    /**
     * Execute the request and return entity.
     *
     * @return User
     * @throws ClientExceptionInterface
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws ResponseException
     */
    public function execute(): User
    {
        $response = $this->sendRequest($this->request);

        return new User(
            json_decode((string) $response->getBody(), true)['data']
        );
    }
}

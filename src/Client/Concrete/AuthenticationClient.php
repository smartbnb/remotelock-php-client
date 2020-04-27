<?php declare(strict_types=1);

namespace Smartbnb\RemoteLockApi\Client\Concrete;

use Psr\Http\Message\ResponseInterface;
use Smartbnb\RemoteLockApi\Client\Client;
use Smartbnb\RemoteLockApi\Client\ClientInterface;
use Psr\Http\Client\ClientExceptionInterface;

class AuthenticationClient extends Client implements ClientInterface
{
    /**
     * Execute the request and return raw ResponseInterface.
     *
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     */
    public function execute(): ResponseInterface
    {
        return $this->sendRequest($this->request);
    }
}

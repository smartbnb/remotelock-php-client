<?php declare(strict_types=1);

namespace Smartbnb\RemoteLockApi;

use Smartbnb\RemoteLockApi\Client\Client;
use Smartbnb\RemoteLockApi\Client\ClientFactory;
use Smartbnb\RemoteLockApi\Client\ClientInterface;
use Smartbnb\RemoteLockApi\Client\Method;

abstract class BaseEndpoint
{
    private const ENDPOINT = "https://api.remotelock.com/v1/%s";

    /** @var ClientFactory */
    private $clientFactory;

    /**
     * BaseEndpoint constructor.
     *
     * @param ClientFactory $clientFactory
     */
    public function __construct(
        ClientFactory $clientFactory
    ) {
        $this->clientFactory = $clientFactory;
    }

    /**
     * @param string $clientInterface
     * @param Method $method
     * @param string $path
     *
     * @return Client
     */
    protected function createClientUsing(string $clientInterface, Method $method, string $path): ClientInterface
    {
        $uri = sprintf(
            self::ENDPOINT,
            ltrim($path, '/')
        );

        return $this->clientFactory->makeUsing($clientInterface, $method, $uri);
    }
}

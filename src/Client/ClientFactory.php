<?php declare(strict_types=1);

namespace Smartbnb\RemoteLockApi\Client;

use Smartbnb\RemoteLockApi\Exceptions\InvalidClientImplementationException;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Smartbnb\RemoteLockApi\Client\ClientInterface as RemoteLockClientInterface;

class ClientFactory
{
    /** @var ClientInterface */
    private $httpClient;

    /** @var RequestFactoryInterface */
    private $requestFactory;

    /** @var StreamFactoryInterface */
    private $streamFactory;

    /**
     * BaseEndpoint constructor.
     *
     * @param ClientInterface|null $httpClient
     * @param RequestFactoryInterface|null $requestFactory
     * @param StreamFactoryInterface|null $streamFactory
     */
    public function __construct(
        ClientInterface $httpClient = null,
        RequestFactoryInterface $requestFactory = null,
        StreamFactoryInterface $streamFactory = null
    ) {
        $this->httpClient = $httpClient ?: Psr18ClientDiscovery::find();
        $this->requestFactory = $requestFactory ?: Psr17FactoryDiscovery::findRequestFactory();
        $this->streamFactory = $streamFactory ?: Psr17FactoryDiscovery::findStreamFactory();
    }

    public function makeUsing(string $clientClass, Method $method, string $uri): Client
    {
        if (!in_array(RemoteLockClientInterface::class, class_implements($clientClass))) {
            throw InvalidClientImplementationException::createFromFQCN($clientClass);
        }

        return new $clientClass(
            $this->requestFactory->createRequest((string) $method, $uri),
            $this->streamFactory,
            $this->httpClient
        );
    }
}

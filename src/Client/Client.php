<?php declare(strict_types=1);

namespace Smartbnb\RemoteLockApi\Client;

use Http\Message\MultipartStream\MultipartStreamBuilder;
use Http\Message\Stream\BufferedStream;
use Http\Message\StreamFactory;
use Http\Message\StreamFactory\GuzzleStreamFactory;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface as PsrClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Smartbnb\RemoteLockApi\Exceptions\Client\ClientResponseException;
use Smartbnb\RemoteLockApi\Exceptions\Client\ResponseException;
use Smartbnb\RemoteLockApi\Exceptions\Client\ServerResponseException;
use Smartbnb\RemoteLockApi\Exceptions\Client\UnhandledResponseException;

abstract class Client implements ClientInterface
{
    /** @var RequestInterface */
    protected $request;

    /** @var StreamFactoryInterface */
    protected $streamFactory;

    /** @var PsrClientInterface */
    protected $httpClient;

    /**
     * Client constructor.
     *
     * @param RequestInterface $request
     * @param StreamFactoryInterface $streamFactory
     * @param PsrClientInterface $httpClient
     */
    public function __construct(
        RequestInterface $request,
        StreamFactoryInterface $streamFactory,
        PsrClientInterface $httpClient
    ) {
        $this->request = $request;
        $this->streamFactory = $streamFactory;
        $this->httpClient = $httpClient;
    }

    /**
     * Set the given token to use on the request.
     *
     * @param string $token
     *
     * @return static
     */
    public function useToken(string $token): ClientInterface
    {
        $this->request = $this->request->withHeader(
            'Authorization',
            "Bearer $token"
        );

        return $this;
    }

    /**
     * Set query to use on the request.
     *
     * @param QueryBuilder $queryBuilder
     *
     * @return static
     */
    public function withQuery(QueryBuilder $queryBuilder): ClientInterface
    {
        $this->request = $this->request->withUri(
            $this->request->getUri()
                ->withQuery((string) $queryBuilder)
        );

        return $this;
    }

    /**
     * Set data to use on the request as a 'application/x-www-form-urlencoded' request.
     *
     * @param DataBuilder $dataBuilder
     *
     * @return static
     */
    public function withData(DataBuilder $dataBuilder): ClientInterface
    {
        $this->request = $this->request->withHeader(
            'Content-Type',
            'application/x-www-form-urlencoded'
        );

        $stream = $this->streamFactory->createStream(
            http_build_query($dataBuilder->all(), '', '&')
        );
        $this->request = $this->request->withBody($stream);

        return $this;
    }

    /**
     * Set json to send with the request as a 'application/json' request.
     *
     * @param DataBuilder $dataBuilder
     *
     * @return static
     */
    public function withJson(DataBuilder $dataBuilder): ClientInterface
    {
        $this->request = $this->request->withHeader(
            'Content-Type',
            'application/json'
        );

        $stream = $this->streamFactory->createStream(
            json_encode($dataBuilder->all())
        );
        $this->request = $this->request->withBody($stream);

        return $this;
    }

    /**
     * @param RequestInterface $request
     *
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws ResponseException
     */
    protected function sendRequest(RequestInterface $request)
    {
        $response = $this->httpClient->sendRequest($request);

        switch (substr((string) $response->getStatusCode(), 0, 1)) {
            case 2: // 2XX status codes
                return $response;
            case 4: // 4XX status codes
                $exceptionClass = ClientResponseException::class;
                break;
            case 5: // 5XX status codes
                $exceptionClass = ServerResponseException::class;
                break;
            default: // XXX unhandled status code
                $exceptionClass = UnhandledResponseException::class;
                break;
        }

        throw new $exceptionClass($request, $response);
    }
}

<?php

namespace Smartbnb\RemoteLockApi\Exceptions\Client;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;

abstract class ResponseException extends RuntimeException
{
    /** @var RequestInterface */
    private $request;

    /** @var ResponseInterface */
    private $response;

    public function __construct(RequestInterface $request, ResponseInterface $response)
    {
        $this->request = $request;
        $this->response = $response;

        parent::__construct($this->determineMessage(), $response->getStatusCode());
    }

    /**
     * @return RequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }

    private function determineMessage()
    {
        $body = json_encode((string) $this->response->getBody(), true);

        // General error
        if (isset($body['message'])) {
            return "{$this->response->getStatusCode()} General Error: {$body['message']}";
        }

        return "{$this->response->getStatusCode()} Resource Error";
    }
}
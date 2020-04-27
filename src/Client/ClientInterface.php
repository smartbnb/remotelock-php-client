<?php declare(strict_types=1);

namespace Smartbnb\RemoteLockApi\Client;

use Psr\Http\Client\ClientExceptionInterface;

interface ClientInterface
{
    /**
     * Execute the request.
     *
     * @throws ClientExceptionInterface
     */
    public function execute();

    /**
     * Set the given token to use on the request.
     *
     * @param string $token
     *
     * @return ClientInterface
     */
    public function useToken(string $token): ClientInterface;

    /**
     * Set query to use on the request.
     *
     * @param QueryBuilder $queryBuilder
     *
     * @return ClientInterface
     */
    public function withQuery(QueryBuilder $queryBuilder): ClientInterface;

    /**
     * Set data to use on the request.
     *
     * @param DataBuilder $dataBuilder
     *
     * @return ClientInterface
     */
    public function withData(DataBuilder $dataBuilder): ClientInterface;
}

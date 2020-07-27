<?php

namespace Smartbnb\RemoteLockApi\Tests\Integration;

use Http\Message\Stream\BufferedStream;
use Http\Mock\Client;
use Mockery;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Smartbnb\RemoteLockApi\AccessPersons;
use Smartbnb\RemoteLockApi\Client\ClientFactory;
use Smartbnb\RemoteLockApi\Client\Concrete\AccessGuestClient;
use Smartbnb\RemoteLockApi\Client\DataBuilder;
use Smartbnb\RemoteLockApi\Entities\AccessGuest;
use Smartbnb\RemoteLockApi\Properties\SimpleProperty;
use Smartbnb\RemoteLockApi\Tests\TestCase;

class AccessPersonsTest extends TestCase
{
    /** @test */
    public function createAccessGuestMakesExpectedHttpRequest()
    {
        // Given we have a mocked HTTP client.
        $httpClient = new Client();
        $httpClient->addResponse(Mockery::mock(ResponseInterface::class, [
            'getBody' => Mockery::mock(StreamInterface::class, [
                '__toString' => file_get_contents(__DIR__ . '../../stubs/access_guest.json')
            ])
        ]));

        // And the AccessPersons endpoint class (with mocked HTTP passed in).
        $accessPersonsApi = new AccessPersons(
            new ClientFactory($httpClient)
        );

        // When we attempt to create an Access Guest.
        $client = $accessPersonsApi->createAccessGuest();
        $result = $client
            ->useToken("token_1234")
            ->withData(
                (new DataBuilder())
                    ->addProperties(
                        new SimpleProperty('name', 'value')
                    )
            )
            ->execute();

        // Then we made one request.
        $this->assertCount(1, $httpClient->getRequests());
        $request = $httpClient->getRequests()[0];

        // And the request was of method POST to the expected URL with the expected token header.
        $this->assertSame('post', $request->getMethod());
        $this->assertSame('https://api.remotelock.com/v1/access_persons', (string) $request->getUri());
        $this->assertSame("Bearer token_1234", $request->getHeader('Authorization')[0]);

        // And the entity we got back was that of AccessGuest.
        $this->assertInstanceOf(AccessGuest::class, $result);

        // And the the entity contained the expected data.
        $this->assertSame($result->getRawData()['id'], 'id_1234');
    }
}
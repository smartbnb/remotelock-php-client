<?php declare(strict_types=1);

namespace Smartbnb\RemoteLockApi\Client;

final class Settings
{
    /** @var string */
    private $clientId;

    /** @var string */
    private $clientSecret;

    /** @var string */
    private $callbackUri;

    public function __construct(
        string $clientId,
        string $clientSecret,
        string $callbackUri
    ) {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->callbackUri = $callbackUri;
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }

    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    public function getCallbackUri(): string
    {
        return $this->callbackUri;
    }
}

<?php declare(strict_types=1);

namespace Smartbnb\RemoteLockApi\Entities;

class OAuthToken
{
    /** @var array */
    private $rawData;

    /**
     * OAuthToken constructor.
     *
     * @param array $oAuthTokenData
     */
    public function __construct(array $oAuthTokenData)
    {
        $this->rawData = $oAuthTokenData;
    }

    /**
     * Get the raw underlying oauth token data
     * response given from RemoteLock.
     *
     * @return array
     */
    public function getRawData(): array
    {
        return $this->rawData;
    }

    public function getAccessToken(): string
    {
        return $this->rawData['access_token'];
    }

    public function getRefreshToken(): string
    {
        return $this->rawData['refresh_token'];
    }

    public function getTokenType(): string
    {
        return $this->rawData['token_type'];
    }

    public function getExpiresIn(): int
    {
        return $this->rawData['expires_in'];
    }
}

<?php declare(strict_types=1);

namespace Smartbnb\RemoteLockApi;

use Psr\Http\Client\ClientExceptionInterface;
use Smartbnb\RemoteLockApi\Client\ClientFactory;
use Smartbnb\RemoteLockApi\Client\Concrete\AuthenticationClient;
use Smartbnb\RemoteLockApi\Client\DataBuilder;
use Smartbnb\RemoteLockApi\Client\Method;
use Smartbnb\RemoteLockApi\Client\Settings;
use Smartbnb\RemoteLockApi\Entities\OAuthToken;
use Smartbnb\RemoteLockApi\Properties\SimpleProperty;

class Authentication
{
    private const ENDPOINT = "https://connect.remotelock.com/%s";

    /** @var ClientFactory */
    private $clientFactory;

    /** @var Settings */
    private $settings;

    /**
     * Authentication constructor.
     *
     * @param Settings $settings
     * @param ClientFactory $clientFactory
     */
    public function __construct(
        Settings $settings,
        ClientFactory $clientFactory
    ) {
        $this->settings = $settings;
        $this->clientFactory = $clientFactory;
    }

    /**
     * @return string
     */
    public function generateOAuthUri(): string
    {
        $query = http_build_query([
            'client_id' => $this->settings->getClientId(),
            'response_type' => 'code',
            'redirect_uri' => $this->settings->getCallbackUri(),
        ]);

        return sprintf(
            self::ENDPOINT,
            "oauth/authorize?"
        ) . $query;
    }

    /**
     * @param $code
     *
     * @return OAuthToken
     * @throws ClientExceptionInterface
     */
    public function generateToken($code): OAuthToken
    {
        $data = (new DataBuilder())->addProperties(
            new SimpleProperty('code', $code),
            new SimpleProperty('client_id', $this->settings->getClientId()),
            new SimpleProperty('client_secret', $this->settings->getClientSecret()),
            new SimpleProperty('redirect_uri', $this->settings->getCallbackUri()),
            new SimpleProperty('grant_type', 'authorization_code')
        );

        $response = $this
            ->createClientUsing(
                Method::POST(),
                "oauth/token"
            )
            ->withData($data)
            ->execute();

        return new OAuthToken(
            json_decode((string) $response->getBody(), true)
        );
    }

    /**
     * @param $refreshToken
     *
     * @return OAuthToken
     * @throws ClientExceptionInterface
     */
    public function refreshToken($refreshToken): OAuthToken
    {
        $data = (new DataBuilder())->addProperties(
            new SimpleProperty('refresh_token', $refreshToken),
            new SimpleProperty('client_id', $this->settings->getClientId()),
            new SimpleProperty('client_secret', $this->settings->getClientSecret()),
            new SimpleProperty('grant_type', 'refresh_token')
        );

        $response = $this
            ->createClientUsing(
                Method::POST(),
                "oauth/token"
            )
            ->withData($data)
            ->execute();

        return new OAuthToken(
            json_decode((string) $response->getBody(), true)
        );
    }

    /**
     * @param Method $method
     * @param string $path
     *
     * @return AuthenticationClient
     */
    private function createClientUsing(Method $method, string $path): AuthenticationClient
    {
        $uri = sprintf(
            self::ENDPOINT,
            ltrim($path, '/')
        );

        return $this->clientFactory->makeUsing(AuthenticationClient::class, $method, $uri);
    }
}

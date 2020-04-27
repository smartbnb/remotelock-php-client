# RemoteLock PHP Client

This repo contains a client for the remotelock.com API.
The client aims to be fully PS7 compatible.

You will need a PSR compliant HTTP client:
```php
composer require guzzlehttp/guzzle php-http/guzzle6-adapter nyholm/psr7
```

### Laravel support

This library should be simple to use in any Laravel project.
The only class _needed_ to be registered in the container will
be the `Smartbnb\RemoteLockApi\Client\Settings` class, all other
classes should be compliant with Laravel's dependency resolver given
you have a PS7 compliant HTTP client installed via composer.

```php
use Smartbnb\RemoteLockApi\Client\Settings;

class ExampleServiceProvider
{
    public function boot()
    {
        $this->app->singleton(Settings::class, function () {
            return new Settings(
                "remotelock_client_id",
                "remotelock_client_secret",
                "https://yourapp.test/oauth/callback"
            );
        });
    }
}
```

```php
use Smartbnb\RemoteLockApi\AccessPersons;
use Smartbnb\RemoteLockApi\Entities\AccessGuest;
use Smartbnb\RemoteLockApi\Client\DataBuilder;
use Smartbnb\RemoteLockApi\Properties\SimpleProperty;

class Controller
{
    public function someMethod(AccessPersons $accessPersons, DataBuilder $dataBuilder)
    {
        /** @var AccessGuest  $accessGuest */
        $accessGuest = $accessPersons->createAccessGuest()
            ->useToken($currentUsersOAuthToken)
            ->withData(
                $dataBuilder->addProperties(
                    new SimpleProperty('type', 'access_guest'),
                    new SimpleProperty('attributes[name]', 'John Doe'),
                    new SimpleProperty('attributes[pin]', 1234)
                )
            )
            ->execute();
    }
}
```
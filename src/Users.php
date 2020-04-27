<?php declare(strict_types=1);

namespace Smartbnb\RemoteLockApi;

use Smartbnb\RemoteLockApi\Client\Concrete\UserClient;
use Smartbnb\RemoteLockApi\Client\Method;

class Users extends BaseEndpoint
{
    /**
     * @return UserClient
     * @see https://developer.remotelock.com/api/docs#users-get-signed-in-user
     */
    public function getSignedInUser(): UserClient
    {
        return $this->createClientUsing(
            UserClient::class,
            Method::GET(),
            'user'
        );
    }
}

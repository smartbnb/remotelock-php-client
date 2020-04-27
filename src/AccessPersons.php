<?php declare(strict_types=1);

namespace Smartbnb\RemoteLockApi;

use Smartbnb\RemoteLockApi\Client\Concrete\AccessGuestClient;
use Smartbnb\RemoteLockApi\Client\Concrete\AccessPersonAccessClient;
use Smartbnb\RemoteLockApi\Client\Method;

class AccessPersons extends BaseEndpoint
{
    /**
     * @return AccessGuestClient
     * @see https://developer.remotelock.com/api/docs/#access-persons-create-an-access-guest
     */
    public function createAccessGuest(): AccessGuestClient
    {
        return $this->createClientUsing(
            AccessGuestClient::class,
            Method::POST(),
            'access_persons'
        );
    }

    /**
* @param string $accessPersonId
     * @return AccessPersonAccessClient
     *
     * @see https://developer.remotelock.com/api/docs#access-persons-grant-an-access-person-access
     */
    public function grantAccessPersonAccess(string $accessPersonId): AccessPersonAccessClient
    {
        return $this->createClientUsing(
            AccessPersonAccessClient::class,
            Method::POST(),
            "/access_persons/$accessPersonId/accesses"
        );
    }
}

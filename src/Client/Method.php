<?php declare(strict_types=1);

namespace Smartbnb\RemoteLockApi\Client;

use MyCLabs\Enum\Enum;

/**
 * Class Method
 *
 * @package Smartbnb\RemoteLockApi\Client
 *
 * @method static Method GET()
 * @method static Method POST()
 */
class Method extends Enum
{
    private const GET = 'GET';
    private const POST = 'POST';
}

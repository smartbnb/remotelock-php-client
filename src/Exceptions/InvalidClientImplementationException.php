<?php declare(strict_types=1);

namespace Smartbnb\RemoteLockApi\Exceptions;

use Smartbnb\RemoteLockApi\Client\ClientInterface;
use RuntimeException;

class InvalidClientImplementationException extends RuntimeException
{
    public static function createFromFQCN($fqcn)
    {
        return new self("{$fqcn} is not a implementation of " . ClientInterface::class . ".");
    }
}

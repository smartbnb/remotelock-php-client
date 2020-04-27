<?php declare(strict_types=1);

namespace Smartbnb\RemoteLockApi\Entities;

class AccessPersonAccess
{
    /** @var array */
    private $rawData;

    /**
     * AccessPersonAccess constructor.
     *
     * @param array $accessPersonAccessData
     */
    public function __construct(array $accessPersonAccessData)
    {
        $this->rawData = $accessPersonAccessData;
    }

    /**
     * Get the raw underlying access person access
     * response given from RemoteLock.
     *
     * @return array
     */
    public function getRawData(): array
    {
        return $this->rawData;
    }
}

<?php declare(strict_types=1);

namespace Smartbnb\RemoteLockApi\Entities;

class AccessGuest
{
    /** @var array */
    private $rawData;

    /**
     * AccessGuest constructor.
     *
     * @param array $accessGuestData
     */
    public function __construct(array $accessGuestData)
    {
        $this->rawData = $accessGuestData;
    }

    /**
     * Get the raw underlying access guest
     * response given from RemoteLock.
     *
     * @return array
     */
    public function getRawData(): array
    {
        return $this->rawData;
    }
}

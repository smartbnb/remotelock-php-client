<?php declare(strict_types=1);

namespace Smartbnb\RemoteLockApi\Entities;

class Location
{
    /** @var array */
    private $rawData;

    /**
     * Location constructor.
     *
     * @param array $locationData
     */
    public function __construct(array $locationData)
    {
        $this->rawData = $locationData;
    }

    /**
     * Get the raw underlying location data
     * response given from RemoteLock.
     *
     * @return array
     */
    public function getRawData(): array
    {
        return $this->rawData;
    }
}

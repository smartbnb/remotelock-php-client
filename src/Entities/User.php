<?php declare(strict_types=1);

namespace Smartbnb\RemoteLockApi\Entities;

class User
{
    /** @var array */
    private $rawData;

    /**
     * User constructor.
     *
     * @param array $userData
     */
    public function __construct(array $userData)
    {
        $this->rawData = $userData;
    }

    /**
     * Get the raw underlying user data
     * response given from RemoteLock.
     *
     * @return array
     */
    public function getRawData(): array
    {
        return $this->rawData;
    }
}

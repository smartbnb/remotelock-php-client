<?php declare(strict_types=1);

namespace Smartbnb\RemoteLockApi\Entities;

class Pagination
{
    /** @var array */
    private $rawData;

    /**
     * Pagination constructor.
     *
     * @param array $paginationData
     */
    public function __construct(array $paginationData)
    {
        $this->rawData = $paginationData;
    }

    /**
     * Get the raw underlying pagination data
     * response given from RemoteLock.
     *
     * @return array
     */
    public function getRawData(): array
    {
        return $this->rawData;
    }

    public function getPage(): int
    {
        return $this->rawData['page'];
    }

    public function getPerPage(): int
    {
        return $this->rawData['per_page'];
    }

    public function getTotalCount(): int
    {
        return $this->rawData['total_count'];
    }

    public function getTotalPages(): int
    {
        return $this->rawData['total_pages'];
    }
}

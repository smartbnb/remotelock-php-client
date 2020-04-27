<?php

namespace Smartbnb\RemoteLockApi\Collections;

use Smartbnb\RemoteLockApi\Entities\Location;
use Smartbnb\RemoteLockApi\Entities\Pagination;

class LocationCollection
{
    /** @var Location[] */
    private $data;

    /** @var array|null */
    private $meta;

    public function __construct(array $data, ?array $meta)
    {
        $this->data = $data;
        $this->meta = $meta;
    }

    public function all(): array
    {
        return $this->data;
    }

    public function hasPagination(): bool
    {
        return !!$this->meta;
    }

    public function getPagination(): ?Pagination
    {
        return $this->meta ? new Pagination($this->meta) : null;
    }
}
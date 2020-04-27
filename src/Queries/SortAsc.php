<?php declare(strict_types=1);

namespace Smartbnb\RemoteLockApi\Queries;

class SortAsc implements SortableProperty
{
    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}

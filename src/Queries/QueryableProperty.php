<?php declare(strict_types=1);

namespace Smartbnb\RemoteLockApi\Queries;

interface QueryableProperty
{
    public function getName(): string;

    public function getValue();
}

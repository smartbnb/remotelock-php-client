<?php declare(strict_types=1);

namespace Smartbnb\RemoteLockApi\Properties;

interface DataProperty
{
    public function getName(): string;

    public function getValue();
}

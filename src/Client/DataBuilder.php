<?php declare(strict_types=1);

namespace Smartbnb\RemoteLockApi\Client;

use Smartbnb\RemoteLockApi\Properties\DataProperty;

class DataBuilder
{
    /** @var DataProperty[] */
    private $data = [];

    public function addProperty(DataProperty $property): self
    {
        $this->data[$property->getName()] = $property;
        return $this;
    }

    public function addProperties(DataProperty ...$properties): self
    {
        foreach ($properties as $property) {
            $this->data[$property->getName()] = $property;
        }

        return $this;
    }

    public function all(): array
    {
        $data = [];

        // Build the body data.
        foreach ($this->data as $property) {
            if (!isset($data[$property->getName()])) {
                $data[$property->getName()] = [];
            }

            $data[$property->getName()][] = $property->getValue();
        }

        // Any single items can be set as name=value instead of name[]=value
        $data = array_map(function (array $property) {
            if (count($property) === 1) {
                return $property[0];
            } else {
                return $property;
            }
        }, $data);

        return $data;
    }
}

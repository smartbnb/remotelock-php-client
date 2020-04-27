<?php declare(strict_types=1);

namespace Smartbnb\RemoteLockApi\Properties;

class SimpleProperty implements DataProperty
{
    /** @var string */
    private $key;

    /** @var mixed */
    private $value;

    /**
     * BasicProperty constructor.
     *
     * @param string $key
     * @param mixed $value
     */
    public function __construct(string $key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->key;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}

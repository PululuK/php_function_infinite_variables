<?php

declare(strict_types=1);

namespace PululuK\Example\Core;

use ArrayIterator;
use Countable;
use IteratorAggregate;

/**
 * MyClass Parameter bag
 */
class MyClassParameter implements IteratorAggregate, Countable, MyClassParameterInterface
{
    /**
     * @param array $parameters
     */
    public function __construct(private array $parameters = []){}

    /**
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->parameters);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return \count($this->parameters);
    }

    /**
     * @param string $paramName
     * @return mixed
     */
    public function get(string $paramName): mixed
    {
        return $this->parameters[$paramName] ?? null;
    }

    /**
     * @param string $paramName
     * @param mixed $paramValue
     * @return void
     */
    public function set(string $paramName, mixed $paramValue): void
    {
        $this->parameters[$paramName] = $paramValue;
    }

    /**
     * @param string $paramName
     * @return bool
     */
    public function has(string $paramName): bool
    {
        return \array_key_exists($paramName, $this->parameters);
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        return $this->parameters;
    }
}
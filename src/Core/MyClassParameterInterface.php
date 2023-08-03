<?php

declare(strict_types=1);

namespace PululuK\Example\Core;

/**
 * MyClassParameterInterface
 */
interface MyClassParameterInterface
{
    /**
     * @param string $paramName
     * @return mixed
     */
    public function get(string $paramName): mixed;

    /**
     * @param string $paramName
     * @param mixed $paramValue
     * @return void
     */
    public function set(string $paramName, mixed $paramValue): void;

    /**
     * @param string $paramName
     * @return bool
     */
    public function has(string $paramName): bool;

    /**
     * @return array
     */
    public function getAll(): array;

}
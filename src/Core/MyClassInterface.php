<?php

declare(strict_types=1);

namespace PululuK\Example\Core;

interface MyClassInterface{
    /**
     * @return MyClassDefinitionInterface|null
     */
    public function getDefinition(): ?MyClassDefinitionInterface;
}
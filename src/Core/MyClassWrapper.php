<?php

declare(strict_types=1);

namespace PululuK\Example\Core;

use PululuK\Example\Adapter\MyClassParamsResolver;
use ReflectionClass;
use ReflectionException;

/**
 *
 */
final class MyClassWrapper
{
    /**
     * Definition methods suffix
     */
    CONST METHOD_DEFINITION_SUFFIX = '_definition';

    /**
     * @param MyClassInterface $myClass
     * @param bool $debugDefinition
     */
    public function __construct(
        private readonly MyClassInterface $myClass,
        private readonly bool $debugDefinition = true
    ){}

    /**
     * @param $methodName
     * @param array $params
     * @return mixed
     */
    public function __call($methodName, array $params): mixed
    {
        $methodDefinitionName = $methodName.self::METHOD_DEFINITION_SUFFIX;
        $classDefinition = $this->myClass->getDefinition();

        if ($classDefinition) {
            if (method_exists($classDefinition, $methodDefinitionName)) {
                $finalParams = $params[0] ?? [];
                $paramsResolver = new MyClassParamsResolver();
                $paramsResolver = $classDefinition->{$methodDefinitionName}($paramsResolver);
                $paramsResolver->resolve($finalParams);
                return $this->invokeMyClassMethod($methodName, new MyClassParameter($finalParams));
            } else {
                if ($this->debugDefinition) {
                    trigger_error('Missing definition for method '.get_class($this->myClass).'::'.$methodName, E_USER_WARNING);
                }
            }
        } else {
            if ($this->debugDefinition) {
                trigger_error('Missing class ' . get_class($this->myClass) . ' definition');
            }
        }

        return $this->myClass->{$methodName}($params);
    }

    /**
     * @param string $methodName
     * @param MyClassParameterInterface $myClassParameterBag
     * @return mixed
     * @throws ReflectionException
     */
    private function invokeMyClassMethod(string $methodName, MyClassParameterInterface $myClassParameterBag): mixed
    {
        $reflectionClass = new ReflectionClass($this->myClass);
        $reflectionMethod = $reflectionClass->getMethod($methodName);

        if (!$reflectionMethod->isPublic()) {
            $reflectionMethod->setAccessible(true);
        }

        return $reflectionMethod->invoke($this->myClass, $myClassParameterBag);
    }
}
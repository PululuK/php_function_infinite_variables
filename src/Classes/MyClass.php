<?php

declare(strict_types=1);

namespace PululuK\Example\Classes;

use PululuK\Example\Core\MyClassDefinitionInterface;
use PululuK\Example\Core\MyClassInterface;
use PululuK\Example\Core\MyClassParameterInterface;
use PululuK\Example\Definition\MyClassDefinition;

/**
 * MyClass
 */
class MyClass implements MyClassInterface
{
    /**
     * @return MyClassDefinitionInterface|null
     */
    public function getDefinition(): ?MyClassDefinitionInterface
    {
        return new MyClassDefinition();
    }

    /**
     * @param MyClassParameterInterface $myClassParameter
     * @return string[]
     */
    private function create_customer(MyClassParameterInterface $myClassParameter): array
    {
        $firstName = $myClassParameter->get('firstName');
        $lastName = $myClassParameter->get('lastName');
        $brithDayDate = $myClassParameter->get('brithDate');
        $email = $myClassParameter->get('email');
        $enableNewsLetter = $myClassParameter->get('enableNewsLetter');

        return ['//TODO : create customer with data '.json_encode($myClassParameter->getAll())];
    }

    /**
     * @param MyClassParameterInterface $myClassParameter
     * @return string[]
     */
    private function get_customers(MyClassParameterInterface $myClassParameter): array
    {
        $enabledOnly = $myClassParameter->get('enabledOnly');
        $limit = $myClassParameter->get('limit');

        if ($enabledOnly) {
            return ['//TODO : My repository find only enabled customers with limit '.$limit];
        }

        return ['//TODO : My repository find all customers with limit'.$limit];
    }

    /**
     * @param MyClassParameterInterface $myClassParameter
     * @return string[]
     */
    private function get_customer(MyClassParameterInterface $myClassParameter): array
    {
        $idCustomer = $myClassParameter->get('idCustomer');

        return ['//TODO : My repository find customer by ID '.$idCustomer];
    }

}
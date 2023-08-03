<?php

declare(strict_types=1);

namespace PululuK\Example\Definition;

use DateTime;
use InvalidArgumentException;
use PululuK\Example\Adapter\MyClassParamsResolver;
use PululuK\Example\Core\MyClassDefinitionInterface;

class MyClassDefinition implements MyClassDefinitionInterface
{
    const NAME_PATTERN = '/^[A-Za-z\'\- ]{1,}$/';

    /**
     * @param MyClassParamsResolver $classParamsResolver
     * @return MyClassParamsResolver
     */
    public function create_customer_definition(MyClassParamsResolver $classParamsResolver): MyClassParamsResolver
    {
        $classParamsResolver
            ->setRequired('firstName')
            ->setAllowedTypes('firstName', ['string'])
            ->setNormalizer('firstName', function (MyClassParamsResolver $params, string $firstName): string {
                if (!preg_match(self::NAME_PATTERN, $firstName)) {
                    throw new InvalidArgumentException('Invalid customer firstName '.$firstName);
                }

                return $firstName;
            })
        ;

        $classParamsResolver
            ->setRequired('lastName')
            ->setAllowedTypes('lastName', ['string'])
            ->setNormalizer('lastName', function (MyClassParamsResolver $params, string $lastName): string {
                if (!preg_match(self::NAME_PATTERN, $lastName)) {
                    throw new InvalidArgumentException('Invalid customer lastName '.$lastName);
                }

                return $lastName;
            })
        ;

        $classParamsResolver
            ->setRequired('email')
            ->setAllowedTypes('email', ['string'])
            ->setNormalizer('email', function (MyClassParamsResolver $params, string $email): string {
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    throw new InvalidArgumentException('Invalid customer email '.$email);
                }

                return $email;
            })
        ;

        $classParamsResolver
            ->setRequired('brithDate')
            ->setAllowedTypes('brithDate', ['string'])
            ->setNormalizer('brithDate', function (MyClassParamsResolver $params, string $brithDate): string {
                $dateTime = DateTime::createFromFormat('d-m-Y', $brithDate);

                if ($dateTime && $dateTime->format('d-m-Y') === $brithDate) {
                    $minDate = new DateTime('-100 years');
                    $maxDate = new DateTime();

                    if ($dateTime >= $minDate && $dateTime <= $maxDate) {
                        return $brithDate;
                    }
                }

                throw new InvalidArgumentException('Invalid customer brith date '.$brithDate);
            })
        ;

        $classParamsResolver
            ->setDefined('enableNewsLetter')
            ->setDefault('enableNewsLetter', false)
            ->setAllowedTypes('enableNewsLetter', ['bool'])
        ;

        return $classParamsResolver;
    }

    /**
     * @param MyClassParamsResolver $classParamsResolver
     * @return MyClassParamsResolver
     */
    public function get_customer_definition(MyClassParamsResolver $classParamsResolver): MyClassParamsResolver
    {
        return $classParamsResolver
            ->setRequired('idCustomer')
            ->setAllowedTypes('idCustomer', ['int'])
        ;
    }

    /**
     * @param MyClassParamsResolver $classParamsResolver
     * @return MyClassParamsResolver
     */
    public function get_customers_definition(MyClassParamsResolver $classParamsResolver): MyClassParamsResolver
    {
        $classParamsResolver
            ->setDefined('enabledOnly')
            ->setDefault('enabledOnly', true)
            ->setAllowedTypes('enabledOnly', ['bool'])
        ;

        $classParamsResolver
            ->setDefined('limit')
            ->setDefault('limit', null)
            ->setAllowedTypes('limit', ['int', 'null'])
        ;

        return $classParamsResolver;
    }
}
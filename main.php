<?php

require_once __DIR__.'/vendor/autoload.php';

use PululuK\Example\Classes\MyClass;
use PululuK\Example\Core\MyClassWrapper;

$myClas = new MyClass();
$myClasWrapper = new MyClassWrapper($myClas);

$result1 = $myClasWrapper->get_customer(['idCustomer' => 1]);
$result2 = $myClasWrapper->get_customers([
    'enabledOnly' => true,
    'limit' => 10
]);

$result3 = $myClasWrapper->create_customer([
    'firstName' => 'PululuK',
    'lastName' => 'KA',
    'brithDate' => '23-10-19938',
    'email' => 'test@test.com',
    'enableNewsLetter' => true,
]);

print_r($result1);
print_r($result2);
print_r($result3);
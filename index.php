<?php
/**
 * Автор: Николайчев Павел
 *
 * Дата реализации: 30.04.2022 20:00
 *
 * Дата изменения: 30.04.2022 22:00
 */
require_once 'DataBase.php';
require_once 'Person.php';
require_once 'PersonArray.php';

$person1 = new Person(id: 1, name: 'John');
$person2 = new Person(id: 210, name: 'Peter', city_of_birth: 'Berlin');
//var_dump($person1);

$persons = new PersonArray([['name' => '= John', 'surname' => '!= Zunneli'], ['city_of_birth' => '< Berlin']]);
var_dump($persons);
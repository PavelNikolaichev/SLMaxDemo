<?php
/**
 * Автор: Николайчев Павел
 *
 * Дата реализации: 30.04.2022 10:00
 *
 * Дата изменения: 30.04.2022 19:15
 *
 * TODO:
 * - Constructor method. Class needs to have array of `id`.
 * - Add method `getPersons`. It should return array of `Person` objects.
 * - Add method `deletePersons`. It should delete persons from db using method of `Person` class.
 */

/**
 * Class PersonArray that is used to store array of `Person` id's.
 * $persons - array of `Person` id's.
 */

require_once 'DataBase.php';

class PersonArray
{
    private array $persons;

    /**
     * PersonArray constructor.
     * @param array $persons - array of `Person` attributes to find. Conditions should be paired with attribute.<br/>
     * Example: array('id' => ['>', 1], 'name' => ['!=', 'John'], ...)
     */
    public function __construct(array $persons)
    {
        throw new Exception('Not implemented yet.');
    }

    final public function getPersons(): array
    {
        $persons = [];
        foreach ($this->persons as $person) {
            $persons[] = new Person($person);
        }
        return $persons;
    }

    final public function deletePersons(): void
    {
        foreach ($this->persons as $person) {
            $person = new Person($person['id']);
            $person->delete();
        }
    }
}
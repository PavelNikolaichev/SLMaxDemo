<?php
/**
 * Автор: Николайчев Павел
 *
 * Дата реализации: 30.04.2022 10:00
 *
 * Дата изменения: 30.04.2022 19:15
 *
 * TODO:
 * [+] Constructor method. Class needs to have array of `id`. EDIT: Need to make comparisons support. Probably need to use regex to do that.
 * [+] Add method `getPersons`. It should return array of `Person` objects.
 * [+] Add method `deletePersons`. It should delete persons from db using method of `Person` class.
 */

/**
 * Class PersonArray that is used to store array of `Person` id's.
 * $persons - array of `Person` id's.
 */
class PersonArray
{
    private array $persons;

    /**
     * PersonArray constructor.
     * @param array $persons - array of `Person` attributes to find. Conditions should be paired with attribute.<br/>
     * Attributes should be in format: `[attribute => value]`.<br/>
     * Example: [['name' => 'John', 'surname' => 'Doe', ...], ['name' => 'Jane', 'surname' => 'Doe', ...]]
     */
    public function __construct(array $persons)
    {
        if (class_exists('Person')) {
            $pdo = DataBase::getConnection();

            foreach ($persons as $person) {
                $person_id = $this->findPerson($person, $pdo);

                if ($person_id) {
                    $this->persons[] = $person_id['player_id'];
                }
            }
        } else {
            throw new RuntimeException('Class `Person` not found.');
        }
    }

    /**
     * Method that returns array of `Person` objects.
     * @return array - array of `Person` objects.
     */
    final public function getPersons(): array
    {
        $persons = [];

        foreach ($this->persons as $person) {
            $persons[] = new Person($person);
        }

        return $persons;
    }

    /**
     * Method that deletes persons from db using method of `Person` class.
     * @return void
     */
    final public function deletePersons(): void
    {
        foreach ($this->persons as $person) {
            $person = new Person($person['id']);

            $person->delete();
        }
    }

    /**
     * @param mixed $person - array of `Person` attributes to find. Conditions should be paired with attribute.<br/>
     * @param mixed $pdo - PDO connection.
     * @return mixed - array of `Person` attributes.
     */
    private function findPerson(mixed $person, PDO $pdo): mixed
    {
        $args = [];
        $keys = [];

        $sql = 'SELECT player_id FROM Players WHERE ';

        foreach ($person as $key => $value) {
            $key_arr = explode(' ', $value);
            switch ($key_arr[0]) {
                case '=':
                    $args[] = "`$key` = :$key";
                    break;
                case '>':
                    $args[] = "`$key` > :$key";
                    break;
                case '<':
                    $args[] = "`$key` < :$key";
                    break;
                case '!=':
                    $args[] = "`$key` != :$key";
                    break;
            }

            $keys[$key] = $key_arr[1];
        }

        $sql .= implode(' AND ', $args) . ' LIMIT 1';

        $stmt = $pdo->prepare($sql);
        $stmt->execute($keys);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
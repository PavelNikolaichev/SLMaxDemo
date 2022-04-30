<?php
/**
 * Автор: Николайчев Павел
 *
 * Дата реализации: 27.04.2022 18:00
 *
 * Дата изменения: 30.04.2022 19:00
 */

require_once 'DataBase.php';

/**
 * Person class that is used to communicate with the database.<br/>
 * $id - id of the person in the database.<br/>
 * $name - name of the person.<br/>
 * $surname - surname of the person.<br/>
 * $birth_date - date of birth of the person.<br/>
 * $gender - gender of the person.<br/>
 * $city_of_birth - city of birth of the person.
 */
Class Person
{
    private int $id;
    private string $name;
    private string $surname;
    private string $birth_date;
    private int $gender;
    private string $city_of_birth;

    /**
     * Creates a Person instance representing a connection to a database.<br/>
     * If `id` is already exists in db all data will be fetched from this row then.
     * Otherwise, a new row will be created.
     * @param int $id - id of the player, may be used to fetch data from db.
     * @param string $name - name of the player.
     * @param string $surname - surname of the player.
     * @param string $birth_date - date of birth of the player.
     * @param int $gender - gender of the player.
     * @param string $city_of_birth - city of birth of the player.
     */
    public function __construct(int $id, string $name, string $surname,
        string $birth_date, int $gender, string $city_of_birth
    ) {
        $pdo = DataBase::getConnection();

        $sql = 'SELECT * FROM Players WHERE player_id=:id LIMIT 1';
        $sql = $pdo->prepare($sql);
        $sql->execute(['id' => $id]);
        $result = $sql->fetch(PDO::FETCH_ASSOC);

        // I should think about using stdClass instead of array.
        if ($result) {
            $this->id = $result['player_id'];
            $this->name = $result['name'];
            $this->surname = $result['surname'];
            $this->birth_date = $result['birth_date'];
            $this->gender = $result['gender'];
            $this->city_of_birth = $result['city_of_birth'];
        }
        else
        {
            $this->id = $id;
            $this->name = $name;
            $this->surname = $surname;
            $this->birth_date = $birth_date;
            $this->gender = $gender;
            $this->city_of_birth = $city_of_birth;

            $this->save();
        }
    }

    /**
     * Method to save obj into `Players` table in db.
     * @return void
     */
    final public function save(): void
    {
        $pdo = DataBase::getConnection();

        $sql = 'INSERT INTO Players VALUES (:id, :name, :surname, :birth_date, :gender, :city_of_birth)';

        $sql = $pdo->prepare($sql);

        $sql->execute(get_object_vars($this));
    }

    /**
     * Method to delete row from db.
     * @return void
     */
    final public function delete(): void
    {
        $pdo = DataBase::getConnection();

        $sql = 'DELETE FROM Players WHERE player_id=:id';
        $sql = $pdo->prepare($sql);

        $sql->execute([
            'id' => $this->id
        ]);
    }

    /**
     * Method to convert date of birth to age.
     * @param string $date - date of birth.
     * @return int - age.
     */
    public static function convertDateOfBirth(string $date): int
    {
        return date_diff(date_create($date), date_create('now'))->y;
    }

    /**
     * Method to convert gender into readable/human format. Made for version 8.0, in PHP-8.1 ENUM is preferable.
     * @param int $gender - gender enum(0 - male, 1 - female).
     * @return string - string that contains converted gender.
     */
    public static function convertGender(int $gender): string
    {
        return $gender === 1 ? 'female' : 'male';
    }

    /**
     * Method that returns converted object as stdClass.
     * @return stdClass - converted object.
     */
    final public function getConverted(): stdClass
    {
        $converted = (object) get_object_vars($this);
        $converted->age = self::convertDateOfBirth($this->birth_date);
        $converted->gender = self::convertGender($this->gender);

        return $converted;
    }
}
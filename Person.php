/**
* Автор: Николайчев Павел
*
* Дата реализации: 27.04.2022 18:00
*
* Дата изменения: 27.04.2022 18:00
*
*
* TODO:
* Create a Class for the `Person` table in database:
*  Fields: id, name, surname, birth_date, gender(enum), city of birth.
*  Class methods:
*   Save class instance data to DB.
*   Delete `Person` from DB with `id`(don't forget about data validation!).
*   Static method to convert date of birth to age.
*   Static method to convert gender from enum(0 - male, 1 - female).
*   Class constructor that creates a new row into DB or fetches data from DB if `id` is provided(don't forget about data validation!).
*   Format Person fields by using static methods(returns new instance of StdClass with fields of the parent).
*/
<?php

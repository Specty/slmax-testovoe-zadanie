<?php
require_once 'db_config.php';

class Person
{
    private $id;
    private $firstName;
    private $lastName;
    private $bDay;
    private $gender;
    private $city;

    private $dbCon;

    public function __construct($id = null, $firstName = null, $lastName = null, $bDay = null, $gender = null, $city = null)
    {
        $this->dbCon = new DBConnect();
        $this->dbCon = $this->dbCon->getConnection();
        if ($id !== null) {
            // Load person from database by ID
            $this->loadFromDatabase($id);
        } else {
            // Create a new person with the given information
            if(!ctype_alpha($firstName) || $firstName === null)
            {
                throw new Exception('Name is invalid.');
            }
            if(!ctype_alpha($lastName) || $lastName === null)
            {
                throw new Exception('Last name is invalid.');
            }
            $regex = '/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/';
            if(!preg_match($regex, $bDay) || $bDay === null)
            {
                throw new Exception('Date is invalid.');
            }
            $regex = '/^[0-1]{1}$/';
            if(!preg_match($regex, $gender) || $gender === null)
            {
                throw new Exception('Gender is invalid.');
            }
            if($city == '' || $city === null)
            {
                throw new Exception('City is invalid.');
            }
            $this->firstName = $firstName;
            $this->lastName = $lastName;
            $this->bDay = $bDay;
            $this->gender = $gender;
            $this->city = $city;
        }
    }

    private function loadFromDatabase($id)
    {
        $stmt = $this->dbCon->prepare("SELECT id, first_name, last_name, bDay, gender, city FROM people WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($this->id, $this->firstName, $this->lastName, $this->bDay, $this->gender, $this->city);
        $stmt->fetch();
        $stmt->close();
    }

    //save person to DB
    public function save()
    {
        if ($this->id === null) {
            $stmt = $this->dbCon->prepare("INSERT INTO people (first_name, last_name, bDay, gender, city) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssis", $this->firstName, $this->lastName, $this->bDay, $this->gender, $this->city);
        } else {
            $stmt = $this->dbCon->prepare("UPDATE people SET first_name = ?, last_name = ?, bDay = ?, gender = ?, city = ? WHERE id = ?");
            $stmt->bind_param("sssisi", $this->firstName, $this->lastName, $this->bDay, $this->gender, $this->city, $this->id);
        }
        $stmt->execute();
        if ($this->id === null) {
            $this->id = $this->dbCon->insert_id;
        }
        $stmt->close();
    }

    //delete person by ID
    public function delete()
    {
        $stmt = $this->dbCon->prepare("DELETE FROM people WHERE id = ?");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $stmt->close();
    }

    // convert birthday to age
    public static function bDayToAge($bDay)
    {
        $localBDay = DateTime::createFromFormat('Y-m-d', $bDay);
        $now = new DateTime();
        $interval = $now->diff($localBDay);
        return $interval->y;
    }

    // convert gender (0-1) to text (m-f)
    public static function genderToText($gender)
    {
        return $gender === 0 ? 'male' : 'female';
    }

    //format person using params
    public function format($convertAge = false, $convertGender = false)
    {
        $formattedPerson = new stdClass();
        $formattedPerson->id = $this->id;
        $formattedPerson->firstName = $this->firstName;
        $formattedPerson->lastName = $this->lastName;
        $formattedPerson->bDay = $convertAge ? self::bDayToAge($this->bDay) : $this->bDay;
        $formattedPerson->gender = $convertGender ? self::genderToText($this->gender) : $this->gender;
        $formattedPerson->city = $this->city;

        return $formattedPerson;
    }
}
?>
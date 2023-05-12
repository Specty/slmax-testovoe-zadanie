<?php
// Basically test if file is present
require_once 'Person.php';
require_once 'db_config.php';

class PeopleManager {
    private $peopleIds;
    private $dbCon;

    //get ids by condition
    public function __construct($condition) {
        $this->dbCon = new DBConnect();
        $this->dbCon = $this->dbCon->getConnection();
        $this->peopleIds = array();

        $sql = "SELECT id FROM people WHERE $condition";
        $result = $this->dbCon->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($this->peopleIds, $row['id']);
            }
        }
    }

    // get instances of People class by their ids
    public function getPeopleInstances() {
        $peopleInstances = array();
        foreach ($this->peopleIds as $id) {
            array_push($peopleInstances, new Person($id));
        }
        return $peopleInstances;
    }

    // remove ppl from DB
    public function deletePeople() {
        foreach ($this->peopleIds as $id) {
            $person = new Person($id);
            $person->delete();
        }
    }
}
?>
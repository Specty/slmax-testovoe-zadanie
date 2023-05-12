<?php
require_once 'Person.php';
require_once 'PeopleManager.php';

//TEST Person class
echo '===Testing class Person===' . PHP_EOL;

// Test data validation
try
{
    $failedPerson = new Person(null, 'Aboba123', 'GoodOne', '2005-10-20', 0, 'SampleCity');
} catch (Exception $e) {
    echo 'Caught exception: ' . $e->getMessage() . PHP_EOL;
}
try
{
    $failedPerson = new Person(null, 'Aboba', 'NotGood123', '2005-10-20', 0, 'SampleCity');
} catch (Exception $e) {
    echo 'Caught exception: ' . $e->getMessage() . PHP_EOL;
}
try
{
    $failedPerson = new Person(null, 'Aboba', 'GoodOne', '20055-10-20', 0, 'SampleCity');
} catch (Exception $e) {
    echo 'Caught exception: ' . $e->getMessage() . PHP_EOL;
}
try
{
    $failedPerson = new Person(null, 'Aboba', 'GoodOne', '2005-10-20', 5, 'SampleCity');
} catch (Exception $e) {
    echo 'Caught exception: ' . $e->getMessage() . PHP_EOL;
}
try
{
    $failedPerson = new Person(null, 'Aboba', 'GoodOne', '2005-10-20', 0, '');
} catch (Exception $e) {
    echo 'Caught exception: ' . $e->getMessage() . PHP_EOL;
}

//
// Test creating a new person and saving it to the database
// firstName, secondName, bday (YYYY-MM-DD), gender (1-0), city
$person = new Person(null, 'Somename', 'Whatever', '1985-06-15', 0, 'Minsk');
$person->save();
echo "New person created with ID: " . $person->format()->id . PHP_EOL;

//
$secondPerson = new Person(null, 'Specty', 'Soul', '1990-01-05', 1, 'Mogilev');
$secondPerson->save();
echo "New person created with ID: " . $secondPerson->format()->id . PHP_EOL;

// Use the genderToText static method
$genderText = Person::genderToText($secondPerson->format()->gender);
echo "Gender as text: " . $genderText . PHP_EOL;

// Use the dateOfBirthToAge static method
$age = Person::bDayToAge($secondPerson->format()->bDay);
echo "Age: " . $age . " years" . PHP_EOL;

// Use the format method to convert gender and age
$formattedPerson = $secondPerson->format(true, true);
echo "Formatted person: " . json_encode($formattedPerson) . PHP_EOL;

// Test loading a person from the database by ID
$loadedPerson = new Person(1);
echo "Loaded person: " . json_encode($loadedPerson->format()) . PHP_EOL;

// Test deleting person from the database
$loadedPerson->delete();
echo "Person with id " . json_encode($loadedPerson->format()->id) . " was deleted." . PHP_EOL;

$needToFillDBaBit = new Person(null, 'Test', 'Subject', '1995-05-07', 1, 'Mogilev');
$needToFillDBaBit->save();
$needToFillDBaBit = new Person(null, 'Starwind', 'Soul', '1985-08-10', 1, 'Minsk');
$needToFillDBaBit->save();
$needToFillDBaBit = new Person(null, 'Wicked', 'Whim', '2000-06-20', 0, 'CitySeventeen');
$needToFillDBaBit->save();
$needToFillDBaBit = new Person(null, 'ICantComeUpWithName', 'AndLastNameToo', '1951-02-11', 0, 'SampleCity');
$needToFillDBaBit->save();
$needToFillDBaBit = new Person(null, 'Hello', 'There', '1955-12-25', 1, 'Pogtopia');
$needToFillDBaBit->save();
echo PHP_EOL;
//TEST PeopleManager class
echo '===Testing class PeopleManager===' . PHP_EOL;
// Example 1: Find all people with gender = 1 and birthday before 1992-01-01
$peopleManager1 = new PeopleManager("gender = 1 AND bDay < '1992-01-01'");
$peopleInstances1 = $peopleManager1->getPeopleInstances();
echo "Example 1: People with gender = 1 and birthday before 1992-01-01:" . PHP_EOL;
foreach ($peopleInstances1 as $person) {
    echo json_encode($person->format(true, true)) . PHP_EOL;
}

// Example 2: Find all people with the last name 'Soul'
$peopleManager2 = new PeopleManager("last_name = 'Soul'");
$peopleInstances2 = $peopleManager2->getPeopleInstances();

echo "Example 2: People with the last name 'Soul':" . PHP_EOL;
foreach ($peopleInstances2 as $person) {
    echo json_encode($person->format(true, true)) . PHP_EOL;
}

// Example 3: Delete all people with the city 'Mogilev'
$peopleManager3 = new PeopleManager("city = 'Mogilev'");
$peopleInstances3 = $peopleManager3->getPeopleInstances();

echo "Example 3: Deleting people with the city 'Mogilev':" . PHP_EOL;
foreach ($peopleInstances3 as $person) {
    echo "Deleting: " . json_encode($person->format(true, true)) . PHP_EOL;
}
$peopleManager3->deletePeople();
echo "People deleted." . PHP_EOL;

?>
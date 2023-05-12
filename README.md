# slmax-testovoe-zadanie
Example of output from index.php:

===Testing class Person===\
Caught exception: Name is invalid.
Caught exception: Last name is invalid.
Caught exception: Date is invalid.
Caught exception: Gender is invalid.
Caught exception: City is invalid.
New person created with ID: 1
New person created with ID: 2
Gender as text: female
Age: 33 years
Formatted person: {"id":2,"firstName":"Specty","lastName":"Soul","bDay":33,"gender":"female","city":"Mogilev"}
Loaded person: {"id":1,"firstName":"Somename","lastName":"Whatever","bDay":"1985-06-15","gender":0,"city":"Minsk"}
Person with id 1 was deleted.

===Testing class PeopleManager===
Example 1: People with gender = 1 and birthday before 1992-01-01:
{"id":2,"firstName":"Specty","lastName":"Soul","bDay":33,"gender":"female","city":"Mogilev"}
{"id":4,"firstName":"Starwind","lastName":"Soul","bDay":37,"gender":"female","city":"Minsk"}
{"id":7,"firstName":"Hello","lastName":"There","bDay":67,"gender":"female","city":"Pogtopia"}
Example 2: People with the last name 'Soul':
{"id":2,"firstName":"Specty","lastName":"Soul","bDay":33,"gender":"female","city":"Mogilev"}
{"id":4,"firstName":"Starwind","lastName":"Soul","bDay":37,"gender":"female","city":"Minsk"}
Example 3: Deleting people with the city 'Mogilev':
Deleting: {"id":2,"firstName":"Specty","lastName":"Soul","bDay":33,"gender":"female","city":"Mogilev"}
Deleting: {"id":3,"firstName":"Test","lastName":"Subject","bDay":28,"gender":"female","city":"Mogilev"}
People deleted.

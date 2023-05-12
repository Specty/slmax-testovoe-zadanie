<?php
class DBConnect
{
    const SERVER_NAME = "localhost";
    const USERNAME = "username";
    const PASSWORD = "password";
    const DB_NAME = "dbTest";
    const TABLE_NAME = "tableName";

    private static $conn;

    public function getConnection(): mysqli
    {
        if (is_null(self::$conn)) {
            self::$conn = $this->connect();
        }
        return self::$conn;
    }

    public function connect(): mysqli
    {
        try {
            return mysqli_connect(self::SERVER_NAME, self::USERNAME, self::PASSWORD, self::DB_NAME);
        } catch (mysqli_sql_exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
?>
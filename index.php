<?php
class DB
{
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'todoapp';
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function createTable($tableName, $columns)
    {
        $sql = "CREATE TABLE IF NOT EXISTS $tableName ($columns)";
        if ($this->conn->query($sql) === TRUE) {
            echo "Table created successfully";
        } else {
            echo "Error creating table: " . $this->conn->error;
        }
    }

    public function insertData($tableName, $data)
    {
        $values = "'" . implode("','", $data) . "'";
        $sql = "INSERT INTO $tableName VALUES ($values)";
        if ($this->conn->query($sql) === TRUE) {
            echo "Data inserted successfully";
        } else {
            echo "Error inserting data: " . $this->conn->error;
        }
    }

    public function fetchData($tableName, $col = "*", $condition = true)
    {
        $sql = "SELECT $col FROM $tableName WHERE $condition";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function updateData($tableName, $updateValues, $condition)
    {
        $sql = "UPDATE $tableName SET $updateValues WHERE $condition";
        if ($this->conn->query($sql) === TRUE) {
            echo "Data updated successfully";
        } else {
            echo "Error updating data: " . $this->conn->error;
        }
    }
    public function deleteData($tableName, $condition)
    {
        $sql = "DELETE FROM $tableName WHERE $condition";
        if ($this->conn->query($sql) === TRUE) {
            echo "Data deleted successfully";
        } else {
            echo "Error deleting data: " . $this->conn->error;
        }
    }

}

$users = new DB();
var_dump($users->fetchData("tasks"));





// Validation 
class Validation
{
    private $errors = [];

    public function validateName($name)
    {
        $length = strlen($name);
        if (empty($name) || $length < 3 || $length > 25) {
            $this->errors[] = "Name must be between 3 and 25 characters";
            return false;
        }
        return true;
    }

    public function validatePassword($password)
    {
        $length = strlen($password);
        if (empty($password) || $length < 6 || $length > 25) {
            $this->errors[] = "Password must be between 6 and 25 characters";
            return false;
        }
        return true;
    }

    public function validateEmail($email)
    {
        if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "Invalid email address";
            return false;
        }
        return true;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}

$test = new Validation();
$test->validateName("as");
$test->validatePassword("");
$test->validateEmail("aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa");
echo "<br>";
print_r($test->getErrors());
echo "</br>";
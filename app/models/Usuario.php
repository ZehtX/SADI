<?php
require_once "../DB/db_connection.php";
require_once "Inputs.php";

class Usuario
{
    protected $email;
    protected $password;

    public function __construct($email, $password)
    {
        $this->email = clearIn($email);
        $this->password = clearIn($password);
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function validation($pass)
    {
        return password_verify($this->password, $pass);
    }

    public function register()
    {
        global $conn;
        $email = $this->email;
        $password = password_hash($this->password, PASSWORD_DEFAULT);

        $query = "INSERT INTO `usuario` (Correo, Clave) VALUES ('$email', '$password');";
        $result = $conn->query($query);

        return $result;
    }

    public function searchUser()
    {
        global $conn;
        $email = $this->email;

        $query = "SELECT * FROM `usuario` WHERE Correo = '$email';";
        $result = $conn->query($query);

        $array = $result->fetch_assoc();

        if ($result->num_rows == 1) {
            return $array;
        } else {
            return false;
        }
    }
}

<?php

abstract class UserAccount
{
    private $email;
    private $hashedPassword;


    public function login()
    {
    }

    public function validatePassword($password)
    {
        if (empty($password)) {
            return "Please enter a password.";
        } else if (strlen($password) < 8) {
            return "Please enter a password with atleast 8 characters.";
        } elseif (!preg_match("#[0-9]+#", $password)) {
            return "Your Password Must Contain At Least 1 Number!";
        } elseif (!preg_match("#[A-Z]+#", $password)) {
            return "Your Password Must Contain At Least 1 Capital Letter!";
        } elseif (!preg_match("#[a-z]+#", $password)) {
            return "Your Password Must Contain At Least 1 Lowercase Letter!";
        } else {
            $this->hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            return "";
        }
    }

    public function validateEmail($email)
    {
        if (empty($email)) {
            return "Please enter your email address.";
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Please enter a valid email address";
        } else if (!$this->isEmailUnique($email)) {
            return "Email already exist";
        } else {
            $this->email = $email;
            return "";
        }
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getHashedPassword()
    {
        return $this->hashedPassword;
    }


    abstract public function isIdUnique($id);
    abstract public function isEmailUnique($email);
}

class CustomerAccount extends UserAccount
{
    public $conn;

    function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function register($customerId, $firstName, $lastName, $emailAddress, $mobileNumber, $hashedPassword)
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO tbl_customer (customerid, firstname, lastname, email, mobilenumber, password) VALUES (?,?,?,?,?,?)");
            $stmt->bind_param("ssssss", $customerId, $firstName, $lastName, $emailAddress, $mobileNumber, $hashedPassword);
            $stmt->execute();
            $stmt->close();
            header("location: index.php");
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        $this->conn->close();
    }

    public function isIdUnique($customerId)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM tbl_customer WHERE customerid = ?");
            $stmt->bind_param("s", $customerId);

            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $stmt->close();
                return false;
            }
            $stmt->close();
            return true;
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function isEmailUnique($email)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM tbl_customer WHERE email = ?");
            $stmt->bind_param("s", $email);

            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $stmt->close();
                return false;
            }
            $stmt->close();
            return true;
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
}

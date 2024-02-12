<?php

require_once "./class/user_account.php";

class AdminAccount extends UserAccount
{
    public $conn;

    function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function login($email, $password)
    {
        try {

            $stmt = $this->conn->prepare("SELECT * FROM tbl_admin WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $hashedPassword = $row["password"];
                    if (!password_verify($password, $hashedPassword)) {
                        return "Incorrect email or password";
                    } else {
                        session_start();
                        $_SESSION["loggedin"] = true;
                        $_SESSION["customerid"] = $row["customerid"];

                        header("location: ./dashboard.php");
                    }
                }
            } else {
                return "Incorrect email or password";
            }
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function isIdUnique($id)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM tbl_admin WHERE adminid = ?");
            $stmt->bind_param("s", $id);

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
            $stmt = $this->conn->prepare("SELECT * FROM tbl_admin WHERE email = ?");
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


    public function register($adminId, $firstName, $lastName, $emailAddress, $mobileNumber, $hashedPassword)
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO tbl_admin (adminid, firstname, lastname, email, mobilenumber, password) VALUES (?,?,?,?,?,?)");
            $stmt->bind_param("ssssss", $adminId, $firstName, $lastName, $emailAddress, $mobileNumber, $hashedPassword);
            $stmt->execute();
            $stmt->close();
            header("location: dashboard.php");
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        $this->conn->close();
    }
}

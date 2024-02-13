<?php

require_once "user_account.php";

class EmployeeAccount extends UserAccount
{
    public $conn;
    public $type;

    function __construct($conn, $type)
    {
        $this->conn = $conn;
        $this->type = $type;
    }

    public function login($email, $password)
    {
        try {

            $stmt = $this->conn->prepare("SELECT * FROM tbl_employee WHERE email = ?");
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
                        $_SESSION["employeeid"] = $row["employeeid"];
                        $_SESSION["type"] = $row["type"];

                        if ($row["type"] == "supervisor") {
                            header("location: ./dashboard_supervisor.php");
                        } else {
                            header("location: ./dashboard_worker.php");
                        }
                    }
                }
            } else {
                return "Incorrect email or password";
            }
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    // TODO: makapili dapat kung worker or supervisor ang i register
    public function register($customerId, $firstName, $lastName, $emailAddress, $mobileNumber, $hashedPassword)
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO tbl_employee (employeeid, firstname, lastname, email, mobilenumber, password, type) VALUES (?,?,?,?,?,?,?)");
            $stmt->bind_param("sssssss", $customerId, $firstName, $lastName, $emailAddress, $mobileNumber, $hashedPassword, $this->type);
            $stmt->execute();
            $stmt->close();
            header("location: dashboard.php");
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

    public function doesEmailExist($email)
    {
    }

    public function addResetToken($tokenHash, $expiry, $email)
    {
    }

    public function sendForgotPasswordLink($email, $token)
    {
    }

    public function doesTokenExist($tokenHash)
    {
    }
}

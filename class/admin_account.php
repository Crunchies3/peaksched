<?php

require_once "user_account.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/vendor/autoload.php";
$mail = new PHPMailer();

class AdminAccount extends UserAccount
{
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

                        $this->setConn($this->conn);
                        $this->setId($row["adminid"]);
                        $this->setFirstname($row["firstname"]);
                        $this->setLastName($row["lastname"]);
                        $this->setEmail($row["email"]);
                        $this->setMobileNumebr($row["mobilenumber"]);
                        $this->setHashedPassword($row["password"]);

                        $_SESSION["loggedin"] = true;
                        $_SESSION["adminUser"] = serialize($this);

                        header("location: ./dashboard.php");
                        $this->conn->close();
                    }
                }
            } else {
                return "Incorrect email or password";
            }
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function isServiceIdUnique($id)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM tbl_service WHERE service_id = ?");
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

    public function doesEmailExist($email)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM tbl_admin WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 0) {
                return false;
            } else {
                return true;
            }
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function addResetToken($tokenHash, $expiry, $email)
    {
        try {
            $stmt = $this->conn->prepare("UPDATE tbl_admin SET reset_token_hash = ? , reset_token_expires_at = ? WHERE email = ?");
            $stmt->bind_param("sss", $tokenHash, $expiry, $email);
            $stmt->execute();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }


    public function doesTokenExist($tokenHash)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM tbl_admin WHERE reset_token_hash = ?");
            $stmt->bind_param("s", $tokenHash);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 0) {
                return false;
            } else {
                while ($row = $result->fetch_assoc()) {
                    $this->tokenExpiry = $row["reset_token_expires_at"];
                    $this->id = $row["adminid"];
                }
                return true;
            }
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
    public function forgotResetPassword($hashedPassword, $id)
    {
        try {
            $stmt = $this->conn->prepare("UPDATE tbl_admin SET password = ?, reset_token_hash = null, reset_token_expires_at = null WHERE adminid = ?");
            $stmt->bind_param("ss", $hashedPassword, $id);
            $stmt->execute();
            header("location: ./reset_password_success.php");
            $this->conn->close();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
    public function updateUserDetails($newFirstName, $newLastName, $newEmailAddress, $newMobileNumber)
    {

        $adminid = $this->getId();
        try {
            $stmt = $this->conn->prepare("UPDATE tbl_admin SET firstname = ?,lastname = ?,email = ?,mobilenumber = ? WHERE adminid = ?");
            $stmt->bind_param("sssss", $newFirstName, $newLastName, $newEmailAddress, $newMobileNumber, $adminid);
            $stmt->execute();
            $this->conn->close();

            $this->setFirstname($newFirstName);
            $this->setLastName($newLastName);
            $this->setEmail($newEmailAddress);
            $this->setMobileNumebr($newMobileNumber);

            $_SESSION["adminUser"] = serialize($this);
            header("location: ./setting_account_page.php");
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
    public function changeUserPassword($newHashedPassword)
    {
        $adminid = $this->getId();
        try {
            $stmt = $this->conn->prepare("UPDATE tbl_admin SET password = ? WHERE adminid = ?");
            $stmt->bind_param("ss", $newHashedPassword, $adminid);
            $stmt->execute();
            $this->conn->close();
            $this->setHashedPassword($newHashedPassword);

            $_SESSION["adminUser"] = serialize($this);
            header("location: ./setting_account_page.php");
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
}

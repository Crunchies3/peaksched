<?php

require_once "user_account.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/vendor/autoload.php";

$mail = new PHPMailer(true);

class EmployeeAccount extends UserAccount
{
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
                        $this->conn->close();
                        session_start();
                        $this->setConn($this->conn);
                        $this->setId($row["employeeid"]);
                        $this->setFirstname($row["firstname"]);
                        $this->setLastName($row["lastname"]);
                        $this->setEmail($row["email"]);
                        $this->setMobileNumebr($row["mobilenumber"]);
                        $this->setHashedPassword($row["password"]);
                        $this->setType($row["type"]);


                        $_SESSION["loggedin"] = true;
                        $_SESSION["employeeUser"] = serialize($this);

                        if ($row["type"] == "supervisor") {
                            header("location: ./supervisor");
                        } else {
                            header("location: ./worker");
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

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function isIdUnique($employeeId)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM tbl_employee WHERE employeeid = ?");
            $stmt->bind_param("s", $employeeId);

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
            $stmt = $this->conn->prepare("SELECT * FROM tbl_employee WHERE email = ?");
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
        try {
            $stmt = $this->conn->prepare("SELECT * FROM tbl_employee WHERE email = ?");
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
            $stmt = $this->conn->prepare("UPDATE tbl_employee SET reset_token_hash = ? , reset_token_expires_at = ? WHERE email = ?");
            $stmt->bind_param("sss", $tokenHash, $expiry, $email);
            $stmt->execute();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function sendForgotPasswordLink($email, $token)
    {
        global $mail;

        try {
            // TODO: dapat i seperate file ang configure paras Server settings
            //Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'rivals191@gmail.com';
            $mail->Password   = 'iwafeletytquflgl';
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = 465;
            //Recipients
            $mail->setFrom('noreply@gmail.com');
            $mail->addAddress($email);
            //Content
            $mail->isHTML(true);

            $mail->Subject = 'Password Reset';
            $mail->Body    = <<<END
            
            Click <a href="http://localhost/peaksched/employee/reset_password.php?token=$token">here</a>
            to reset your password.

            END;

            $mail->send();
            $this->conn->close();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public function doesTokenExist($tokenHash)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM tbl_employee WHERE reset_token_hash = ?");
            $stmt->bind_param("s", $tokenHash);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 0) {
                return false;
            } else {
                while ($row = $result->fetch_assoc()) {
                    $this->tokenExpiry = $row["reset_token_expires_at"];
                    $this->id = $row["employeeid"];
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
            $stmt = $this->conn->prepare("UPDATE tbl_employee SET password = ?, reset_token_hash = null, reset_token_expires_at = null WHERE employeeid = ?");
            $stmt->bind_param("ss", $hashedPassword, $id);
            $stmt->execute();
            header("location: ./reset_password_success.php");
            $this->conn->close();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function changeUserPassword($newHashedPassword)
    {
        $employeeId = $this->getId();
        try {
            $stmt = $this->conn->prepare("UPDATE tbl_employee SET password = ? WHERE employeeid = ?");
            $stmt->bind_param("ss", $newHashedPassword, $employeeId);
            $stmt->execute();
            $this->conn->close();
            $this->setHashedPassword($newHashedPassword);

            $_SESSION["employeeUser"] = serialize($this);

            if ($this->type == "supervisor") {
                header("location: ./");
            } else {
                header("location: ./");
            }
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function updateUserDetails($newFirstName, $newLastName, $newEmailAddress, $newMobileNumber)
    {
        $employeeId = $this->getId();
        try {
            $stmt = $this->conn->prepare("UPDATE tbl_employee SET firstname = ?,lastname = ?,email = ?,mobilenumber = ? WHERE employeeid = ?");
            $stmt->bind_param("sssss", $newFirstName, $newLastName, $newEmailAddress, $newMobileNumber, $employeeId);
            $stmt->execute();
            $this->conn->close();

            $this->setFirstname($newFirstName);
            $this->setLastName($newLastName);
            $this->setEmail($newEmailAddress);
            $this->setMobileNumebr($newMobileNumber);

            $_SESSION["employeeUser"] = serialize($this);
            if ($this->type == "supervisor") {
                header("location: ./");
            } else {
                header("location: ./");
            }
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
}

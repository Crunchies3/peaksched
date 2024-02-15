<?php

require_once "user_account.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/vendor/autoload.php";
//Load Composer's autoloader
$mail = new PHPMailer(true);

class CustomerAccount extends UserAccount
{

    function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function login($email, $password)
    {
        try {

            $stmt = $this->conn->prepare("SELECT * FROM tbl_customer WHERE email = ?");
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

                        $customerAccount = new CustomerAccount($this->conn);

                        $customerAccount->setId($row["customerid"]);
                        $customerAccount->setFirstname($row["firstname"]);
                        $customerAccount->setLastName($row["lastname"]);
                        $customerAccount->setEmail($row["email"]);
                        $customerAccount->setMobileNumebr($row["mobilenumber"]);
                        $customerAccount->setHashedPassword($row["password"]);



                        $_SESSION["loggedin"] = true;
                        $_SESSION["customerUser"] = serialize($customerAccount);

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


    public function register($customerId, $firstName, $lastName, $emailAddress, $mobileNumber, $hashedPassword)
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO tbl_customer (customerid, firstname, lastname, email, mobilenumber, password) VALUES (?,?,?,?,?,?)");
            $stmt->bind_param("ssssss", $customerId, $firstName, $lastName, $emailAddress, $mobileNumber, $hashedPassword);
            $stmt->execute();
            $stmt->close();
            header("location: dashboard.php");
            $this->conn->close();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
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
        try {
            $stmt = $this->conn->prepare("SELECT * FROM tbl_customer WHERE email = ?");
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
            $stmt = $this->conn->prepare("UPDATE tbl_customer SET reset_token_hash = ? , reset_token_expires_at = ? WHERE email = ?");
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
            
            Click <a href="http://localhost/peaksched/client_customer/reset_password.php?token=$token">here</a>
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
            $stmt = $this->conn->prepare("SELECT * FROM tbl_customer WHERE reset_token_hash = ?");
            $stmt->bind_param("s", $tokenHash);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 0) {
                return false;
            } else {
                while ($row = $result->fetch_assoc()) {
                    $this->tokenExpiry = $row["reset_token_expires_at"];
                    $this->id = $row["customerid"];
                }
                return true;
            }
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }


    //TODO: ibutang sa abstract 
    public function forgotResetPassword($hashedPassword, $id)
    {
        try {
            $stmt = $this->conn->prepare("UPDATE tbl_customer SET password = ?, reset_token_hash = null, reset_token_expires_at = null WHERE customerid = ?");
            $stmt->bind_param("ss", $hashedPassword, $id);
            $stmt->execute();
            header("location: ./reset_password_success.php");
            $this->conn->close();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
}

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

    public function sendForgotPasswordLink($email, $token)
    {
        global $mail;

        // try {
        //     // TODO: dapat i seperate file ang configure paras Server settings
        //     //Server settings
        //     $mail->isSMTP();
        //     $mail->Host       = 'smtp.gmail.com';
        //     $mail->SMTPAuth   = true;
        //     $mail->Username   = 'rivals191@gmail.com';
        //     $mail->Password   = 'iwafeletytquflgl';
        //     $mail->SMTPSecure = 'ssl';
        //     $mail->Port       = 587;
        //     //Recipients
        //     $mail->setFrom('noreply@gmail.com');
        //     $mail->addAddress($email);
        //     //Content
        //     $mail->isHTML(true);

        //     $mail->Subject = 'Password Reset';
        //     $mail->Body    = <<<END

        //     <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
        //     <html>

        //     <head>
        //     <!-- Compiled with Bootstrap Email version: 1.3.1 -->
        //     <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        //     <meta http-equiv="x-ua-compatible" content="ie=edge">
        //     <meta name="x-apple-disable-message-reformatting">
        //     <meta name="viewport" content="width=device-width, initial-scale=1">
        //     <meta name="format-detection" content="telephone=no, date=no, address=no, email=no">
        //     <style type="text/css">
        //         body,
        //         table,
        //         td {
        //         font-family: Helvetica, Arial, sans-serif !important
        //         }

        //         .ExternalClass {
        //         width: 100%
        //         }

        //         .ExternalClass,
        //         .ExternalClass p,
        //         .ExternalClass span,
        //         .ExternalClass font,
        //         .ExternalClass td,
        //         .ExternalClass div {
        //         line-height: 150%
        //         }

        //         a {
        //         text-decoration: none
        //         }

        //         * {
        //         color: inherit
        //         }

        //         a[x-apple-data-detectors],
        //         u+#body a,
        //         #MessageViewBody a {
        //         color: inherit;
        //         text-decoration: none;
        //         font-size: inherit;
        //         font-family: inherit;
        //         font-weight: inherit;
        //         line-height: inherit
        //         }

        //         img {
        //         -ms-interpolation-mode: bicubic
        //         }

        //         table:not([class^=s-]) {
        //         font-family: Helvetica, Arial, sans-serif;
        //         mso-table-lspace: 0pt;
        //         mso-table-rspace: 0pt;
        //         border-spacing: 0px;
        //         border-collapse: collapse
        //         }

        //         table:not([class^=s-]) td {
        //         border-spacing: 0px;
        //         border-collapse: collapse
        //         }

        //         @media screen and (max-width: 600px) {

        //         .w-full,
        //         .w-full>tbody>tr>td {
        //             width: 100% !important
        //         }

        //         .w-24,
        //         .w-24>tbody>tr>td {
        //             width: 96px !important
        //         }

        //         .w-40,
        //         .w-40>tbody>tr>td {
        //             width: 160px !important
        //         }

        //         .p-lg-10:not(table),
        //         .p-lg-10:not(.btn)>tbody>tr>td,
        //         .p-lg-10.btn td a {
        //             padding: 0 !important
        //         }

        //         .p-3:not(table),
        //         .p-3:not(.btn)>tbody>tr>td,
        //         .p-3.btn td a {
        //             padding: 12px !important
        //         }

        //         .p-6:not(table),
        //         .p-6:not(.btn)>tbody>tr>td,
        //         .p-6.btn td a {
        //             padding: 24px !important
        //         }

        //         *[class*=s-lg-]>tbody>tr>td {
        //             font-size: 0 !important;
        //             line-height: 0 !important;
        //             height: 0 !important
        //         }

        //         .s-4>tbody>tr>td {
        //             font-size: 16px !important;
        //             line-height: 16px !important;
        //             height: 16px !important
        //         }

        //         .s-6>tbody>tr>td {
        //             font-size: 24px !important;
        //             line-height: 24px !important;
        //             height: 24px !important
        //         }

        //         .s-10>tbody>tr>td {
        //             font-size: 40px !important;
        //             line-height: 40px !important;
        //             height: 40px !important
        //         }
        //         }
        //     </style>
        //     </head>

        //     <body class="bg-light"
        //     style="outline: 0; width: 100%; min-width: 100%; height: 100%; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 24px; font-weight: normal; font-size: 16px; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; color: #000000; margin: 0; padding: 0; border-width: 0;"
        //     bgcolor="#f7fafc">
        //     <table class="bg-light body" valign="top" role="presentation" border="0" cellpadding="0" cellspacing="0"
        //         style="outline: 0; width: 100%; min-width: 100%; height: 100%; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 24px; font-weight: normal; font-size: 16px; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; color: #000000; margin: 0; padding: 0; border-width: 0;"
        //         bgcolor="#f7fafc">
        //         <tbody>
        //         <tr>
        //             <td valign="top" style="line-height: 24px; font-size: 16px; margin: 0;" align="left" bgcolor="#f7fafc">
        //             <table class="container" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
        //                 <tbody>
        //                 <tr>
        //                     <td align="center" style="line-height: 24px; font-size: 16px; margin: 0; padding: 0 16px;">
        //                     <!--[if (gte mso 9)|(IE)]>
        //                         <table align="center" role="presentation">
        //                             <tbody>
        //                             <tr>
        //                                 <td width="600">
        //                         <![endif]-->
        //                     <table align="center" role="presentation" border="0" cellpadding="0" cellspacing="0"
        //                         style="width: 100%; max-width: 600px; margin: 0 auto;">
        //                         <tbody>
        //                         <tr>
        //                             <td style="line-height: 24px; font-size: 16px; margin: 0;" align="left">
        //                             <table class="s-10 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0"
        //                                 style="width: 100%;" width="100%">
        //                                 <tbody>
        //                                 <tr>
        //                                     <td style="line-height: 40px; font-size: 40px; width: 100%; height: 40px; margin: 0;"
        //                                     align="left" width="100%" height="40">
        //                                     &#160;
        //                                     </td>
        //                                 </tr>
        //                                 </tbody>
        //                             </table>
        //                             <table class="ax-center" role="presentation" align="center" border="0" cellpadding="0"
        //                                 cellspacing="0" style="margin: 0 auto;">
        //                                 <tbody>
        //                                 <tr>
        //                                     <td style="line-height: 24px; font-size: 16px; margin: 0;" align="left">
        //                                     <img class="w-24" src="https://i.ibb.co/TMZ5tfz/5-1.png"
        //                                         style="height: auto; line-height: 100%; outline: none; text-decoration: none; display: block; width: 96px; border-style: none; border-width: 0;"
        //                                         width="96">
        //                                     </td>
        //                                 </tr>
        //                                 </tbody>
        //                             </table>
        //                             <table class="s-10 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0"
        //                                 style="width: 100%;" width="100%">
        //                                 <tbody>
        //                                 <tr>
        //                                     <td style="line-height: 40px; font-size: 40px; width: 100%; height: 40px; margin: 0;"
        //                                     align="left" width="100%" height="40">
        //                                     &#160;
        //                                     </td>
        //                                 </tr>
        //                                 </tbody>
        //                             </table>
        //                             <table class="card p-6 p-lg-10 space-y-4" role="presentation" border="0" cellpadding="0"
        //                                 cellspacing="0"
        //                                 style="border-radius: 6px; border-collapse: separate !important; width: 100%; overflow: hidden; border: 1px solid #e2e8f0;"
        //                                 bgcolor="#ffffff">
        //                                 <tbody>
        //                                 <tr>
        //                                     <td style="line-height: 24px; font-size: 16px; width: 100%; margin: 0; padding: 40px;"
        //                                     align="left" bgcolor="#ffffff">
        //                                     <h1 class="h3 fw-700"
        //                                         style="padding-top: 0; padding-bottom: 0; font-weight: 700 !important; vertical-align: baseline; font-size: 28px; line-height: 33.6px; margin: 0;"
        //                                         align="left">
        //                                         Password Change Request
        //                                     </h1>
        //                                     <table class="s-4 w-full" role="presentation" border="0" cellpadding="0"
        //                                         cellspacing="0" style="width: 100%;" width="100%">
        //                                         <tbody>
        //                                         <tr>
        //                                             <td
        //                                             style="line-height: 16px; font-size: 16px; width: 100%; height: 16px; margin: 0;"
        //                                             align="left" width="100%" height="16">
        //                                             &#160;
        //                                             </td>
        //                                         </tr>
        //                                         </tbody>
        //                                     </table>
        //                                     <p class="" style="line-height: 24px; font-size: 16px; width: 100%; margin: 0;"
        //                                         align="left">
        //                                         We've received a password change request for your Twin Peaks account.
        //                                         This link will expire in 30 minutes. If you did not request a password change, please ignore this email, no changes will be made to your account. 
        //                                     </p>
        //                                     <table class="s-4 w-full" role="presentation" border="0" cellpadding="0"
        //                                         cellspacing="0" style="width: 100%;" width="100%">
        //                                         <tbody>
        //                                         <tr>
        //                                             <td
        //                                             style="line-height: 16px; font-size: 16px; width: 100%; height: 16px; margin: 0;"
        //                                             align="left" width="100%" height="16">
        //                                             &#160;
        //                                             </td>
        //                                         </tr>
        //                                         </tbody>
        //                                     </table>
        //                                     <table class="btn btn-primary p-3 fw-700" role="presentation" border="0"
        //                                         cellpadding="0" cellspacing="0"
        //                                         style="border-radius: 6px; border-collapse: separate !important; font-weight: 700 !important;">
        //                                         <tbody>
        //                                         <tr>
        //                                             <td
        //                                             style="line-height: 24px; font-size: 16px; border-radius: 6px; font-weight: 700 !important; margin: 0;"
        //                                             align="center" bgcolor="#0d6efd">
        //                                             <a href="http://localhost/peaksched/client_admin/reset_password.php?token=$token"
        //                                                 style="color: #ffffff; font-size: 16px; font-family: Helvetica, Arial, sans-serif; text-decoration: none; border-radius: 6px; line-height: 20px; display: block; font-weight: 700 !important; white-space: nowrap; background-color: #0d6efd; padding: 12px; border: 1px solid #0d6efd;">Reset Password</a>
        //                                             </td>
        //                                         </tr>
        //                                         </tbody>
        //                                     </table>
        //                                     </td>
        //                                 </tr>
        //                                 </tbody>
        //                             </table>
        //                             <table class="s-10 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0"
        //                                 style="width: 100%;" width="100%">
        //                                 <tbody>
        //                                 <tr>
        //                                     <td style="line-height: 40px; font-size: 40px; width: 100%; height: 40px; margin: 0;"
        //                                     align="left" width="100%" height="40">
        //                                     &#160;
        //                                     </td>
        //                                 </tr>
        //                                 </tbody>
        //                             </table>
        //                             <table class="ax-center" role="presentation" align="center" border="0" cellpadding="0"
        //                                 cellspacing="0" style="margin: 0 auto;">
        //                                 <tbody>
        //                                 <tr>
        //                                     <td style="line-height: 24px; font-size: 16px; margin: 0;" align="left">
        //                                     <img class="w-40" src="https://i.ibb.co/VvgKRCH/1.png"
        //                                         style="height: auto; line-height: 100%; outline: none; text-decoration: none; display: block; width: 160px; border-style: none; border-width: 0;"
        //                                         width="160">
        //                                     </td>
        //                                 </tr>
        //                                 </tbody>
        //                             </table>
        //                             <table class="s-6 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0"
        //                                 style="width: 100%;" width="100%">
        //                                 <tbody>
        //                                 <tr>
        //                                     <td style="line-height: 24px; font-size: 24px; width: 100%; height: 24px; margin: 0;"
        //                                     align="left" width="100%" height="24">
        //                                     &#160;
        //                                     </td>
        //                                 </tr>
        //                                 </tbody>
        //                             </table>
        //                             <div class="text-muted text-center" style="color: #718096;" align="center">
        //                             Feel free to reach out if you have any inquiries <br>
        //                             (604) 815-8453 <br>
        //                             twinpeaks@twinpeakshomecare.com
        //                             </div>
        //                             <table class="s-6 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0"
        //                                 style="width: 100%;" width="100%">
        //                                 <tbody>
        //                                 <tr>
        //                                     <td style="line-height: 24px; font-size: 24px; width: 100%; height: 24px; margin: 0;"
        //                                     align="left" width="100%" height="24">
        //                                     &#160;
        //                                     </td>
        //                                 </tr>
        //                                 </tbody>
        //                             </table>
        //                             </td>
        //                         </tr>
        //                         </tbody>
        //                     </table>
        //                     <!--[if (gte mso 9)|(IE)]>
        //                         </td>
        //                     </tr>
        //                     </tbody>
        //                 </table>
        //                         <![endif]-->
        //                     </td>
        //                 </tr>
        //                 </tbody>
        //             </table>
        //             </td>
        //         </tr>
        //         </tbody>
        //     </table>
        //     </body>

        //     </html>

        //     END;

        //     $mail->send();
        //     $this->conn->close();
        // } catch (Exception $e) {
        //     echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        // }

        try {
            $mail->isSMTP();

            //Enable SMTP debugging
            //SMTP::DEBUG_OFF = off (for production use)
            //SMTP::DEBUG_CLIENT = client messages
            //SMTP::DEBUG_SERVER = client and server messages
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;


            //Set the hostname of the mail server
            $mail->Host = 'smtp.gmail.com';
            //Use `$mail->Host = gethostbyname('smtp.gmail.com');`
            //if your network does not support SMTP over IPv6,
            //though this may cause issues with TLS

            //Set the SMTP port number:
            // - 465 for SMTP with implicit TLS, a.k.a. RFC8314 SMTPS or
            // - 587 for SMTP+STARTTLS
            $mail->Port = 465;

            //Set the encryption mechanism to use:
            // - SMTPS (implicit TLS on port 465) or
            // - STARTTLS (explicit TLS on port 587)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

            //Whether to use SMTP authentication
            $mail->SMTPAuth = true;

            //Username to use for SMTP authentication - use full email address for gmail
            $mail->Username = 'rivals191@gmail.com';

            //Password to use for SMTP authentication
            $mail->Password = 'iwafeletytquflgl';

            //Set who the message is to be sent from
            //Note that with gmail you can only use your account address (same as `Username`)
            //or predefined aliases that you have configured within your account.
            //Do not use user-submitted addresses in here
            $mail->setFrom('from@example.com');

            //Set an alternative reply-to address
            //This is a good place to put user-submitted addresses
            $mail->addReplyTo('replyto@example.com');

            //Set who the message is to be sent to
            $mail->addAddress($email);

            $mail->isHTML(true);

            //Set the subject line
            $mail->Subject = 'Password Reset';

            $mail->Body    = <<<END
            
            Click <a href="http://localhost/peaksched/client_customer/reset_password.php?token=$token">here</a>
            to reset your password.
            END;

            //send the message, check for errors
            if (!$mail->send()) {
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                echo 'Message sent!';
                //Section 2: IMAP
                //Uncomment these to save your message in the 'Sent Mail' folder.
                #if (save_mail($mail)) {
                #    echo "Message saved!";
                #}
            }
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
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

<?php
require_once "config.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/admin_account.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/form_validation.php";

$validate = new Validation();
$admin = unserialize($_SESSION["adminUser"]);


$admin->setConn($conn);

$firstName = $admin->getFirstName();
$lastName = $admin->getLastName();
$email = $admin->getEmail();
$mobileNumber = $admin->getMobileNumber();
$password = $admin->getHashedPassword();
$currentPassword = $newPassword = $confirmPassword = "";

$firstName_err = $lastName_err = $email_err = $mobileNumber_err = "";
$currentPassword_err = $newPassword_err = $confirmPassword_err = "";



if (isset($_POST['updateInfo'])) {
    updateDetails($firstName_err, $lastName_err, $email_err, $mobileNumber_err, $firstName, $lastName, $email, $mobileNumber, $admin, $validate);
} else if (isset($_POST['changePassword'])) {
    changePassword($currentPassword, $newPassword, $confirmPassword, $currentPassword_err, $newPassword_err, $confirmPassword_err, $admin, $password, $validate);
}


function updateDetails(&$firstName_err, &$lastName_err, &$email_err, &$mobileNumber_err, &$firstName, &$lastName, &$email, &$mobileNumber, $admin, $validate)
{


    $firstName = $lastName = $mobileNumber = "";

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    }

    $firstName = trim($_POST["firstName"]);
    $firstName_err = $validate->firstName($firstName);

    $lastName = trim($_POST["lastName"]);
    $lastName_err = $validate->lastName($lastName);

    $newEmail = trim($_POST["email"]);
    if (!$newEmail == $email) {
        $email_err = $admin->validateEmail($newEmail);
    }
    if (empty($email_err)) {
        $newEmail = $admin->getEmail();
    }


    $mobileNumber = trim($_POST["mobile"]);
    $mobileNumber_err = $validate->mobileNumber($mobileNumber);


    if (empty($firstName_err) && empty($lastName_err) && empty($emailAddress_err) && empty($mobileNumber_err) && empty($changed_err)) {
        $admin->updateUserDetails($firstName, $lastName, $newEmail, $mobileNumber);
    }
}

function changePassword(&$currentPassword, &$newPassword, &$confirmPassword, &$currentPassword_err, &$newPassword_err, &$confirmPassword_err, $admin, $password, $validate)
{


    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    }

    $currentPassword = trim($_POST["currentPassword"]);
    $currentPassword_err = $validate->currentPassword($currentPassword, $password);

    $newPassword = trim($_POST["newPassword"]);
    $newPassword_err = $admin->validatePassword($newPassword);
    if (empty($password_err)) {
        $newHashedPassword = $admin->getHashedPassword();
    }

    $confirmPassword = trim($_POST["confirmPassword"]);
    $confirmPassword_err = $validate->confirmPassword($confirmPassword, $newPassword);

    if (empty($currentPassword_err) && empty($newPassword_err) && empty($confirmPassword_err)) {
        $admin->changeUserPassword($newHashedPassword);
    }
}

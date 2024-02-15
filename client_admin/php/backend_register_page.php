<?php
require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/admin_account.php";

$firstName = $lastName = $emailAddress = $mobileNumber = $password = $confirmPassword =  $adminId = $hashedPassword = "";

// variables that will hold error messages
$firstName_err = $lastName_err = $emailAddress_err = $mobileNumber_err = $password_err = $confirmPassword_err = "";


$adminAccount = new AdminAccount($conn);

validateInputs();

function validateInputs()
{
    global $firstName_err, $lastName_err, $emailAddress_err, $mobileNumber_err, $password_err, $confirmPassword_err;
    global $firstName, $lastName, $emailAddress, $mobileNumber, $password, $confirmPassword, $adminId, $hashedPassword, $adminAccount;

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    }

    $adminId = rand(100000, 200000);

    while (!$adminAccount->isIdUnique($adminId)) {
        $adminId = rand(100000, 200000);
    }

    // validate firstname
    $firstName = trim($_POST["firstName"]);

    if (empty($firstName)) {
        $firstName_err = "Please enter your first name.";
    }

    $lastName = trim($_POST["lastName"]);

    if (empty($lastName)) {
        $lastName_err = "Please enter your last name.";
    }

    $emailAddress = trim($_POST["email"]);
    $emailAddress_err = $adminAccount->validateEmail($emailAddress);
    if (empty($emailAddress_err)) {
        $emailAddress = $adminAccount->getEmail();
    }


    $mobileNumber = trim($_POST["mobile"]);

    if (empty($mobileNumber)) {
        $mobileNumber_err = "Please enter your mobile number.";
    } else if (!is_numeric($mobileNumber)) {
        $mobileNumber_err = "Please enter a valid mobile number.";
    }

    $password = trim($_POST["password"]);
    $password_err = $adminAccount->validatePassword($password);
    if (empty($password_err)) {
        $hashedPassword = $adminAccount->getHashedPassword();
    }


    $confirmPassword = trim($_POST["confirmPassword"]);

    if (empty($confirmPassword)) {
        $confirmPassword_err = "Please enter a password.";
    } else if ($confirmPassword != $password) {
        $confirmPassword_err = "Password does not match.";
    }

    if (empty($firstName_err) && empty($lastName_err) && empty($emailAddress_err) && empty($mobileNumber_err) && empty($password_err) && empty($confirmPassword_err)) {
        $adminAccount->register($adminId, $firstName, $lastName, $emailAddress, $mobileNumber, $hashedPassword);
    }
}

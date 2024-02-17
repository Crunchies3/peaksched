<?php
require_once "config.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/customer_account.php";

$customer = unserialize($_SESSION["customerUser"]);


$customer->setConn($conn);

// variables that will hold the data

$firstName = $customer->getFirstName();
$lastName = $customer->getLastName();
$email = $customer->getEmail();
$mobileNumber = $customer->getMobileNumber();
$password = $customer->getHashedPassword();
$currentPassword = $newPassword = $confirmPassword = "";

// variables that will hold the errors.

$firstName_err = $lastName_err = $email_err = $mobileNumber_err = "";
$currentPassword_err = $newPassword_err = $confirmPassword_err = "";

// i pass by reference ang mga variable gamit ang "&" except sa objects

if (isset($_POST['updateInfo'])) {
    updateDetails($firstName_err, $lastName_err, $email_err, $mobileNumber_err, $firstName, $lastName, $email, $mobileNumber, $customer);
} else if (isset($_POST['changePassword'])) {
    changePassword($currentPassword, $newPassword, $confirmPassword, $currentPassword_err, $newPassword_err, $confirmPassword_err, $customer, $password);
}


// Function na modawat sa refences

function updateDetails(&$firstName_err, &$lastName_err, &$email_err, &$mobileNumber_err, &$firstName, &$lastName, &$email, &$mobileNumber, $customer)
{
    $firstName = $lastName = $mobileNumber = "";

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    }

    $firstName = trim($_POST["firstName"]);

    if (empty($firstName)) {
        $firstName_err = "Please enter your first name.";
    }

    $lastName = trim($_POST["lastName"]);

    if (empty($lastName)) {
        $lastName_err = "Please enter your last name.";
    }

    $newEmail = trim($_POST["email"]);

    if (!$newEmail == $email) {
        $email_err = $customer->validateEmail($newEmail);
    }
    if (empty($email_err)) {
        $newEmail = $customer->getEmail();
    }

    $mobileNumber = trim($_POST["mobile"]);
    if (empty($mobileNumber)) {
        $mobileNumber_err = "Please enter your mobile number.";
    } else if (!is_numeric($mobileNumber)) {
        $mobileNumber_err = "Please enter a valid mobile number.";
    }

    if (empty($firstName_err) && empty($lastName_err) && empty($emailAddress_err) && empty($mobileNumber_err) && empty($changed_err)) {
        $customer->updateUserDetails($firstName, $lastName, $newEmail, $mobileNumber);
    }
}

// Function na modawat sa refences

function changePassword(&$currentPassword, &$newPassword, &$confirmPassword, &$currentPassword_err, &$newPassword_err, &$confirmPassword_err, $customer, $password)
{
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    }

    $currentPassword = trim($_POST["currentPassword"]);
    if (empty($currentPassword)) {
        $currentPassword_err = "Please enter a password.";
    } else if (!password_verify($currentPassword, $password)) {
        $currentPassword_err = "Incorrect Current Password";
    }


    $newPassword = trim($_POST["newPassword"]);
    $newPassword_err = $customer->validatePassword($newPassword);
    if (empty($newPassword_err)) {
        $newHashedPassword = $customer->getHashedPassword();
    }

    $confirmPassword = trim($_POST["confirmPassword"]);
    if (empty($confirmPassword)) {
        $confirmPassword_err = "Please enter a password.";
    } else if ($confirmPassword != $newPassword) {
        $confirmPassword_err = "Password does not match.";
    }


    if (empty($password_err) && empty($confirmPassword_err) && empty($newPassword_err)) {
        $customer->changeUserPassword($newHashedPassword);
    }
}

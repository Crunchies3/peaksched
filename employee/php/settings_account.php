<?php
require_once "config.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/employee_account.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/form_validation.php";

$validate = new Validation();
$customer = unserialize($_SESSION["employeeUser"]);

$validate->setUserType($customer);
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
    updateDetails($firstName_err, $lastName_err, $email_err, $mobileNumber_err, $firstName, $lastName, $email, $mobileNumber, $customer, $validate);
} else if (isset($_POST['changePassword'])) {
    changePassword($currentPassword, $newPassword, $confirmPassword, $currentPassword_err, $newPassword_err, $confirmPassword_err, $customer, $password, $validate);
}


// Function na modawat sa refences

function updateDetails(&$firstName_err, &$lastName_err, &$email_err, &$mobileNumber_err, &$firstName, &$lastName, &$email, &$mobileNumber, $customer, $validate)
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

    if ($newEmail != $email) {
        $email_err = $validate->validateEmail($newEmail);
    }
    if (empty($email_err)) {
        $newEmail = $customer->getEmail();
    }

    $mobileNumber = trim($_POST["mobile"]);
    $mobileNumber_err = $validate->mobileNumber($mobileNumber);

    if (empty($firstName_err) && empty($lastName_err) && empty($email_err) && empty($mobileNumber_err) && empty($changed_err)) {
        $customer->updateUserDetails($firstName, $lastName, $newEmail, $mobileNumber);
    }
}

// Function na modawat sa refences

function changePassword(&$currentPassword, &$newPassword, &$confirmPassword, &$currentPassword_err, &$newPassword_err, &$confirmPassword_err, $customer, $password, $validate)
{
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    }

    $currentPassword = trim($_POST["currentPassword"]);
    $currentPassword_err = $validate->currentPassword($currentPassword, $password);


    $newPassword = trim($_POST["newPassword"]);
    $newPassword_err = $validate->validatePassword($newPassword);
    if (empty($newPassword_err)) {
        $newHashedPassword = $customer->getHashedPassword();
    }

    $confirmPassword = trim($_POST["confirmPassword"]);
    $confirmPassword_err = $validate->confirmPassword($confirmPassword, $newPassword);


    if (empty($password_err) && empty($confirmPassword_err) && empty($newPassword_err)) {
        $customer->changeUserPassword($newHashedPassword);
    }
}

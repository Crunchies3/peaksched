<?php
require_once "config.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/customer_account.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/form_validation.php";

$firstName = $lastName = $emailAddress = $mobileNumber = $password = $confirmPassword = $checkbox =  $customerId = $hashedPassword = "";
// variables that will hold error messages
$firstName_err = $lastName_err = $emailAddress_err = $mobileNumber_err = $password_err = $confirmPassword_err = $checkBox_err = "";

$customerAccount = new CustomerAccount($conn);
$validate = new Validation;
$validate->setUserType($customerAccount);


validateInputs();

function validateInputs()
{
    global $firstName_err, $lastName_err, $emailAddress_err, $mobileNumber_err, $password_err, $confirmPassword_err, $checkBox_err, $validate;
    global $firstName, $lastName, $emailAddress, $mobileNumber, $password, $confirmPassword, $checkbox, $customerId, $hashedPassword, $customerAccount;

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    }

    $customerId = rand(100000, 200000);

    while (!$customerAccount->isIdUnique($customerId)) {
        $customerId = rand(100000, 200000);
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
    $emailAddress_err = $validate->validateEmail($emailAddress);
    if (empty($emailAddress_err)) {
        $emailAddress = $customerAccount->getEmail();
    }

    $mobileNumber = trim($_POST["mobile"]);
    if (empty($mobileNumber)) {
        $mobileNumber_err = "Please enter your mobile number.";
    } else if (!is_numeric($mobileNumber)) {
        $mobileNumber_err = "Please enter a valid mobile number.";
    }

    $password = trim($_POST["password"]);
    $password_err = $validate->validatePassword($password);
    if (empty($password_err)) {
        $hashedPassword = $customerAccount->getHashedPassword();
    }

    $confirmPassword = trim($_POST["confirmPassword"]);

    if (empty($confirmPassword)) {
        $confirmPassword_err = "Please enter a password.";
    } else if ($confirmPassword != $password) {
        $confirmPassword_err = "Password does not match.";
    }

    if (!isset($_POST['checkBox'])) {
        $checkBox_err = "Please Agree before submitting";
    } else {
        $checkbox = 'checked';
    }

    if (empty($firstName_err) && empty($lastName_err) && empty($emailAddress_err) && empty($mobileNumber_err) && empty($password_err) && empty($confirmPassword_err) && empty($checkBox_err)) {
        $customerAccount->register($customerId, $firstName, $lastName, $emailAddress, $mobileNumber, $hashedPassword);
    }
}

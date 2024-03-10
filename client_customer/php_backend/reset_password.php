<?php
require_once "config.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/customer_account.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/form_validation.php";


$password = $confirmPassword = $hashedPassword = $tokenHash = $status = $visibility = $token = "";
// variables that will hold error messages
$password_err = $confirmPassword_err = $tokenHash_err = "";

if (isset($_GET["token"])) {
    $token = $_GET["token"];
}

$customerAccount = new CustomerAccount($conn);
$validate = new Validation;
$validate->setUserType($customerAccount);

if ($token != null) {
    validateToken($customerAccount, $token, $tokenHash, $tokenHash_err, $status, $visibility, $validate);
}

validateInputs($password_err, $confirmPassword_err,$password, $confirmPassword, $hashedPassword, $customerAccount, $token, $validate);

function validateToken($customerAccount, &$token, &$tokenHash, &$tokenHash_err, &$status, &$visibility,$validate)
{


    $tokenHash = $customerAccount->getHashedToken($token);
    $tokenHash_err = $validate->tokenHash($tokenHash,$status);

    if (empty($tokenHash_err)) {
        $visibility = "hidden";
    }
}

function validateInputs(&$password_err, &$confirmPassword_err, &$password, &$confirmPassword, &$hashedPassword, $customerAccount, &$token, $validate)
{


    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    }

    $token = $_POST["token"];
    validateToken($customerAccount, $token, $tokenHash, $tokenHash_err, $status, $visibility, $validate);


    $password = trim($_POST["password"]);
    $password_err = $validate->validatePassword($password);

    if (empty($password_err)) {
        $hashedPassword = $customerAccount->getHashedPassword();
    }

    $confirmPassword = trim($_POST["confirmPassword"]);
    $confirmPassword_err = $validate->confirmPassword($confirmPassword,$password);


    if (empty($password_err) && empty($confirmPassword_err)) {
        $customerAccount->forgotResetPassword($hashedPassword, $customerAccount->getId());
    }
}



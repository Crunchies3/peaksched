<?php
require_once "./php_backend/config.php";
require_once "../class/customer_account.php";


$password = $confirmPassword = $hashedPassword = $tokenHash = $status = $visibility = $token = "";
// variables that will hold error messages
$password_err = $confirmPassword_err = $tokenHash_err = "";

if (isset($_GET["token"])) {
    $token = $_GET["token"];
}

$customerAccount = new CustomerAccount($conn);

if ($token != null) {
    validateToken();
}

validateInputs();

function validateToken()
{
    global $customerAccount, $token, $tokenHash, $tokenHash_err, $status, $visibility;

    $tokenHash = $customerAccount->getHashedToken($token);
    if (!$customerAccount->doesTokenExist($tokenHash)) {
        $tokenHash_err = "Invalid reset link";
        $status = "disabled";
    }

    if (empty($tokenHash_err) && strtotime($customerAccount->getTokenExpiry()) <= time()) {
        $tokenHash_err = "Expired reset link";
        $status = "disabled";
    }

    if (empty($tokenHash_err)) {
        $visibility = "hidden";
    }
}

function validateInputs()
{
    global $password_err, $confirmPassword_err;
    global $password, $confirmPassword, $hashedPassword, $customerAccount, $token;

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    }

    $token = $_POST["token"];
    validateToken($token);


    $password = trim($_POST["password"]);
    $password_err = $customerAccount->validatePassword($password);
    if (empty($password_err)) {
        $hashedPassword = $customerAccount->getHashedPassword();
    }

    $confirmPassword = trim($_POST["confirmPassword"]);
    if (empty($confirmPassword)) {
        $confirmPassword_err = "Please enter a password.";
    } else if ($confirmPassword != $password) {
        $confirmPassword_err = "Password does not match.";
    }


    if (empty($password_err) && empty($confirmPassword_err)) {
        $customerAccount->forgotResetPassword($hashedPassword, $customerAccount->getId());
    }
}

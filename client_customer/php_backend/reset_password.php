<?php
require_once "./php_backend/config.php";
require_once "../class/customer_account.php";

$token = $_GET["token"];

$password = $confirmPassword = $hashedPassword = $tokenHash = "";
// variables that will hold error messages
$password_err = $confirmPassword_err = $tokenHash_err = "";

$customerAccount = new CustomerAccount($conn);

validateToken();

validateInputs();


function validateToken()
{
    global $customerAccount, $token, $tokenHash, $tokenHash_err;

    $tokenHash = $customerAccount->getHashedToken($token);
    if (!$customerAccount->doesTokenExist($tokenHash)) {
        $tokenHash_err = "Invalid reset link";
    }

    if (empty($tokenHash_err) && strtotime($customerAccount->getTokenExpiry()) <= time()) {
        $tokenHash_err = "Expired reset link";
    }

    if (empty($tokenHash_err)) {
        echo "Token is valid and has not expired";
    }
}

function validateInputs()
{
    global $password_err, $confirmPassword_err;
    global $password, $confirmPassword, $hashedPassword, $customerAccount;

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    }

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


    if (empty($firstName_err) && empty($lastName_err) && empty($emailAddress_err) && empty($mobileNumber_err) && empty($password_err) && empty($confirmPassword_err) && empty($checkBox_err)) {
    }
}

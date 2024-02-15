<?php
require_once "config.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/admin_account.php";


$password = $confirmPassword = $hashedPassword = $tokenHash = $status = $visibility = $token = "";
// variables that will hold error messages
$password_err = $confirmPassword_err = $tokenHash_err = "";

if (isset($_GET["token"])) {
    $token = $_GET["token"];
}

$adminAccount = new AdminAccount($conn);

if ($token != null) {
    validateToken();
}

validateInputs();

function validateToken()
{
    global $adminAccount, $token, $tokenHash, $tokenHash_err, $status, $visibility;

    $tokenHash = $adminAccount->getHashedToken($token);
    if (!$adminAccount->doesTokenExist($tokenHash)) {
        $tokenHash_err = "Invalid reset link";
        $status = "disabled";
    }

    if (empty($tokenHash_err) && strtotime($adminAccount->getTokenExpiry()) <= time()) {
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
    global $password, $confirmPassword, $hashedPassword, $adminAccount, $token;

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    }

    $token = $_POST["token"];
    validateToken($token);


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


    if (empty($password_err) && empty($confirmPassword_err)) {
        $adminAccount->forgotResetPassword($hashedPassword, $adminAccount->getId());
    }
}

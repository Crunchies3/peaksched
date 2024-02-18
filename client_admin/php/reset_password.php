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
$validate = new Validation;
if ($token != null) {
    validateToken($adminAccount, $token, $tokenHash, $tokenHash_err, $status, $visibility, $validate);
}

validateInputs($password_err, $confirmPassword_err,$password, $confirmPassword, $hashedPassword, $adminAccount, $token);

function validateToken($adminAccount, &$token, &$tokenHash, &$tokenHash_err, &$status, &$visibility,)
{


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

function validateInputs(&$password_err, &$confirmPassword_err, &$password, &$confirmPassword, &$hashedPassword, $adminAccount, &$token, $validate)
{


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
    $confirmPassword_err = $validate->confirmPassword($confirmPassword,$password);


    if (empty($password_err) && empty($confirmPassword_err)) {
        $adminAccount->forgotResetPassword($hashedPassword, $adminAccount->getId());
    }
}

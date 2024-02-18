<?php
require_once "config.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/employee_account.php";


$password = $confirmPassword = $hashedPassword = $tokenHash = $status = $visibility = $token = "";
// variables that will hold error messages
$password_err = $confirmPassword_err = $tokenHash_err = "";

if (isset($_GET["token"])) {
    $token = $_GET["token"];
}

$employeeAccount = new EmployeeAccount($conn, "worker");
$validate = new Validation;

if ($token != null) {
    validateToken($employeeAccount, $token, $tokenHash, $tokenHash_err, $status, $visibility, $validate);
}

validateInputs($password_err, $confirmPassword_err,$password, $confirmPassword, $hashedPassword, $employeeAccount, $token);

function validateToken($employeeAccount, &$token, &$tokenHash, &$tokenHash_err, &$status, &$visibility)
{


    $tokenHash = $employeeAccount->getHashedToken($token);
    if (!$employeeAccount->doesTokenExist($tokenHash)) {
        $tokenHash_err = "Invalid reset link";
        $status = "disabled";
    }

    if (empty($tokenHash_err) && strtotime($employeeAccount->getTokenExpiry()) <= time()) {
        $tokenHash_err = "Expired reset link";
        $status = "disabled";
    }

    if (empty($tokenHash_err)) {
        $visibility = "hidden";
    }
}

function validateInputs(&$password_err, &$confirmPassword_err, &$password, &$confirmPassword, &$hashedPassword, $employeeAccount, &$token, $validate)
{

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    }

    $token = $_POST["token"];
    validateToken($token);


    $password = trim($_POST["password"]);
    $password_err = $employeeAccount->validatePassword($password);
    if (empty($password_err)) {
        $hashedPassword = $employeeAccount->getHashedPassword();
    }

    $confirmPassword = trim($_POST["confirmPassword"]);
    $confirmPassword_err = $validate->confirmPassword($confirmPassword,$password);


    if (empty($password_err) && empty($confirmPassword_err)) {
        $employeeAccount->forgotResetPassword($hashedPassword, $employeeAccount->getId());
    }
}

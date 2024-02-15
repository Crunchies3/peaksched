<?php
require_once "config.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/employee_account.php";


$emailAddress = $password = "";

$emailAddress_err = $password_err = $login_err = "";

$employeeAccount = new EmployeeAccount($conn, "worker");

// ! UNIT TEST
// $employeeAccount->validatePassword("Sdjj2015");
// $tempPass = $employeeAccount->getHashedPassword();

// $employeeAccount->register("213432", "Cyril", "Alvez", "rivals@gmail.com", "09550717073", $tempPass);

validateInputs();

function validateInputs()
{
    global $emailAddress, $password, $emailAddress_err, $password_err, $employeeAccount, $login_err;

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    }

    $emailAddress = trim($_POST["email"]);
    if (empty($emailAddress)) {
        $emailAddress_err = "Please enter your email address.";
    }

    $password = trim($_POST["password"]);
    if (empty($password)) {
        $password_err = "Please enter your password.";
    }

    if (empty($emailAddress_err) && empty($password_err)) {
        $login_err = $employeeAccount->login($emailAddress, $password);
        $password_err = $login_err;
    }
}

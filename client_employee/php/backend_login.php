<?php
require_once "config.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/employee_account.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/form_validation.php";


$emailAddress = $password = "";

$emailAddress_err = $password_err = $login_err = "";

$employeeAccount = new EmployeeAccount($conn, "worker");
$validate = new Validation();
$validate->setUserType($employeeAccount);


// ! UNIT TEST
// $employeeAccount->validatePassword("Sdjj2015");
// $tempPass = $employeeAccount->getHashedPassword();

// $employeeAccount->register("213432", "Cyril", "Alvez", "rivals@gmail.com", "09550717073", $tempPass);

validateInputs($emailAddress, $password, $emailAddress_err, $password_err, $employeeAccount, $login_err, $validate);

function validateInputs(&$emailAddress, &$password, &$emailAddress_err, &$password_err, &$employeeAccount, &$login_err, $validate)
{


    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    }

    $emailAddress = trim($_POST["email"]);
    $emailAddress_err = $validate->emailEmptyDoesNotExist($emailAddress);

    $password = trim($_POST["password"]);
    $password_err = $validate->passwordEmpty($password);

    if (empty($emailAddress_err) && empty($password_err)) {
        $login_err = $employeeAccount->login($emailAddress, $password);
        $password_err = $login_err;
    }
}

<?php
require_once "config.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/admin_account.php";

//variables that holds the error
$emailAddress_err = $password_err = $login_err = "";

$adminAccount = new AdminAccount($conn);

validateInputs($emailAddress, $password, $emailAddress_err, $password_err, $login_err, $adminAccount);

function validateInputs(&$emailAddress, &$password, &$emailAddress_err, &$password_err, &$login_err, $adminAccount)
{
    $emailAddress = $password = "";

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
        $login_err = $adminAccount->login($emailAddress, $password);
        $password_err = $login_err;
    }
}

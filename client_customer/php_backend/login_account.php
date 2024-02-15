<?php
require_once "config.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/customer_account.php";

$emailAddress = $password = "";

$emailAddress_err = $password_err = $login_err = "";

$customerAccount = new CustomerAccount($conn);

validateInputs();

function validateInputs()
{
    global $emailAddress, $password, $emailAddress_err, $password_err, $customerAccount, $login_err;

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
        $login_err = $customerAccount->login($emailAddress, $password);
        $password_err = $login_err;
    }
}

$conn->close();

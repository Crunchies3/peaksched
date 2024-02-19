<?php
require_once "config.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/admin_account.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/form_validation.php";

$emailAddress = $password = "";
$emailAddress_err = $password_err = $login_err = "";

$adminAccount = new AdminAccount($conn);
$validate = new Validation();
$validate->setUserType($adminAccount);

validateInputs($emailAddress, $password, $emailAddress_err, $password_err, $login_err, $adminAccount,$validate);

function validateInputs(&$emailAddress, &$password, &$emailAddress_err, &$password_err, &$login_err, $adminAccount,$validate)
{

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    }

    $emailAddress = trim($_POST["email"]);
    $emailAddress_err = $validate->emailEmptyDoesNotExist($emailAddress);

    $password = trim($_POST["password"]);
    $password_err = $validate->passwordEmpty($password);

    if (empty($emailAddress_err) && empty($password_err)) {
        $login_err = $adminAccount->login($emailAddress, $password);
        $password_err = $login_err;
    }
}

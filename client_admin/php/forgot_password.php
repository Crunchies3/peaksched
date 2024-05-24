<?php
require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/admin_account.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/form_validation.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/email.php";


$emailAddress = "";

$emailAddress_err = "";

$visibility = "hidden";

$emailClass = new Email();
$adminAccount = new AdminAccount($conn);
$validate = new Validation();
$validate->setUserType($adminAccount);

validateInputs($emailAddress, $adminAccount, $emailAddress_err, $visibility, $validate, $emailClass);

function validateInputs(&$emailAddress, &$adminAccount, &$emailAddress_err, &$visibility, $validate, &$emailClass)
{

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    }

    $token = bin2hex(random_bytes(16));
    $tokenHash = $adminAccount->getHashedToken($token);

    $expiry = date("Y-m-d H:i:s", time() + 60 * 30);

    $emailAddress = trim($_POST["email"]);
    $emailAddress_err = $validate->emailEmptyDoesNotExist($emailAddress);


    if (empty($emailAddress_err)) {
        $adminAccount->addResetToken($tokenHash, $expiry, $emailAddress);
        $emailClass->sendForgotPasswordLink($emailAddress, $token, "client_admin");
        $visibility = "";
    }
}

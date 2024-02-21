<?php
require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/admin_account.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/form_validation.php";

$emailAddress = "";

$emailAddress_err = "";

$visibility = "hidden";

$adminAccount = new AdminAccount($conn);
$validate = new Validation();
$validate->setUserType($adminAccount);

validateInputs($emailAddress, $adminAccount, $emailAddress_err, $visibility,$validate);

function validateInputs(&$emailAddress, &$adminAccount, &$emailAddress_err, &$visibility,$validate)
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
        $adminAccount->sendForgotPasswordLink($emailAddress, $token);
        $visibility = "";
    }
}

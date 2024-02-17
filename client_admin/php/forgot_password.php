<?php
require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/admin_account.php";

$emailAddress = "";

$emailAddress_err = "";

$visibility = "hidden";

$adminAccount = new AdminAccount($conn);

validateInputs($emailAddress, $adminAccount, $emailAddress_err, $visibility);

function validateInputs(&$emailAddress, &$adminAccount, &$emailAddress_err, &$visibility)
{

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    }

    $token = bin2hex(random_bytes(16));
    $tokenHash = $adminAccount->getHashedToken($token);

    $expiry = date("Y-m-d H:i:s", time() + 60 * 30);

    $emailAddress = trim($_POST["email"]);
    if (empty($emailAddress)) {
        $emailAddress_err = "Please enter your email address.";
    } else if (!$adminAccount->doesEmailExist($emailAddress)) {
        $emailAddress_err = "Email address does not exist";
    }


    if (empty($emailAddress_err)) {
        $adminAccount->addResetToken($tokenHash, $expiry, $emailAddress);
        $adminAccount->sendForgotPasswordLink($emailAddress, $token);
        $visibility = "";
    }
}

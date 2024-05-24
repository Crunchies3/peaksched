<?php
require_once "config.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/customer_account.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/email.php";

$emailAddress = "";

$emailAddress_err = "";

$visibility = "hidden";

$emailClass = new Email();
$customerAccount = new CustomerAccount($conn);

validateInputs();

function validateInputs()
{
    global $emailAddress, $customerAccount, $emailAddress_err, $visibility, $emailClass;

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    }

    $token = bin2hex(random_bytes(16));
    $tokenHash = $customerAccount->getHashedToken($token);

    $expiry = date("Y-m-d H:i:s", time() + 60 * 30);

    $emailAddress = trim($_POST["email"]);
    if (empty($emailAddress)) {
        $emailAddress_err = "Please enter your email address.";
    } else if (!$customerAccount->doesEmailExist($emailAddress)) {
        $emailAddress_err = "Email address does not exist";
    }


    if (empty($emailAddress_err)) {
        $customerAccount->addResetToken($tokenHash, $expiry, $emailAddress);
        $emailClass->sendForgotPasswordLink($emailAddress, $token, "client_customer");
        $visibility = "";
    }
}

<?php
require_once "./php_backend/config.php";
require_once "../class/customer_account.php";

$emailAddress = "";

$emailAddress_err = "";

$customerAccount = new CustomerAccount($conn);

validateInputs();

function validateInputs()
{
    global $emailAddress, $customerAccount, $emailAddress_err;

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
        $customerAccount->sendForgotPasswordLink($emailAddress, $token);
        echo "Messae sent, please check your inbox.";
    }
}

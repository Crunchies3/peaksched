<?php
require_once "../class/customer_account.php";

$password = $confirmPassword = $hashedPassword = $tokenHash = $status = $visibility = "";
// variables that will hold error messages
$password_err = $confirmPassword_err = $tokenHash_err = "";

$customerAccount = new CustomerAccount($conn);


validateInputs();


function validateInputs()
{
    global $password_err, $confirmPassword_err, $tokenHash_err;
    global $password, $confirmPassword, $hashedPassword, $customerAccount, $token;

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    }

    $token = $_POST["token"];
    validateToken($token);

    if (empty($tokenHash_err)) {

        $password = trim($_POST["password"]);
        $password_err = $customerAccount->validatePassword($password);
        if (empty($password_err)) {
            $hashedPassword = $customerAccount->getHashedPassword();
        }

        $confirmPassword = trim($_POST["confirmPassword"]);
        if (empty($confirmPassword)) {
            $confirmPassword_err = "Please enter a password.";
        } else if ($confirmPassword != $password) {
            $confirmPassword_err = "Password does not match.";
        }


        if (empty($password_err) && empty($confirmPassword_err)) {
        }
    }
}

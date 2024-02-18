<?php
require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/admin_account.php";

$firstName= $lastName= $emailAddress=$mobileNumber= $password= $confirmPassword= $adminId= $hashedPassword = "";
$firstName_err= $lastName_err= $emailAddress_err= $mobileNumber_err= $password_err=$confirmPassword_err= "";

$adminAccount = new AdminAccount($conn);
$validate= new Validation;


validateInputs($adminAccount, $validate ,$firstName, $lastName, $emailAddress,$mobileNumber, $password, $confirmPassword, $adminId,$hashedPassword,
$firstName_err, $lastName_err, $emailAddress_err,$mobileNumber_err, $password_err,$confirmPassword_err);

function validateInputs($adminAccount, $validate, &$firstName, &$lastName, &$emailAddress,&$mobileNumber, &$password, &$confirmPassword, &$adminId,&$hashedPassword,
&$firstName_err, &$lastName_err, &$emailAddress_err,&$mobileNumber_err, &$password_err,&$confirmPassword_err)
{

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    }

    $adminId = rand(100000, 200000);

    while (!$adminAccount->isIdUnique($adminId)) {
        $adminId = rand(100000, 200000);
    }


    $firstName = trim($_POST["firstName"]);
    $firstName_err = $validate->firstName($firstName);

    $lastName = trim($_POST["lastName"]);
    $lastName_err = $validate->lastName($lastName);

    $emailAddress = trim($_POST["email"]);
    $emailAddress_err = $adminAccount->validateEmail($emailAddress);
    if (empty($emailAddress_err)) {
        $emailAddress = $adminAccount->getEmail();
    }


    $mobileNumber = trim($_POST["mobile"]);
    $mobileNumber_err = $validate->mobileNumber($mobileNumber);

    $password = trim($_POST["password"]);
    $password_err = $adminAccount->validatePassword($password);
    if (empty($password_err)) {
        $hashedPassword = $adminAccount->getHashedPassword();
    }


    $confirmPassword = trim($_POST["confirmPassword"]);
    $confirmPassword_err = $validate->confirmPassword($confirmPassword, $password);

    if (empty($firstName_err) && empty($lastName_err) && empty($emailAddress_err) && empty($mobileNumber_err) && empty($password_err) && empty($confirmPassword_err)) {
        $adminAccount->register($adminId, $firstName, $lastName, $emailAddress, $mobileNumber, $hashedPassword);
    }
}

<?php

require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/customer_account.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/form_validation.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/customers.php";

$customerAcc = new CustomerAccount($conn);


$customer = new Customers();
$customer->setConn($customerAcc->getConn());

$validate = new Validation();
$validate->setUserType($customerAcc);

$firstName = $firstName_err =  $lastName = $lastName_err = $email = $email_err  = $mobileNumber = $mobileNumber_err = "";
$tempPassword ="";

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    return;
}

$customerId = rand(100000, 200000);

while (!$customerAcc->isIdUnique($customerId)) {
    $customerId = rand(100000, 200000);
}
$tempPassword = "Default123";
$validate->validatePassword($tempPassword);
$tempHashedPassword = $customerAcc->getHashedPassword();

$firstName = trim($_POST["firstName"]);
$firstName_err = $validate->firstName($firstName);

$lastName = trim($_POST["lastName"]);
$lastName_err = $validate->firstName($lastName);

$email = trim($_POST["email"]);
$email_err = $validate->validateEmail($email);

$mobileNumber = trim($_POST["mobile"]);
$mobileNumber_err = $validate->mobileNumber($mobileNumber);




if (empty($firstname_err) && empty($lastName_err) && empty($email_err) && empty($mobileNumber_err)) {
    $customer->addCustomer($firstName, $lastName, $email,  $mobileNumber, $customerId,$tempHashedPassword);
    header("location: ./customer_page.php");
}
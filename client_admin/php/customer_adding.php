<?php

require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/customer_account.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/form_validation.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/customers.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/address.php";

$customerAcc = new CustomerAccount($conn);


$customer = new Customers();
$customer->setConn($customerAcc->getConn());

$address = new Address();
$address->setConn($conn);

$validate = new Validation();
$validate->setUserType($customerAcc);

$firstName = $firstName_err =  $lastName = $lastName_err = $email = $email_err  = $mobileNumber = $mobileNumber_err = "";
$tempPassword = "";


// address related variables

$street = $city = $province = $country = $zipCode = "";
$street_err = $city_err = $province_err = $country_err = $zipCode_err = "";

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


$addressId = rand(100000, 200000);

while (!$address->isIdUnique($addressId)) {
    $addressId = rand(100000, 200000);
}

$street = trim($_POST["street"]);
$street_err = $validate->address($street);

$city = trim($_POST["city"]);
$city_err = $validate->address($city);

$province = trim($_POST["province"]);
$province_err = $validate->address($province);

$country = trim($_POST["country"]);
$country_err = $validate->address($country);

$zipCode = trim($_POST["zipCode"]);






if (empty($firstname_err) && empty($lastName_err) && empty($email_err) && empty($mobileNumber_err) && empty($street_err) && empty($city_err) && empty($province_err) && empty($country_err)) {
    $customer->addCustomer($firstName, $lastName, $email,  $mobileNumber, $customerId, $tempHashedPassword);
    $address->addAddress($customerId, $addressId, $street, $city, $province, $zipCode, $country, 'Primary');
    header("location: ./customer_page.php");
}

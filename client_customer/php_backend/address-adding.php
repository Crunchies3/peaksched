<?php

require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/customer_account.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/form_validation.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/customers.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/address.php";

$customerAcc = unserialize($_SESSION["customerUser"]);
$customerAcc->setConn($conn);

$customer = new Customers();
$customer->setConn($customerAcc->getConn());

$customerId = $customerAcc->getId();

$validate = new Validation();
$validate->setUserType($customerAcc);

$address = new Address();
$address->setConn($conn);

$type = $street = $city = $province = $zipCode = $country = "";
$street_err = $city_err = $province_err = $zipCode_err = $country_err = "";

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    return;
}

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

$zipCode = trim($_POST["zipCode"]);
$zipCode_err = $validate->address($zipCode);

$country = trim($_POST["country"]);
$country_err = $validate->address($country);

$type = $address->doesPrimaryExist();




if (empty($street_err) && empty($city_err) && empty($province_err) && empty($zipCode_err) && empty($country_err)) {

    if ($type) {
        $address->addAddress($customerId, $addressId, $street, $city, $province, $zipCode, $country, 'Primary');
    } else {
        $address->addAddress($customerId, $addressId, $street, $city, $province, $zipCode, $country, '');
    }


    echo '<script type="text/javascript"> window.location="./index";</script>';
}

<?php
require_once "./php_backend/config.php";
require_once "../class/customer_account.php";

$customer = unserialize($_SESSION["customerUser"]);

$firstName = $customer->getFirstName();
$lastName = $customer->getLastName();
$email = $customer->getEmail();
$mobileNumber = $customer->getMobileNumber();
$password = $customer->getHashedPassword();

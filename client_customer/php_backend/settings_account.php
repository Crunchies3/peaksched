<?php
require_once "config.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/customer_account.php";

$customer = unserialize($_SESSION["customerUser"]);

$firstName = $customer->getFirstName();
$lastName = $customer->getLastName();
$email = $customer->getEmail();
$mobileNumber = $customer->getMobileNumber();
$password = $customer->getHashedPassword();

if (isset($_POST['updateInfo'])) {
    updateDetails();
} else if (isset($_POST['changePassword'])) {
    changePassword();
}


function updateDetails()
{
}

function changePassword()
{
}

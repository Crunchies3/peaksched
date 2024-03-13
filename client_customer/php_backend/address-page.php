<?php

require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/address.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/customer_account.php";

$customer = unserialize($_SESSION["customerUser"]);
$customer->setConn($conn);

$customerId = $customer->getId();

$address = new Address();
$address->setConn($conn);
$result = $address->fetchAddressListByCustomer($customerId);

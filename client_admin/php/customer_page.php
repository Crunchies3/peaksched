<?php

require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/customers.php";

$customers = new Customers();
$customers->setConn($conn);
$customers->fetchCustomerList();
$result = $customers->getCustomerList();
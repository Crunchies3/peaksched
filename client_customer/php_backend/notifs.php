<?php
require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/notifications.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/customer_account.php";

$notification = new Notifications();
$notification->setConn($conn);

$customerAcc = unserialize($_SESSION["customerUser"]);

$userName = $customerAcc->getFirstname();

$notification->displayNotification($customerAcc->getId());
$result = $notification->getDisplayNotifs();
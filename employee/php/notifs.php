<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/notifications.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/employee_account.php";

$notification = new Notifications();
$notification->setConn($conn);

$employeeAcc = unserialize($_SESSION["employeeUser"]);

$notification->displayNotification($employeeAcc->getId());
$result = $notification->getDisplayNotifs();
<?php
require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/notifications.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/admin_account.php";

$notification = new Notifications();
$notification->setConn($conn);

$adminAcc = unserialize($_SESSION["adminUser"]);

$userName = $adminAcc->getFirstname();

$notification->displayNotification($adminAcc->getId());
$result = $notification->getDisplayNotifs();
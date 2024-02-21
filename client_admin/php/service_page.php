<?php

require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/admin_account.php";

$admin = unserialize($_SESSION["adminUser"]);
$admin->setConn($conn);
$admin->fetchServiceList();
$result = $admin->getServiceList();

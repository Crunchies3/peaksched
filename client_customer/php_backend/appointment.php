<?php

require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/admin_account.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/services.php";

$service = new Services();
$service->setConn($conn);
$service->fetchServiceList();
$result = $service->getServiceList();

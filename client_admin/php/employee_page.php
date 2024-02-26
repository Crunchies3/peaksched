<?php

require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/employees.php";

$employees = new Employees();
$employees->setConn($conn);
$employees->fetchEmployeesList();
$result = $employees->getEmployeeList();

// $admin = unserialize($_SESSION["adminUser"]);
// $admin->setConn($conn);
// $admin->fetchServiceList();
// $result = $admin->getServiceList();

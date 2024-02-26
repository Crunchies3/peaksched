<?php

require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/employees.php";

$employees = new Employees();
$employees->setConn($conn);
$employees->fetchEmployeesList();
$result = $employees->getEmployeeList();

// usabon para makuha ang ang assigned workers
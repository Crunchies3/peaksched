<?php
require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/employee_client.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/employee_account.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/payroll.php";

$payroll = new Payroll();
$payroll->setConn($conn);

$supervisorAcc = unserialize($_SESSION["employeeUser"]);
$supervisorId = $supervisorAcc->getId();

$result = $payroll->getEmployeesPayslipList($supervisorId);

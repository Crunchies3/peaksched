<?php

require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/appointments.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/form_validation.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/payroll.php";

$startDate = $endDate = $payDate = $federalTax = $payrollId = "";

$payroll = new Payroll();
$payroll->setConn($conn);


if ($_SERVER["REQUEST_METHOD"] != "POST") {
    return;
}


$startDate =  trim($_POST["startDate"]);
$endDate =  trim($_POST["endDate"]);
$payDate =  trim($_POST["payDate"]);
$federalTax =  trim($_POST["fedTax"]);

$payrollId = rand(100000, 200000);



$payroll->runPayroll($payrollId, $startDate, $endDate, $payDate, $federalTax);

<?php

require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/appointments.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/form_validation.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/payroll.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/reports.php";


$startDate = $endDate = $payDate = $federalTax = $payrollId = "";

$startDate_err = $endDateErr = $fedTax_err = $paydate_err = "";
$doesPendingReportExist = false;

$payroll = new Payroll();
$payroll->setConn($conn);

$validate = new Validation();

$report = new Report();
$report->setConn($conn);

$pendingReportCount = $report->countPendingReports();

if ($pendingReportCount > 0) $doesPendingReportExist = true;


if ($_SERVER["REQUEST_METHOD"] != "POST") {
    return;
}


$startDate =  trim($_POST["startDate"]);
$startDate_err = $validate->PayrollDate($startDate);

$endDate =  trim($_POST["endDate"]);
$endDateErr = $validate->PayrollDate($endDate);

$payDate =  trim($_POST["payDate"]);
$paydate_err = $validate->PayrollDate($payDate);

$federalTax =  trim($_POST["fedTax"]);
$fedTax_err = $validate->PayrollDate($federalTax);

$payrollId = rand(100000, 200000);

if (empty($startDate_err) && empty($endDateErr) && empty($paydate_err) && empty($fedTax_err)) {
    $payroll->runPayroll($payrollId, $startDate, $endDate, $payDate, $federalTax);
    header("location: ./index.php");
}

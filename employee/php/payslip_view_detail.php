<?php
require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/payroll.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/employee_account.php";

$payroll = new Payroll();
$payroll->setConn($conn);

$payroll_id = $employee_id = $payslipId = "";

$employeeAcc = unserialize($_SESSION["employeeUser"]);
$employee_id = $employeeAcc->getId();

if (isset($_GET["payslipId"])) {
    $payslipId = $_GET["payslipId"];
}


$payroll_id = $payroll->getPayrollIdByPayslipId($payslipId);

//getting displayables
$payroll->employeePayslipDisplayables($employee_id, $payroll_id);
$firstname = $payroll->getfirstname();
$lastname = $payroll->getlastname();
$type = $payroll->gettype();
$payrate = $payroll->getpayrate();
$paydate = $payroll->getpaydate();
$wordedpayDate = date("F j, Y", strtotime($paydate));
$month = date("F", strtotime($paydate));
$startDate = $payroll->getstartdate();
$wordedStartDate = date("F j, Y", strtotime($startDate));
$endDate = $payroll->getendate();
$wordedendDate = date("F j, Y", strtotime($endDate));
$payslipId = $payroll->getpayslipid();
$netPay = $payroll->getnetpay();
$hoursworked = $payroll->gethoursworked();
$deductions = $payroll->getdeductions();
$grosspay = $payroll->getgrosspay();
$federaltax = $payroll->getfederalTax();

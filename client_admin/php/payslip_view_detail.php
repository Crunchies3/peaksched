<?php
require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/payroll.php";

$payroll = new Payroll();
$payroll->setConn($conn);

$payroll_id = $employee_id = "";
if (isset($_GET["payrollid"])) {
    $payroll_id = $_GET["payrollid"];
}

if (isset($_GET["employeeid"])) {
    $employee_id = $_GET["employeeid"];
}

//getting displayables
$payroll->employeePayslipDisplayables($employee_id, $payroll_id);
$firstname = $payroll->getfirstname();
$lastname = $payroll->getlastname();
$type = $payroll->gettype();
$payrate = $payroll->getpayrate();

$paydate = $payroll->getpaydate();

if ($paydate == null) {
    $paydate = "1999-01-01 08:00:00";
}

$wordedpayDate = date("F j, Y", strtotime($paydate));

$month = date("F", strtotime($paydate));
$startDate = $payroll->getstartdate();

if ($startDate == null) {
    $startDate = "1999-01-01 08:00:00";
}

$wordedStartDate = date("F j, Y", strtotime($startDate));
$endDate = $payroll->getendate();

if ($endDate == null) {
    $endDate = "1999-01-01 08:00:00";
}

$wordedendDate = date("F j, Y", strtotime($endDate));
$payslipId = $payroll->getpayslipid();
$netPay = $payroll->getnetpay();
$hoursworked = $payroll->gethoursworked();
$deductions = $payroll->getdeductions();
$grosspay = $payroll->getgrosspay();
$federaltax = $payroll->getfederalTax();

if (isset($_POST['approvePayslip'])) {
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    };

    $payroll_id = $_POST["payrollId"];
    $payslipId = $_POST["payslipid"];
    $employee_id = $_POST["employeeid"];
    $payroll->approvePayslip($payslipId, $employee_id);
    echo "<script type='text/javascript'> window.location='./view-employee.php?payrollId=$payroll_id';</script>";
}

<?php
require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/payroll.php";

$payroll = new Payroll();
$payroll->setConn($conn);

if (isset($_GET["payrollId"])) {
    $payroll_id = $_GET["payrollId"];
}

$payslipList = $payroll->fetchEmployeeInsidePayroll($payroll_id);


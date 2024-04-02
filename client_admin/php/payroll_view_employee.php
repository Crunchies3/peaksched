<?php
require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/payroll.php";

$payroll = new Payroll();
$payroll->setConn($conn);

$payroll_id = "";

if (isset($_GET["payrollId"])) {
    $payroll_id = $_GET["payrollId"];
}
//boolean
$isTherePending = $payroll->isTherePending();

$payslipList = $payroll->fetchEmployeeInsidePayroll($payroll_id);

if (isset($_POST['approvethePayroll'])) {
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    };

    $payroll_id = $_POST["payrollId"];

    $payroll->approvePayroll($payroll_id);
} else if (isset($_POST['deletePayroll'])) {

    //? diri ibutang ang code for delete payroll
}

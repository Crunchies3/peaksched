<?php
require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/payroll.php";

$payroll = new Payroll();
$payroll->setConn($conn);

$payroll_id = "";

$show = true;

if (isset($_GET["payrollId"])) {
    $payroll_id = $_GET["payrollId"];
}
//boolean

$payslipList = $payroll->fetchEmployeeInsidePayroll($payroll_id);

if (isset($_POST['approvethePayroll'])) {
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    };

    $payroll_id = $_POST["payrollId"];

    $payslipList = $payroll->fetchEmployeeInsidePayroll($payroll_id);

    $isGoodToGo = $payroll->isTherePending($payroll_id);

    if (!$isGoodToGo) {
        $show = true;
        $payroll->approvePayroll($payroll_id);
        header("location: ./index.php");
    } else {
        $show = false;
    }
} else if (isset($_POST['deletePayroll'])) {

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    };

    $payroll_id = $_POST["payrollId"];

    $payroll->deletePayroll($payroll_id);

    header("location: ./index.php");
}

<?php

require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/employee_account.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/form_validation.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/employees.php";

$employeeAcc = new EmployeeAccount($conn, "worker");


$employee = new Employees();
$employee->setConn($employeeAcc->getConn());

$validate = new Validation();
$validate->setUserType($employeeAcc);

$payrate = $payrate_err = $firstName = $firstName_err =  $lastName = $lastName_err = $email = $email_err  = $mobileNumber = $mobileNumber_err = $position = $position_err = "";
$tempPassword = "";

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    return;
}

$employeeid = rand(100000, 200000);

while (!$employeeAcc->isIdUnique($employeeid)) {
    $employeeid = rand(100000, 200000);
}
$tempPassword = "Default123";
$validate->validatePassword($tempPassword);
$tempHashedPassword = $employeeAcc->getHashedPassword();

$firstName = trim($_POST["firstName"]);
$firstName_err = $validate->firstName($firstName);

$lastName = trim($_POST["lastName"]);
$lastName_err = $validate->firstName($lastName);

$email = trim($_POST["email"]);
$email_err = $validate->validateEmail($email);

$mobileNumber = trim($_POST["mobile"]);
$mobileNumber_err = $validate->mobileNumber($mobileNumber);

$position = trim($_POST["position"]);
$position_err = $validate->position($position);

$payrate = trim($_POST["payrate"]);
$payrate_err = $validate->payrate($payrate);



if (empty($firstname_err) && empty($lastName_err) && empty($email_err) && empty($mobileNumber_err)) {
    $employee->addEmployee($firstName, $lastName, $email,  $mobileNumber, $position, $employeeid, $tempHashedPassword, $payrate);
    header("location: ./employee_page.php");
}

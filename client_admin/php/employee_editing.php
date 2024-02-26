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

$firstName = $firstName_err =  $lastName = $lastName_err = $email = $email_err  = $mobileNumber = $mobileNumber_err = $position = $position_err = "";
$employeeId = "";
// kuhaon niya ang service id na naa sa link
// Sundoga tong naa sa reset_password.php

if (isset($_GET["employeeId"])) {
    $employeeId = $_GET["employeeId"];
}

//displayables
$employee->displayCurrentEmployee($employeeId);

$firstName = $employee->getFirstname();
$lastName = $employee->getLastname();
$email = $employee->getEmail();
$mobileNumber = $employee->getMobilenumber();
$position = $employee->getPosition();





if ($_SERVER["REQUEST_METHOD"] != "POST") {
    return;
};

$employeeId = $_POST["employeeId"];


$firstName = trim($_POST["firstName"]);
$firstName_err = $validate->firstName($firstName);

$lastName = trim($_POST["lastName"]);
$lastName_err = $validate->firstName($lastName);

$email = trim($_POST["email"]);
$email_err = $validate->emailEmptyDoesNotExist($email);

$mobileNumber = trim($_POST["mobile"]);
$mobileNumber_err = $validate->mobileNumber($mobileNumber);

$position = trim($_POST["position"]);



if (empty($firstname_err) && empty($lastName_err) && empty($email_err) && empty($mobileNumber_err)) {
    $employee->updateEmployeeDetails( $firstName, $lastName,  $email, $mobileNumber, $position , $employeeId);
    header("location: ./employee_page.php");
}
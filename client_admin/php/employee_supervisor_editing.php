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

$payrate = $payrate_err = $status = $status_err = $firstName = $firstName_err =  $lastName = $lastName_err = $email = $email_err  = $mobileNumber = $mobileNumber_err = $position = $position_err = $assignedto = "";
$employeeId = "";
$password = $newPassword = $confirmPassword = "";
$newPassword_err = $confirmPassword_err = "";
// kuhaon niya ang service id na naa sa link
// Sundoga tong naa sa reset_password.php

if (isset($_GET["employeeId"])) {
    $employeeId = $_GET["employeeId"];
}

//getting the list of assigned workers
$employees->fetchSupervisorWorkers($employeeId);
$supervisorWorkers = $employees->getSupervisorWorkers();

//displayables
$employee->displayCurrentEmployee($employeeId);

$firstName = $employee->getFirstname();
$lastName = $employee->getLastname();
$email = $employee->getEmail();
$mobileNumber = $employee->getMobilenumber();
$position = $employee->getPosition();
$payrate =  $employee->getPayrate();
$status =  $employee->getStatus();

$assignedto = $employee->getWorkerAssignedTo($employeeId);

if (isset($_POST['updateInfo'])) { //! para mag update sa details like name

    echo "edit";

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
    $position_err = $validate->position($position);

    $payrate = trim($_POST["payrate"]);
    $payrate_err = $validate->payrate($payrate);

    $status = trim($_POST["status"]);
    $status_err = $validate->status($status);



    if (empty($firstname_err) && empty($lastName_err) && empty($email_err) && empty($mobileNumber_err)) {
        $employee->updateEmployeeDetails($firstName, $lastName,  $email, $mobileNumber, $position, $employeeId, $payrate, $status);
        echo "<script type='text/javascript'> window.location='./employee_editing_page.php?employeeId=$employeeId';</script>";
    }
} else if (isset($_POST['changePassword'])) {  //! para mag change pass

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    }
    $employeeId = $_POST["employeeId"];
    $newPassword = trim($_POST["newPassword"]);
    $newPassword_err = $validate->validatePassword($newPassword);

    $confirmPassword = trim($_POST["confirmPassword"]);
    $confirmPassword_err = $validate->confirmPassword($confirmPassword, $newPassword);

    if (empty($newPassword_err) && empty($confirmPassword_err)) {
        $employee->changeEmployeePassword($newHashedPassword);
        //faulty to be continued..
        echo "<script type='text/javascript'> window.location='./employee_page.php?employeeId=$employeeId';</script>";
    }
} else if (isset($_POST['deleteAccount'])) { //! para mag delete ug account

    //pareha ra ang change pass ug delete account ug form maong giani
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    }
    $employeeId = $_POST["employeeId"];
    $employee->deleteEmployee($employeeId);
    echo '<script type="text/javascript"> window.location="./employee_page.php";</script>';
}

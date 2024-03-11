<?php
require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/employee_client.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/employee_account.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/form_validation.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/appointments.php";

$employeeAcc = unserialize($_SESSION["employeeUser"]);
$supervisorId = $employeeAcc->getId();

$employeeClient = new Employee_Client();
$employeeClient->setConn($conn);

$validate = new Validation();

$appointment = new Appointment();
$appointment->setConn($conn);

$appointmentId = $fullname = $title = $status = $date = $hour_err = $minute_err = $hour = $minute = "";

if (isset($_GET["appointmentId"])) {
    $appointmentId = $_GET["appointmentId"];
}

//displayables
$employeeClient->displayCurrentAppointmentAssigned($appointmentId);
$appointmentId = $employeeClient->getAppointmentId();

$appointment->getConfirmedAppointmentDetails($appointmentId);
$appointment->getConfirmedDisplayables();
$date = $appointment->getSpecificDate();

$dateOnly = date("Y-m-d", strtotime($date));
$timeOnly = date('h:i A', strtotime($date));

$fullname = $employeeClient->getFullname();
$title = $employeeClient->getServicetitle();
$status = $employeeClient->getAppointmentstatus();
$date = $employeeClient->getAppointmentdate();
$time = $employeeClient->getAppointmentdate();

//===============================================================================================
//for displaying/deleting assigned workers to a specific appointment

$employeeClient->fetchAppointmentWorkers($appointmentId);
$result = $employeeClient->getAssignedWorkers();

if (isset($_POST['submitReport'])) {
    $appointmentId = $_POST["appointmentId"];
    $employeeClient->fetchAppointmentWorkers($appointmentId);
    $result = $employeeClient->getAssignedWorkers();

    $employeeClient->displayCurrentAppointmentAssigned($appointmentId);
    $appointmentId = $employeeClient->getAppointmentId();
    $fullname = $employeeClient->getFullname();
    $title = $employeeClient->getServicetitle();
    $status = $employeeClient->getAppointmentstatus();
    $date = $employeeClient->getAppointmentdate();
    $time = $employeeClient->getAppointmentdate();
    $dateOnly = date("Y-m-d", strtotime($date));
    $timeOnly = date('h:i A', strtotime($date));


    $hour = $_POST["hour"];
    $hour_err = $validate->time($hour);

    $minute = $_POST["minute"];
    $minute_err = $validate->time($minute);
}

<?php
require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/employee_client.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/employee_account.php";

$employeeAcc = unserialize($_SESSION["employeeUser"]);
$supervisorId = $employeeAcc->getId();

$employeeClient = new Employee_Client();
$employeeClient->setConn($conn);



$appointmentId = $fullname = $title = $status = $date = "";

if (isset($_GET["appointmentId"])) {
    $appointmentId = $_GET["appointmentId"];
}

//displayables
$employeeClient->displayCurrentAppointmentAssigned($appointmentId);

$appointmentId = $employeeClient->getAppointmentId();
$fullname = $employeeClient->getFullname();
$title = $employeeClient->getServicetitle();
$status = $employeeClient->getAppointmentstatus();
$date = $employeeClient->getAppointmentdate();
$time = $employeeClient->getAppointmentdate();

//===============================================================================================
//for displaying/deleting assigned workers to a specific appointment

$employeeClient->fetchAppointmentWorkers($appointmentId);
$result = $employeeClient->getAssignedWorkers();

if (isset($_POST['RemoveWorker'])) {
    $workerId = $_POST["workerId"];
    $appointmentId = $_POST["appointmentId"];

    $employeeClient->removeWorkerInAppointment($appointmentId, $workerId);
    $employeeClient->fetchAppointmentWorkers($appointmentId);
    $result = $employeeClient->getAssignedWorkers();
}

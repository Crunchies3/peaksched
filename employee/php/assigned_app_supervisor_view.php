<?php
require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/employee_client.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/employee_account.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/notifMessages.php";

$notification = new NotifMessages();
$notification->setConn($conn);

$employeeAcc = unserialize($_SESSION["employeeUser"]);
$supervisorId = $employeeAcc->getId();

$employeeClient = new Employee_Client();
$employeeClient->setConn($conn);



$appointmentId = $fullname = $title = $status = $date = $formattedDate = $formattedTime =  "";

if (isset($_GET["appointmentId"])) {
    $appointmentId = $_GET["appointmentId"];
}

//displayables
$employeeClient->displayCurrentAppointmentAssigned($appointmentId);

$appointmentId = $employeeClient->getAppointmentId();
$fullname = $employeeClient->getFullname();
$title = $employeeClient->getServicetitle();
$status = $employeeClient->getAppointmentstatus();
$date = date_create($employeeClient->getAppointmentdate());
$formattedDate = date_format($date, "M d, Y");
$time = date_create($employeeClient->getAppointmentdate());
$formattedTime = date_format($time, "H: i A");

//===============================================================================================
//for displaying/deleting assigned workers to a specific appointment

$employeeClient->fetchAppointmentWorkers($appointmentId);
$result = $employeeClient->getAssignedWorkers();

if (isset($_POST['RemoveWorker'])) {
    $workerId = $_POST["workerId"];
    $appointmentId = $_POST["appointmentId"];


    $notification->setsenderUserType($supervisorId);
    $notification->setreceiverUserType($workerId);

    $supervisorId = $employeeAcc->getId();
    $message = $notification->supToWorkerRemove($title);
    $receiver = $notification->getreceiverUserType();
    $unread = true;
    date_default_timezone_set("America/Vancouver");
    $date = date("Y-m-d H:i:s");

    $employeeClient->removeWorkerInAppointment($appointmentId, $workerId);
    $notification->insertNotif($receiver, $unread, $date, $message);

    $employeeClient->fetchAppointmentWorkers($appointmentId);
    $result = $employeeClient->getAssignedWorkers();
}

<?php
require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/employee_client.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/employee_account.php";

$employeeAcc = unserialize($_SESSION["employeeUser"]);
$supervisorId = $employeeAcc->getId();

$employeeClient = new Employee_Client();
$employeeClient->setConn($conn);

$appointmentId = "";

if (isset($_GET["appointmentId"])) {
    $appointmentId = $_GET["appointmentId"];

$employeeClient->fetchUnassignedAppointmentWorkers($appointmentId,$supervisorId);
$result = $employeeClient->getUnassignedWorkers();
}
if(isset($_POST['AssignWorkerModal'])){
    $workerId = $_POST["workerId"];
    $appointmentId = $_POST["appointmentId"];

    $supervisorId = $employeeAcc->getId();

    //para marefresh ang table
    $employeeClient->addWorkerToAppointment($appointmentId,$workerId);
    $employeeClient->fetchUnassignedAppointmentWorkers($appointmentId,$supervisorId);
    $result = $employeeClient->getUnassignedWorkers();

}

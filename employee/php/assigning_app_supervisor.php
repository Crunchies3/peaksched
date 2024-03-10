<?php
require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/employee_client.php";

$employeeClient = new Employee_Client();
$employeeClient->setConn($conn);

$appointmentId = "";

if (isset($_GET["appointmentId"])) {
    $appointmentId = $_GET["appointmentId"];

$employeeClient->fetchUnassignedAppointmentWorkers($appointmentId);
$result = $employeeClient->getUnassignedWorkers();
}
if(isset($_POST['AssignWorkerModal'])){
    $workerId = $_POST["workerId"];
    $appointmentId = $_POST["appointmentId"];

    //para marefresh ang table
    $employeeClient->addWorkerToAppointment($appointmentId,$workerId);
    $employeeClient->fetchUnassignedAppointmentWorkers($appointmentId);
    $result = $employeeClient->getUnassignedWorkers();

}

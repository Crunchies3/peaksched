<?php

require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/services.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/appointments.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/customer_account.php";

$customer = unserialize($_SESSION["customerUser"]);
$customer->setConn($conn);

$service = new Services();
$service->setConn($conn);
$service->fetchServiceList();
$result = $service->getServiceList();

$appointment = new Appointment();
$appointment->setConn($conn);
$customerId = $customer->getId();
$resultAppointment = $appointment->fetchAppointmentListByCustomer($customerId);

$appointmentId = $selectedService = $date = $assignedSupervisor = "";

if (isset($_GET["appointmentId"])) {
    $appointmentId = $_GET["appointmentId"];
}
$appointment->getAppointmentDetails($appointmentId);

$appointment->getDisplayables();
$appointment->getAssignedSupervisor();

$selectedService = $appointment->getSpecificTitle();
$assignedSupervisor = $appointment->getSpecificSupervisorAssigned();
$date = $appointment->getSpecificDate();

$dateOnly = date("Y-m-d", strtotime($date));
$timeOnly = date('h:i A', strtotime($date));


$status = $appointment->getStatus();


if (isset($_POST['cancelApp'])) {
    //diria ibutang ang code paras appointment cancel
    $appointmentId = $_POST["appointmentId"];
    $appointment->getAppointmentDetails($appointmentId);
    $service_id = $appointment->getServiceId();
    $customerId = $customer->getId();

    $appointment->cancelAppointment($appointmentId);
    $appointment->confirmedAppointmentDeletion($customerId,$service_id);

    header("location: manage-cancel-succes.php");
}

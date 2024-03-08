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

$appointmentId = "";

if (isset($_GET["appointmentId"])) {
    $appointmentId = $_GET["appointmentId"];
}
$appointment->getAppointmentDetails($appointmentId);

$status = $appointment->getStatus();


if (isset($_POST['cancelApp'])) {
    //diria ibutang ang code paras appointment cancel

    header("location: manage-cancel-success.php");
}

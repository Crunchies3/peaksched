<?php

require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/services.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/appointments.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/customer_account.php";

$customer = unserialize($_SESSION["customerUser"]);
$customer->setConn($conn);

$appointment = new Appointment();
$appointment->setConn($conn);

$customerId = $customer->getId();

$appointmentId = "";
if (isset($_GET["appointmentId"])) {
    $appointmentId = $_GET["appointmentId"];
}

if (isset($_POST['reschedApp'])) {
    //diria ibutang ang code paras appointment resced

    header("location: manage-resched-success.php");
}

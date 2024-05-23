<?php
require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/appointments.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/form_validation.php";

$appointment = new Appointment();
$appointment->setConn($conn);

$validate = new Validation();

$appointmentId = "";


$selectedDate = $selectedTime = "";
$selectedDate_err = $selectedTime_err = "";

if (isset($_GET["appointmentId"])) {
    $appointmentId = $_GET["appointmentId"];
}


if (isset($_POST['reschedApp'])) {


    //diria ibutang ang code paras appointment resced
    $appointmentId = $_POST["appointmentId"];

    if (isset($_POST['selectedDate'])) {
        $selectedDate = $_POST['selectedDate'];
    }
    $selectedDate_err = $validate->radioButton($selectedDate);

    if (isset($_POST['options'])) {
        $selectedTime = $_POST['options'];
    }
    $selectedTime_err = $validate->radioButton($selectedTime);

    $dateTimeStart = $selectedDate . " " . date("H:i", strtotime($selectedTime));
    $dateTimeEnd = $selectedDate . " " . date("H:i", strtotime($selectedTime));

    $note = "";
    $status = "Pending Approval";

    if (empty($selectedDate_err) && empty($selectedTime_err)) {
        $appointment->rescheduleAppointment($dateTimeStart, $dateTimeEnd, $note, $status, $appointmentId);
        echo "<script type='text/javascript'> window.location='view-details.php?appointmentId=$appointmentId';</script>";
    }
}

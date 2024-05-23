<?php

require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/services.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/appointments.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/customer_account.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/form_validation.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/notifMessages.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/services.php";

$customer = unserialize($_SESSION["customerUser"]);
$customer->setConn($conn);

$notification = new NotifMessages();
$notification->setConn($conn);

$appointment = new Appointment();
$appointment->setConn($conn);

$validate = new Validation();

$services = new Services();
$services->setConn($conn);



$appointmentId = $service_id = "";
if (isset($_GET["appointmentId"])) {
    $appointmentId = $_GET["appointmentId"];
}

$selectedDate = $selectedTime = $note = $status = "";
$selectedDate_err = $selectedTime_err = "";
$appointment->getAppointmentDetails($appointmentId);

$note = $appointment->getNote();



if (isset($_POST['reschedApp'])) {
    //diria ibutang ang code paras appointment resced
    $appointmentId = $_POST["appointmentId"];

    if (isset($_POST['selectedDate'])) {
        $selectedDate = $_POST['selectedDate'];
    }
    $selectedDate_err = $validate->radioButton($selectedDate);

    $note = $_POST['note'];

    if (isset($_POST['options'])) {
        $selectedTime = $_POST['options'];
    }
    $selectedTime_err = $validate->radioButton($selectedTime);

    $status = 'Pending Approval';

    $dateTimeStart = $selectedDate . " " . date("H:i", strtotime($selectedTime));
    $dateTimeEnd = $selectedDate . " " . date("H:i", strtotime($selectedTime));

    $appointment->getAppointmentDetails($appointmentId);
    $service_id = $appointment->getServiceId();
    $services->displayCurrentService($service_id);
    $serviceName = $services->getTitle();

    $customerId = $customer->getId();

    $unread = true;
    date_default_timezone_set("America/Vancouver");
    $currentDate = date("Y-m-d H:i:s");
    $messageToAdmin = $notification->custToAdminReschedAppointment($customer->getFirstname(), $serviceName);

    if (empty($selectedDate_err) && empty($selectedTime_err)) {
        $appointment->rescheduleAppointment($dateTimeStart, $dateTimeEnd, $note, $status, $appointmentId);
        $appointment->confirmedAppointmentDeletion($customerId, $service_id);
        $notification->insertNotifAdmin($unread, $currentDate, $messageToAdmin);
        echo '<script type="text/javascript"> window.location="manage-resched-success.php";</script>';
    }
}

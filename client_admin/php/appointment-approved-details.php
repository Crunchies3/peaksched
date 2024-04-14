<?php
require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/appointments.php";

$appointment = new Appointment();
$appointment->setConn($conn);

if (isset($_GET["appointmentId"])) {
    $appointmentId = $_GET["appointmentId"];
}

$note = "";

$appointmentDetails = $appointment->getApprovedAppointmentDetails($appointmentId);
while ($rows = $appointmentDetails->fetch_assoc()) {
    $fullname = $rows['fullname'];
    $serviceTitle = $rows['title'];
    $fullAddress = $rows['fullAddress'];
    $status = $rows['status'];
    $temp = date_create($rows['date']);
    $date =  date_format($temp, "M d, Y");;
    $time = $rows['time'];
    $note = $rows['note'];
    $num_floors = $rows['num_floors'];
    $num_beds = $rows['num_beds'];
    $num_baths = $rows['num_baths'];
    $supFullname = $rows['supFullname'];
}

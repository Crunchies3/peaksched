<?php

require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/appointments.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/form_validation.php";

$appointment = new Appointment();
$appointment->setConn($conn);
$validate = new Validation();


$appointmentId = $serviceTitle = $date = $start = $end = $customer = $notes = $supervisor = "";

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    return;
}

$appointmentId = rand(100000, 200000);

while (!$appointment->isAppointmentIdUnique($service_id)) {
    $appointmentId = rand(100000, 200000);
}

$serviceTitle =  trim($_POST["title"]);
$date =  trim($_POST["date"]);
$start =  trim($_POST["start"]);
$end =  trim($_POST["end"]);
$customer =  trim($_POST["customer"]);
$notes =  trim($_POST["description"]);
$supervisor =  trim($_POST["supervisor"]);
$dateTimeStart = $date . " " . date("H:i", strtotime($start));
$dateTimeEnd = $date . " " . date("H:i", strtotime($start));
$color = 'yellow';


try {
    $stmt = $conn->prepare("INSERT INTO tbl_appointment (id, title, start, end, color) VALUES (?,?,?,?,?)");
    $stmt->bind_param("sssss", $appointmentId, $serviceTitle, $dateTimeStart, $dateTimeEnd, $color);
    $stmt->execute();
    $conn->close();
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

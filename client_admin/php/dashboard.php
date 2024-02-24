<?php

require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/appointments.php";

$appointment = new Appointment();
$appointment->setConn($conn);

$appointmentId = $serviceTitle = $date = $start = $end = $customer = $notes = $supervisor = "";

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    return;
}

$appointmentId = rand(100000, 200000);

$serviceTitle =  trim($_POST["title"]);

$date =  trim($_POST["date"]);

$start =  trim($_POST["start"]);

$end =  trim($_POST["end"]);

$customer =  trim($_POST["customer"]);

$notes =  trim($_POST["description"]);

$supervisor =  trim($_POST["supervisor"]);


echo ($appointmentId . " ");
echo ($serviceTitle . " ");
echo ($date . " ");
echo ($start . " ");
echo ($end . " ");
echo ($customer . " ");
echo ($notes . " ");
echo ($supervisor . " ");

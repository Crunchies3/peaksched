<?php

require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/appointments.php";


$appointment = new Appointment();
$appointment->setConn($conn);

$result = $appointment->displayAppointmentRequest();
// $admin = unserialize($_SESSION["adminUser"]);
// $admin->setConn($conn);
// $admin->fetchServiceList();
// $result = $admin->getServiceList();

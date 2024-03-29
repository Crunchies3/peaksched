<?php
require_once 'config.php';

require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/appointments.php";

$appointment = new Appointment();
$appointment->setConn($conn);
$appointment->fetchRepeatedDatesCurrentOnwards();
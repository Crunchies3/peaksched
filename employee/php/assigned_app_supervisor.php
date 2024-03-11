<?php
require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/employee_client.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/employee_account.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/appointments.php";

$appointment = new Appointment();
$appointment->setConn($conn);

$supervisorAcc = unserialize($_SESSION["employeeUser"]);
$supervisorId = $supervisorAcc->getId();
$supClient = new Employee_Client();

$supClient->setConn($conn);
$supClient->fetchAssignedAppointments($supervisorId);

$result = $supClient->getAssignedAppointments();

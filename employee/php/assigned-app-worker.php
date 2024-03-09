<?php
require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/employee_client.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/employee_account.php";

$workerAcc = unserialize($_SESSION["employeeUser"]);
$workerId = $workerAcc->getId();
$workerClient = new Employee_Client();

$workerClient->setConn($conn);


$result = $workerClient->fetchAssignedWorkerAppointments($workerId);

<?php

require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/employees.php";

$employees = new Employees();
$employees->setConn($conn);
$employees->fetchAvailableWorkers();
$result = $employees->getAvailableWorkers();

if (isset($_GET["supervisorId"])) {
    $supervisorId = $_GET["supervisorId"];
}

if (isset($_POST['addWorkerModal'])) {

    $workerId = $_POST["workerId"];
    $supervisorId = $_POST["supervisorId"];

    // para mawala sa table inig add nimo sa worker
    $employees->addWorkerToSupervisor($supervisorId, $workerId);
    $employees->fetchAvailableWorkers();
    $result = $employees->getAvailableWorkers();
}

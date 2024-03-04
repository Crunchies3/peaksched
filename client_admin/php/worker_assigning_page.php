<?php

require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/employees.php";

$employees = new Employees();
$employees->setConn($conn);
$employees->fetchAvailableWorkers();
$result = $employees->getAvailableWorkers();


$supervisorId = $workerId = "";


if (isset($_GET["supervisorId"])) {
    $supervisorId = $_GET["supervisorId"];
}

if (isset($_POST['addWorkerModal'])) { 

    $workerId = $_POST["workerId"];
    $supervisorId = $_POST["supervisorId"];


    echo $supervisorId . " " . $workerId;

    $employees->addWorkerToSupervisor($supervisorId,$workerId);

}


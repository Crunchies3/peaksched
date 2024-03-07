<?php

require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/employees.php";

$employees = new Employees();
$employees->setConn($conn);
$employees->fetchEmployeesList();
$result = $employees->getEmployeeList();

// usabon para makuha ang ang assigned workers
//hahayesser
if(isset($_POST['deleteWorkerAccountModal'])) {
    $workerId = $_POST["workerId"];
    $supervisorId = $_POST["supervisorId"];

    $employees->removeAssignedWorker($workerId,$supervisorId);
    $employees->fetchEmployeesList();
    $result = $employees->getEmployeeList();

}
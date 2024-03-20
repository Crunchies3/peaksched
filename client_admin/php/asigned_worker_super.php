<?php

require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/employees.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/admin_account.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/notifMessages.php";

$admin = unserialize($_SESSION["adminUser"]);

$notification = new NotifMessages();
$notification->setConn($conn);

$employees = new Employees();
$employees->setConn($conn);
$employees->fetchEmployeesList();
$result = $employees->getEmployeeList();

// usabon para makuha ang ang assigned workers
//hahayesser
if(isset($_POST['deleteWorkerAccountModal'])) {
    $workerId = $_POST["workerId"];
    $supervisorId = $_POST["supervisorId"];

    $receiver = $supervisorId;
    $unread = true;
    $created_at = date("Y-m-d");
    $employees->displayCurrentEmployee($workerId);
    $messageToSup = $notification->adminRemoveWorkerstoSup($employees->getFirstname().' '.$employees->getLastname());
    $employees->displayCurrentEmployee($supervisorId);
    $messageToWorker = $notification->adminRemoveSuptoWorker($employees->getFirstname().' '.$employees->getLastname());



    $employees->removeAssignedWorker($workerId,$supervisorId);
    $notification->insertNotif($receiver, $unread, $created_at, $messageToSup);
    $notification->insertNotif($workerId, $unread, $created_at, $messageToWorker);
    $employees->fetchEmployeesList();
    $result = $employees->getEmployeeList();

}
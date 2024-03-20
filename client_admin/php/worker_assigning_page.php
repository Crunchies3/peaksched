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
$employees->fetchAvailableWorkers();
$result = $employees->getAvailableWorkers();



if (isset($_GET["supervisorId"])) {
    $supervisorId = $_GET["supervisorId"];
}

if (isset($_POST['addWorkerModal'])) {

    $workerId = $_POST["workerId"];
    $supervisorId = $_POST["supervisorId"];

    $receiver = $supervisorId;
    $unread = true;
    $created_at = date("Y-m-d");
    $employees->displayCurrentEmployee($workerId);
    $messageToSup = $notification->adminAssignWorkerstoSup($employees->getFirstname().' '.$employees->getLastname());
    $employees->displayCurrentEmployee($supervisorId);
    $messageToWorker = $notification->adminAddSuptoWorker($employees->getFirstname().' '.$employees->getLastname());

    // para mawala sa table inig add nimo sa worker
    $employees->addWorkerToSupervisor($supervisorId, $workerId);
    $notification->insertNotif($receiver, $unread, $created_at, $messageToSup);
    $notification->insertNotif($workerId, $unread, $created_at, $messageToWorker);
    $employees->fetchAvailableWorkers();
    $result = $employees->getAvailableWorkers();
}

<?php
require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/employee_client.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/employee_account.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/form_validation.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/appointments.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/reports.php";

$employeeAcc = unserialize($_SESSION["employeeUser"]);
$supervisorId = $employeeAcc->getId();

$employeeClient = new Employee_Client();
$employeeClient->setConn($conn);

$report = new Report();
$report->setConn($conn);


$validate = new Validation();

$appointment = new Appointment();
$appointment->setConn($conn);

$appointmentId = $fullname = $title = $status = $date = $hour_err = $minute_err = $hour = $minute = $hourWorked_err = "";

if (isset($_GET["appointmentId"])) {
    $appointmentId = $_GET["appointmentId"];
}

//displayables
$employeeClient->displayCurrentAppointmentAssigned($appointmentId);
$appointmentId = $employeeClient->getAppointmentId();

$appointment->getConfirmedAppointmentDetails($appointmentId);
$appointment->getConfirmedDisplayables();
$date = $appointment->getSpecificDate();

$dateOnly = date("Y-m-d", strtotime($date));
$timeOnly = date('h:i A', strtotime($date));

$fullname = $employeeClient->getFullname();
$title = $employeeClient->getServicetitle();
$status = $employeeClient->getAppointmentstatus();
$date = $employeeClient->getAppointmentdate();
$time = $employeeClient->getAppointmentdate();

$workerIds = array();
$workerHour = array();
$workerMinute = array();




//===============================================================================================
//for displaying/deleting assigned workers to a specific appointment

$employeeClient->fetchAppointmentWorkers($appointmentId);
$result = $employeeClient->getAssignedWorkers();

if (isset($_POST['submitReport'])) {
    $appointmentId = $_POST["appointmentId"];
    $employeeClient->fetchAppointmentWorkers($appointmentId);
    $result = $employeeClient->getAssignedWorkers();

    $employeeClient->displayCurrentAppointmentAssigned($appointmentId);
    $appointmentId = $employeeClient->getAppointmentId();
    $fullname = $employeeClient->getFullname();
    $title = $employeeClient->getServicetitle();
    $status = $employeeClient->getAppointmentstatus();
    $date = $employeeClient->getAppointmentdate();
    $time = $employeeClient->getAppointmentdate();
    $dateOnly = date("Y-m-d", strtotime($date));
    $timeOnly = date('h:i A', strtotime($date));



    $reportId = rand(100000, 200000);
    while (!$report->isReportIdUnique($reportId)) {
        $reportId = rand(100000, 200000);
    }


    $hour = $_POST["hour"];
    $hour_err = $validate->time($hour);

    $minute = $_POST["minute"];
    $minute_err = $validate->time($minute);

    for ($i = 0; $i < count($_POST); $i++) {
        if (isset($_POST['id' . $i])) {

            if (empty($_POST['id' . $i])) {
                $hourWorked_err = "Please fill all the fields";
            }
            array_push($workerIds, $_POST['id' . $i]);

            if (empty($_POST['hour' . $i]) && !is_numeric($_POST['hour' . $i])) {
                $hourWorked_err = "Please fill all the fields";
            }
            array_push($workerHour, $_POST['hour' . $i]);

            if (empty($_POST['minute' . $i]) && !is_numeric($_POST['minute' . $i])) {
                $hourWorked_err = "Please fill all the fields";
            }
            array_push($workerMinute, $_POST['minute' . $i]);
        }
    }

    $dateNow = date("Y/m/d");
    date_default_timezone_set("America/Vancouver");
    $timeNow = date("h:i");

    $notes = $_POST["note"];



    if (empty($hourWorked_err)) {
        $report->createReport($reportId, $workerIds, $workerHour, $workerMinute, $dateNow, $timeNow, $appointmentId, $supervisorId, $notes);
        $appointment->updateConfirmedAppointmentStatus($appointmentId, 'Completed');
        $appointment->updateCustomerRequestAppointmentStatus($appointmentId, 'Completed');
        $conn->close();
        header('location: report-success.php');
    }
}

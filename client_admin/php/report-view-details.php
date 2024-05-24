<?php
require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/employee_client.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/form_validation.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/appointments.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/reports.php";

$employeeClient = new Employee_Client();
$employeeClient->setConn($conn);

$report = new Report();
$report->setConn($conn);


$validate = new Validation();

$appointment = new Appointment();
$appointment->setConn($conn);

$appointmentId = $fullname = $title = $status = $date = $hour_err = $minute_err = $hour = $minute = $hourWorked_err = $reportId = $supervisorName = "";

if (isset($_GET["appointmentId"])) {
    $appointmentId = $_GET["appointmentId"];
    $reportId =  $_GET["reportId"];
}

//displayables
$employeeClient->displayCurrentAppointmentAssigned($appointmentId);
$appointmentId = $employeeClient->getAppointmentId();

$appointment->getConfirmedAppointmentDetails($appointmentId);
$appointment->getConfirmedDisplayables();
$date = $appointment->getSpecificDate();

$supervisorName = $report->getSupervisorNameByReportID($reportId);



$fullname = $employeeClient->getFullname();
$title = $employeeClient->getServicetitle();
$status = $employeeClient->getAppointmentstatus();

$datesss = $employeeClient->getAppointmentdate();

if ($datesss == null) {
    $datesss = "1999-01-01 08:00:00";
}
$date = date("Y-m-d", strtotime($datesss));
$time = $employeeClient->getAppointmentdate();

$workerIds = array();
$workerHour = array();
$workerMinute = array();





$employeeClient->fetchAppointmentWorkers($appointmentId);
$result = $employeeClient->getAssignedWorkers();
$resultHours = $report->getReportDetails($reportId);

while ($rows = $resultHours->fetch_assoc()) {
    $timestamp = strtotime($rows['hours_worked']);
    $currHours = date("h", $timestamp);
    $currMinutes = date("i", $timestamp);
    array_push($workerHour, $currHours);
    array_push($workerMinute, $currMinutes);
}

$report->getReportedDateTime($reportId);


$datessss = $report->getDateReported();

if ($datessss == null) {
    $datessss = "1999-01-01 08:00:00";
}

$timessss = $report->getTimeReported();

if ($timessss == null) {
    $timessss = "1999-01-01 08:00:00";
}

$dateOnly = date("Y-m-d", strtotime($datessss));
$timeOnly = date('h:i A', strtotime($timessss));
$notes = $report->getNote();



if (isset($_POST['updateReport'])) {
    $appointmentId = $_POST["appointmentId"];
    $reportId = $_POST["reportId"];
    $employeeClient->fetchAppointmentWorkers($appointmentId);

    $result = $employeeClient->getAssignedWorkers();
    $resultHours = $report->getReportDetails($reportId);

    $employeeClient->displayCurrentAppointmentAssigned($appointmentId);
    $appointmentId = $employeeClient->getAppointmentId();
    $fullname = $employeeClient->getFullname();
    $title = $employeeClient->getServicetitle();
    $status = $employeeClient->getAppointmentstatus();
    $date = $employeeClient->getAppointmentdate();
    $time = $employeeClient->getAppointmentdate();
    $supervisorName = $report->getSupervisorNameByReportID($reportId);
    $date = date("Y-m-d", strtotime($employeeClient->getAppointmentdate()));




    $report->getReportedDateTime($reportId);

    $dateOnly = date("Y-m-d", strtotime($report->getDateReported()));
    $timeOnly = date('h:i A', strtotime($report->getTimeReported()));


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

    date_default_timezone_set("America/Vancouver");
    $dateNow = date("Y/m/d");
    $timeNow = date("h:i");

    $notes = $_POST["note"];

    if (empty($hourWorked_err)) {
        $report->editReport($reportId, $workerIds, $workerHour, $workerMinute, $dateNow, $timeNow, $notes);
    }
} else if (isset($_POST['approveReport'])) {

    $appointmentId = $_POST["appointmentId"];
    $reportId = $_POST["reportId"];
    $employeeClient->fetchAppointmentWorkers($appointmentId);

    $result = $employeeClient->getAssignedWorkers();
    $resultHours = $report->getReportDetails($reportId);

    $employeeClient->displayCurrentAppointmentAssigned($appointmentId);
    $appointmentId = $employeeClient->getAppointmentId();
    $fullname = $employeeClient->getFullname();
    $title = $employeeClient->getServicetitle();
    $status = $employeeClient->getAppointmentstatus();
    $date = $employeeClient->getAppointmentdate();
    $time = $employeeClient->getAppointmentdate();
    $supervisorName = $report->getSupervisorNameByReportID($reportId);


    $date = date("Y-m-d", strtotime($employeeClient->getAppointmentdate()));


    $report->getReportedDateTime($reportId);

    $dateOnly = date("Y-m-d", strtotime($report->getDateReported()));
    $timeOnly = date('h:i A', strtotime($report->getTimeReported()));


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

    date_default_timezone_set("America/Vancouver");
    $dateNow = date("Y/m/d");
    $timeNow = date("h:i");

    $notes = $_POST["note"];

    if (empty($hourWorked_err)) {
        $report->approveReport($reportId);
        echo '<script type="text/javascript"> window.location="./index.php";</script>';
    }
} else if (isset($_POST['deleteReport'])) {

    $reportId = $_POST["reportId"];
    $report->deleteReport($reportId);
    echo '<script type="text/javascript"> window.location="./index.php";</script>';
}

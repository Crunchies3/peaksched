<?php
require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/appointments.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/form_validation.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/services.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/customers.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/employees.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/notifMessages.php";

$appointment = new Appointment();
$appointment->setConn($conn);

$validate = new Validation();

$service = new Services();
$service->setConn($conn);

$customerObj = new Customers();
$customerObj->setConn($conn);

$employee = new Employees();
$employee->setConn($conn);

$notification = new NotifMessages();
$notification->setConn($conn);

$serviceList = $service->fetchServiceArr();
$customerList = $customerObj->fetchCustomerArr();
$employeeList = $employee->fetchEmployeeArr();

// echo $serviceList[0]['title'];

$appointmentId = $serviceTitle = $date = $start = $end = $customer = $notes = $supervisor = $customerId = $supervisorId = $service_id = "";



if (isset($_POST['editAppointment'])) {

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    }

    $appointmentId =  trim($_POST["appointmentId"]);

    $serviceTitle =  trim($_POST["selectedService"]);
    $service_id = $service->getIdFromName($serviceTitle);

    $date =  trim($_POST["date"]);
    $start =  trim($_POST["start"]);
    $end =  trim($_POST["end"]);

    $customer =  trim($_POST["selectedCustomer"]);
    $customerId = $customerObj->getIdFromName($customer);

    $notes =  trim($_POST["description"]);

    $supervisor =  trim($_POST["selectedSupervisor"]);
    $supervisorId = $employee->getIdFromName($supervisor);

    $dateTimeStart = $date . " " . date("H:i", strtotime($start));
    $dateTimeEnd = $date . " " . date("H:i", strtotime($start));

    $messageToCustomer = $notification->adminToCustomerEdit($serviceTitle);
    $messageToSupervisor = $notification->adminToSupervisorEdit($serviceTitle);
    $currentDate = date("Y-m-d");
    $unread = true;
    
    $appointment->editAppointmnet($appointmentId, $service_id, $customerId, $supervisorId, $dateTimeStart, $dateTimeEnd, $notes);
    $notification->insertNotif($customerId, $unread, $currentDate, $messageToCustomer);
    $notification->insertNotif($supervisorId, $unread, $currentDate, $messageToSupervisor);
} else if (isset($_POST['addApp'])) {

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    }

    $appointmentId = rand(100000, 200000);
    while (!$appointment->isAppointmentIdUnique($appointmentId)) {
        $appointmentId = rand(100000, 200000);
    }

    $serviceTitle =  trim($_POST["selectedService"]);
    $service_id = $service->getIdFromName($serviceTitle);

    $date =  trim($_POST["date"]);
    $start =  trim($_POST["start"]);
    $end =  trim($_POST["end"]);

    $customer =  trim($_POST["selectedCustomer"]);
    $customerId = $customerObj->getIdFromName($customer);

    $notes =  trim($_POST["description"]);

    $supervisor =  trim($_POST["selectedSupervisor"]);
    $supervisorId = $employee->getIdFromName($supervisor);

    $dateTimeStart = $date . " " . date("H:i", strtotime($start));
    $dateTimeEnd = $date . " " . date("H:i", strtotime($start));

    $messageToCustomer = $notification->adminToCustomerAppointment($serviceTitle,$date);
    $messageToSupervisor = $notification->adminToSupervisorAppointment($serviceTitle);
    $currentDate = date("Y-m-d");
    $unread = true;

    $appointment->addAppointmnet($appointmentId, $service_id, $customerId, $supervisorId, $dateTimeStart, $dateTimeEnd, $notes);
    $notification->insertNotif($customerId, $unread, $currentDate, $messageToCustomer);
    $notification->insertNotif($supervisorId, $unread, $currentDate, $messageToSupervisor);
} else if (isset($_POST['deleteAppointment'])) {

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    }

    $appointmentId =  trim($_POST["appointmentId"]);

    $serviceTitle =  trim($_POST["selectedService"]);
    $customer =  trim($_POST["selectedCustomer"]);
    $customerId = $customerObj->getIdFromName($customer);
    $supervisor =  trim($_POST["selectedSupervisor"]);
    $supervisorId = $employee->getIdFromName($supervisor);


    $date =  trim($_POST["date"]);
    $messageToCustomer = $notification->adminToCustomerDelete($serviceTitle,$date);
    $messageToSupervisor = $notification->adminToSupervisorDelete($serviceTitle,$date);
    $currentDate = date("Y-m-d");
    $unread = true;

    $appointment->deleteAppointmnet($appointmentId);
    $notification->insertNotif($customerId, $unread, $currentDate, $messageToCustomer);
    $notification->insertNotif($supervisorId, $unread, $currentDate, $messageToSupervisor);
}

<?php
require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/appointments.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/form_validation.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/services.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/customers.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/address.php";

$appointments = new Appointment();
$appointments->setConn($conn);

$validate = new Validation();

$serviceObj = new Services();
$serviceObj->setConn($conn);

$customerObj = new Customers();
$customerObj->setConn($conn);

$addressObj = new Address();
$addressObj->setConn($conn);


$appointmentId = "";

if (isset($_GET["appointmentId"])) {
    $appointmentId = $_GET["appointmentId"];
}

$appointments->getAppointmentDetails($appointmentId);

// initial displayables
$customerId = $appointments->getCustomerId();
$customerObj->displayCurrentCustomer($customerId);
$customerName = $customerObj->getFirstname() . ' ' . $customerObj->getLastname();

$serviceId = $appointments->getServiceId();
$serviceObj->displayCurrentService($serviceId);
$service = $serviceObj->getTitle();

$addressId =  $appointments->getAddressId();
$addressObj->getAddressById($addressId);
$address = $addressObj->getStreet() . '. ' . $addressObj->getCity() . ', ' . $addressObj->getProvince() . '. ' . $addressObj->getCountry() . ', ' . $addressObj->getZip_code();

$date = $appointments->getStart();
$dateOnly = date("Y-m-d", strtotime($date));
$timeOnly = date('h:i A', strtotime($date));

<?php
require_once "config.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/customer_account.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/form_validation.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/services.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/address.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/appointments.php";

$customer = unserialize($_SESSION["customerUser"]);
$customer->setConn($conn);

$address = new Address();
$address->setConn($conn);

$appointment = new Appointment();
$appointment->setConn($conn);

$service_id = $serviceName = $typeOfUnit = $numOfBeds = $numOfBath = $selectedAddress = $selectedDate = $selectedTime = $note = $requestAppointmentId = "";
$address_Err = $typeOfUnit_err = $numOfBath_err = $numOfBeds_err = $selectedDate_err = $selectedTime_err = "";


$customerId = $customer->getId();

$address_list = $address->fetchAddressArr($customerId);

if (isset($_GET["serviceId"])) {
    $service_id = $_GET["serviceId"];
}

$services = new Services();
$services->setConn($conn);

$validate = new Validation();
$services->displayCurrentService($service_id);

$serviceName = $services->getTitle();


if (isset($_POST['submitRequest'])) {

    $requestAppointmentId = rand(100000, 200000);
    while (!$appointment->isRequestAppointmentIdUnique($requestAppointmentId)) {
        $requestAppointmentId = rand(100000, 200000);
    }

    $service_id = $_POST['serviceId'];
    $services->displayCurrentService($service_id);
    $serviceName = $services->getTitle();

    $address_Err = $validate->selectedAddress($selectedAddress);

    $selectedAddress = $_POST['selectedAddress'];
    $address_Err = $validate->selectedAddress($selectedAddress);
    if (empty($address_Err)) {
        $addressId = $address->getIdByName($selectedAddress);
    }


    if (isset($_POST['numberOfFloors'])) {
        $typeOfUnit = $_POST['numberOfFloors'];
    }
    $typeOfUnit_err = $validate->radioButton($typeOfUnit);

    if (isset($_POST['numberOfBeds'])) {
        $numOfBeds = $_POST['numberOfBeds'];
    }
    $numOfBeds_err = $validate->radioButton($numOfBeds);


    if (isset($_POST['numberOfBathrooms'])) {
        $numOfBath = $_POST['numberOfBathrooms'];
    }
    $numOfBath_err = $validate->radioButton($numOfBath);


    if (isset($_POST['selectedDate'])) {
        $selectedDate = $_POST['selectedDate'];
    }
    $selectedDate_err = $validate->radioButton($selectedDate);

    $note = $_POST['note'];

    if (isset($_POST['options'])) {
        $selectedTime = $_POST['options'];
    }
    $selectedTime_err = $validate->radioButton($selectedTime);

    $status = 'PENDING APPROVAL';

    $dateTimeStart = $selectedDate . " " . date("H:i", strtotime($selectedTime));
    $dateTimeEnd = $selectedDate . " " . date("H:i", strtotime($selectedTime));

    if (empty($address_Err) && empty($typeOfUnit_err) && empty($numOfBath_err) && empty($numOfBeds_err) && empty($selectedDate_err) && empty($selectedTime_err)) {
        $appointment->addRequestAppointment($requestAppointmentId, $service_id, $addressId, $customerId, $typeOfUnit, $numOfBeds, $numOfBath, $dateTimeStart, $dateTimeEnd, $note, $status);
        header("location: request-appointment-succes.php");
    }
}

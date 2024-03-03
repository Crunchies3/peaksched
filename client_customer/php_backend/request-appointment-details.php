<?php
require_once "config.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/customer_account.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/form_validation.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/services.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/address.php";

$address = new Address();
$address->setConn($conn);

$service_id = $serviceName = $typeOfUnit = $numOfBeds = $numOfBath = $selectedAddress = $selectedDate = $selectedTime = "";



$address_list = $address->fetchAddressArr();

if (isset($_GET["serviceId"])) {
    $service_id = $_GET["serviceId"];
}

$services = new Services();
$services->setConn($conn);

$validate = new Validation();
$services->displayCurrentService($service_id);

$serviceName = $services->getTitle();


if (isset($_POST['submitRequest'])) {
    $service_id = $_POST['serviceId'];
    $services->displayCurrentService($service_id);
    $serviceName = $services->getTitle();

    $selectedAddress = $_POST['selectedAddress'];
    $typeOfUnit = $_POST['numberOfFloors'];
    $numOfBeds = $_POST['numberOfBeds'];
    $numOfBath = $_POST['numberOfBathrooms'];
    $selectedDate = $_POST['selectedDate'];
    $selectedTime = $_POST['options'];
}

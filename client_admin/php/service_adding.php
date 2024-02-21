<?php

require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/admin_account.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/form_validation.php";

$admin = unserialize($_SESSION["adminUser"]);
$admin->setConn($conn);

$validate = new Validation();

$serviceTitle = $serviceTitle_err =  $duration = $duration_err = $price = $price_err = $description = $color = "";


if ($_SERVER["REQUEST_METHOD"] != "POST") {
    return;
}

$service_id = rand(100000, 200000);

while (!$admin->isServiceIdUnique($service_id)) {
    $service_id = rand(100000, 200000);
}

$serviceTitle = trim($_POST["serviceTitle"]);
$serviceTitle_err = $validate->serviceTitle($serviceTitle);

$description =  trim($_POST["description"]);
$color = "#124F6F";


$duration = trim($_POST["duration"]);
$duration_err = $validate->serviceDuration($duration);

$price = trim($_POST["price"]);
$price_err = $validate->servicePrice($price);


if (empty($serviceTitle_err) && empty($duration_err) && empty($price_err)) {
    $admin->addService($service_id, $serviceTitle, $color,  $description, $duration, $price);
}

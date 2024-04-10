<?php

require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/admin_account.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/form_validation.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/services.php";

$admin = unserialize($_SESSION["adminUser"]);
$admin->setConn($conn);

$services = new Services();
$services->setConn($admin->getConn());

$validate = new Validation();


$serviceTitle = $serviceTitle_err =  $duration = $duration_err = $price = $price_err = $description = $color = $service_id = "";


// kuhaon niya ang service id na naa sa link
// Sundoga tong naa sa reset_password.php

if (isset($_GET["serviceId"])) {
    $service_id = $_GET["serviceId"];
}


//displayables
$services->displayCurrentService($service_id);

$serviceTitle = $services->getTitle();
$duration = $services->getDuration();
$price = $services->getPrice();
$description = $services->getDescription();
$color = $services->getColor();





if (isset($_POST['editService'])) {

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    }

    $service_id = $_POST["serviceId"];


    $serviceTitle = trim($_POST["serviceTitle"]);
    $serviceTitle_err = $validate->serviceTitle($serviceTitle);

    $description =  trim($_POST["description"]);

    $color = $_POST["selectedColor"];

    $duration = trim($_POST["duration"]);
    $duration_err = $validate->serviceDuration($duration);

    $price = trim($_POST["price"]);
    $price_err = $validate->servicePrice($price);

    if (empty($serviceTitle_err) && empty($duration_err) && empty($price_err)) {
        $services->updateServiceDetails($serviceTitle, $color,  $description, $duration, $price, $service_id);
        header("location: ./services_page.php");
    }
} else if (isset($_POST['deleteAccount'])) {
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    }
    $service_id = $_POST["serviceId"];
    $services->deleteService($service_id);
    header("location: ./services_page.php");
}

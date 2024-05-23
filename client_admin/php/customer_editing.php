<?php

require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/customer_account.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/form_validation.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/customers.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/address.php";



$customerAcc = new CustomerAccount($conn);
$customer = new Customers();
$customer->setConn($customerAcc->getConn());

$validate = new Validation();
$validate->setUserType($customerAcc);

$address = new Address();
$address->setConn($conn);

$firstName = $firstName_err =  $lastName = $lastName_err = $email = $email_err  = $mobileNumber = $mobileNumber_err = "";
$customerId = "";
$password = $newPassword = $confirmPassword = $newHashedPassword = "";
$newPassword_err = $confirmPassword_err = "";

// address related variables.

$street = $city = $province = $country = $zipCode = "";
$street_err = $city_err = $province_err = $country_err = $zipCode_err = "";


if (isset($_GET["customerId"])) {
    $customerId = $_GET["customerId"];
}


//displayables
$customer->displayCurrentCustomer($customerId);
$firstName = $customer->getFirstname();
$lastName = $customer->getLastname();
$email = $customer->getEmail();
$mobileNumber = $customer->getMobilenumber();

$customersAppointmentList = $customer->fetchCustomerAppointment($customerId);
$address->fetchCustomerPrimaryAddress($customerId);

$addressId = $address->getAddress_id();
$street = $address->getStreet();
$city = $address->getCity();
$province = $address->getProvince();
$country = $address->getCountry();
$zipCode = $address->getZip_code();






if (isset($_POST['updateInfo'])) { //! para mag update sa details like name

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    };

    $customerId = $_POST["customerId"];

    $customer->displayCurrentCustomer($customerId);
    $firstName = $customer->getFirstname();
    $lastName = $customer->getLastname();
    $email = $customer->getEmail();
    $mobileNumber = $customer->getMobilenumber();

    $customersAppointmentList = $customer->fetchCustomerAppointment($customerId);
    $address->fetchCustomerPrimaryAddress($customerId);

    $addressId = $address->getAddress_id();
    $street = $address->getStreet();
    $city = $address->getCity();
    $province = $address->getProvince();
    $country = $address->getCountry();
    $zipCode = $address->getZip_code();



    $firstName = trim($_POST["firstName"]);
    $firstName_err = $validate->firstName($firstName);

    $lastName = trim($_POST["lastName"]);
    $lastName_err = $validate->firstName($lastName);

    $email = trim($_POST["email"]);
    $email_err = $validate->emailEmptyDoesNotExist($email);

    $mobileNumber = trim($_POST["mobile"]);
    $mobileNumber_err = $validate->mobileNumber($mobileNumber);



    if (empty($firstname_err) && empty($lastName_err) && empty($email_err) && empty($mobileNumber_err)) {
        $customer->updateCustomerDetails($firstName, $lastName,  $email, $mobileNumber, $customerId);
        echo "<script type='text/javascript'> window.location='customer_editing_page.php?customerId=$customerId';</script>";
    }
} else if (isset($_POST['changePassword'])) {  //! para mag change pass

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    }
    $customerId = $_POST["customerId"];

    $customer->displayCurrentCustomer($customerId);
    $firstName = $customer->getFirstname();
    $lastName = $customer->getLastname();
    $email = $customer->getEmail();
    $mobileNumber = $customer->getMobilenumber();

    $customersAppointmentList = $customer->fetchCustomerAppointment($customerId);
    $address->fetchCustomerPrimaryAddress($customerId);

    $addressId = $address->getAddress_id();
    $street = $address->getStreet();
    $city = $address->getCity();
    $province = $address->getProvince();
    $country = $address->getCountry();
    $zipCode = $address->getZip_code();


    $newPassword = trim($_POST["newPassword"]);
    $newPassword_err = $validate->validatePassword($newPassword);
    $newHashedPassword = $customerAcc->getHashedPassword();

    $confirmPassword = trim($_POST["confirmPassword"]);
    $confirmPassword_err = $validate->confirmPassword($confirmPassword, $newPassword);

    if (empty($newPassword_err) && empty($confirmPassword_err)) {
        $customer->changeCustomerPassword($newHashedPassword, $customerId);
        //faulty to be continued..
        echo "<script type='text/javascript'> window.location='customer_editing_page.php?customerId=$customerId';</script>";
    }
} else if (isset($_POST['deleteAccount'])) { //! para mag delete ug account
    //pareha ra ang change pass ug delete account ug form maong giani
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    }
    $customerId = $_POST["customerId"];
    $customer->deleteCustomer($customerId);
    echo '<script type="text/javascript"> window.location="./customer_page.php";</script>';
} else if (isset($_POST['editAddress'])) { //! para mag edit sa address

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    }

    $customerId = $_POST["customerId"];

    $customer->displayCurrentCustomer($customerId);
    $firstName = $customer->getFirstname();
    $lastName = $customer->getLastname();
    $email = $customer->getEmail();
    $mobileNumber = $customer->getMobilenumber();

    $customersAppointmentList = $customer->fetchCustomerAppointment($customerId);
    $address->fetchCustomerPrimaryAddress($customerId);

    $addressId = $address->getAddress_id();
    $street = $address->getStreet();
    $city = $address->getCity();
    $province = $address->getProvince();
    $country = $address->getCountry();
    $zipCode = $address->getZip_code();


    $street = trim($_POST["street"]);
    $street_err = $validate->address($street);

    $city = trim($_POST["city"]);
    $city_err = $validate->address($city);

    $province = trim($_POST["province"]);
    $province_err = $validate->address($province);

    $country = trim($_POST["country"]);
    $country_err = $validate->address($country);

    $zipCode = trim($_POST["zipCode"]);

    if (empty($street_err) && empty($city_err) && empty($province_err) && empty($country_err)) {
        $address->updateAddress($addressId, $street, $city, $province, $zipCode, $country);
        echo "<script type='text/javascript'> window.location='customer_editing_page.php?customerId=$customerId';</script>";
    }
}

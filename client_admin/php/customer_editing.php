<?php

require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/customer_account.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/form_validation.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/customers.php";



$customerAcc = new CustomerAccount($conn);
$customer = new Customers();
$customer->setConn($customerAcc->getConn());

$validate = new Validation();
$validate->setUserType($customerAcc);

$firstName = $firstName_err =  $lastName = $lastName_err = $email = $email_err  = $mobileNumber = $mobileNumber_err = "";
$customerId = "";
$password = $newPassword = $confirmPassword = $newHashedPassword="";
$newPassword_err = $confirmPassword_err = "";
// kuhaon niya ang service id na naa sa link
// Sundoga tong naa sa reset_password.php

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






if (isset($_POST['updateInfo'])) { //! para mag update sa details like name

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    };

    $customerId = $_POST["customerId"];


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
        header("location: ./customer_page.php");
    }
} else if (isset($_POST['changePassword'])) {  //! para mag change pass

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    }
    $customerId = $_POST["customerId"];
    $newPassword = trim($_POST["newPassword"]);
    $newPassword_err = $validate->validatePassword($newPassword);
    $newHashedPassword = $customerAcc->getHashedPassword();

    $confirmPassword = trim($_POST["confirmPassword"]);
    $confirmPassword_err = $validate->confirmPassword($confirmPassword, $newPassword);

    if (empty($newPassword_err) && empty($confirmPassword_err)) {
        $customer->changeCustomerPassword($newHashedPassword,$customerId);
        //faulty to be continued..
        header("location: ./customer_page.php");
    }


} else if (isset($_POST['deleteAccount'])) { //! para mag delete ug account
    //pareha ra ang change pass ug delete account ug form maong giani
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    }
    $customerId = $_POST["customerId"];
        $customer->deleteCustomer($customerId);
        header("location: ./customer_page.php");
    
}

<?php
require_once "config.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/admin_account.php";


$adminAccount = new AdminAccount($conn);
$admin = unserialize($_SESSION["adminUser"]);

$firstName = $admin->getFirstName();
$lastName = $admin->getLastName();
$email = $admin->getEmail();
$mobileNumber = $admin->getMobileNumber();
$password = $admin->getHashedPassword();
$adminid = $admin->getId();

if (isset($_POST['updateInfo'])) {
    updateDetails();
} else if (isset($_POST['changePassword'])) {
    changePassword();
}


function updateDetails()
{
    global $firstName_err, $lastName_err, $emailAddress_err, $mobileNumber_err, $changed_err;
    global $newFirstName, $newLastName, $newEmailAddress, $newMobileNumber;
    global $firstName,$lastName,$email,$mobileNumber,$admin, $adminid,$adminAccount;

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    }

    $newFirstName = trim($_POST["firstName"]);

    if (empty($newFirstName)) {
        $firstName_err = "Please enter your first name.";
    }

    $newLastName = trim($_POST["lastName"]);

    if (empty($newLastName)) {
        $lastName_err = "Please enter your last name.";
    }

    $newEmailAddress = trim($_POST["email"]);

    if (empty($newEmailAddress)) {
        $emailAddress_err = "Please enter an email address";
    } else if (!filter_var($newEmailAddress, FILTER_VALIDATE_EMAIL)) {
        $emailAddress_err = "Please enter a valid email address";
    }


    $newMobileNumber = trim($_POST["mobile"]);

    if (empty($newMobileNumber)) {
        $mobileNumber_err = "Please enter your mobile number.";
    } else if (!is_numeric($newMobileNumber)) {
        $mobileNumber_err = "Please enter a valid mobile number.";
    }

    if($newFirstName == $firstName && $newLastName == $lastName && $newEmailAddress == $email && $newMobileNumber == $mobileNumber){
        //kamo na bahala kung idisplay pa ninyo ni nga error or dli na, 
        $changed_err = "Nothing has changed";
    }

    if (empty($firstName_err) && empty($lastName_err) && empty($emailAddress_err) && empty($mobileNumber_err) && empty($changed_err)) {
        $adminAccount->updateUserDetails($newFirstName,$newLastName,$newEmailAddress,$newMobileNumber,$adminid);
        $firstName = $newFirstName;
        $lastName = $newLastName;
        $email = $newEmailAddress;
        $mobileNumber = $newMobileNumber;
        $admin->setFirstname($newFirstName);
        $admin->setLastName($newLastName);
        $admin->setEmail($newEmailAddress);
        $admin->setMobileNumebr($newMobileNumber);
        $_SESSION["adminUser"] = serialize($admin);
    }
}

function changePassword()
{
    global $currentPassword_err, $newPassword_err, $confirmPassword_err;
    global $currentPassword, $password, $newPassword, $confirmPassword, $newHashedPassword, $admin, $adminid,$adminAccount;


    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    }

    $currentPassword = trim($_POST["currentPassword"]);

    if (!password_verify($currentPassword, $password)) {
        $currentPassword_err = "Incorrect Current Password";
    }

    $newPassword = trim($_POST["newPassword"]);
    $newPassword_err = $admin->validatePassword($newPassword);
    if (empty($password_err)) {
        $newHashedPassword = $admin->getHashedPassword();
    }

    $confirmPassword = trim($_POST["confirmPassword"]);
    if (empty($confirmPassword)) {
        $confirmPassword_err = "Please enter a password.";
    } else if ($confirmPassword != $newPassword) {
        $confirmPassword_err = "Password does not match.";
    }
    if (empty($currentPassword_err) && empty($newPassword_err) && empty($confirmPassword_err)) {
        $adminAccount->changeUserPassword($newHashedPassword,$adminid);
    }
}

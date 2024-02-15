<?php
require_once '/xampp/htdocs/PeakSched/client_employee/php/config.php';
require_once '/xampp/htdocs/PeakSched/class/employee_account.php';
$emailAddress = "";

$emailAddress_err = "";

$visibility = "hidden";
//gibutngan lang nako ug "worker" na parameter cy para madawat pero wala sya nako gipuslan sa forgot pass/reset pass kay sa email man japon dependent
$employeeAccount = new EmployeeAccount($conn,"worker");

validateInputs();

function validateInputs()
{
    global $emailAddress, $employeeAccount, $emailAddress_err, $visibility;

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    }

    $token = bin2hex(random_bytes(16));
    $tokenHash = $employeeAccount->getHashedToken($token);

    $expiry = date("Y-m-d H:i:s", time() + 60 * 30);

    $emailAddress = trim($_POST["email"]);
    if (empty($emailAddress)) {
        $emailAddress_err = "Please enter your email address.";
    } else if (!$employeeAccount->doesEmailExist($emailAddress)) {
        $emailAddress_err = "Email address does not exist";
    }


    if (empty($emailAddress_err)) {
        $employeeAccount->addResetToken($tokenHash, $expiry, $emailAddress);
        $employeeAccount->sendForgotPasswordLink($emailAddress, $token);
        $visibility = "";
    }
}
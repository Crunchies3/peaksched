<?php

require_once "./config.php";

$firstName = $lastName = $emailAddress = $mobileNumber = $password = $confirmPassword = "";

// variables that will hold error messages
$firstName_err = $lastName_err = $emailAddress_err = $mobileNumber_err = $password_err = $confirmPassword_err = "";

validateInputs();



function validateInputs()
{
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
    }

    // validate firstname
    $firstName = trim($_POST["firstName"]);

    if (empty($firstName)) {
        $firstName_err = "Please enter your first name.";
    }

    // validate lastname
    $lastName = trim($_POST["lastName"]);

    if (empty($lastName)) {
        $firstName_err = "Please enter your last name.";
    }

    $emailAddress = trim($_POST["lastName"]);
}

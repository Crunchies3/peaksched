<?php
    require_once '/php/htdocs/website/PeakSched/client_customer/php/config.php';
    $firstName = $lastName = $emailAddress = $mobileNumber = $password = $confirmPassword =  $adminId = $hashedPassword = "";

    // variables that will hold error messages
    $firstName_err = $lastName_err = $emailAddress_err = $mobileNumber_err = $password_err = $confirmPassword_err = "";

    validateInputs();

    function validateInputs()
    {
        global $firstName_err, $lastName_err, $emailAddress_err, $mobileNumber_err, $password_err, $confirmPassword_err;
        global $firstName, $lastName, $emailAddress, $mobileNumber, $password, $confirmPassword, $adminId, $hashedPassword;
    
        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            return;
        }
    
        $adminId = rand(100000, 200000);
    
        while (!isAdminIdUnique($adminId)) {
            $adminId = rand(100000, 200000);
        }
    
        // validate firstname
        $firstName = trim($_POST["firstName"]);
    
        if (empty($firstName)) {
            $firstName_err = "Please enter your first name.";
        }
    
        $lastName = trim($_POST["lastName"]);
    
        if (empty($lastName)) {
            $lastName_err = "Please enter your last name.";
        }
    
        if (empty(trim($_POST["email"]))) {
            $emailAddress_err = "Please enter your email address.";
        } else if (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
            $emailAddress_err = "Please enter a valid email address";
        } else if (!isAdminEmailUnique(trim($_POST["email"]))) {
            $emailAddress_err = "Email already exist";
        } else {
            $emailAddress = trim($_POST["email"]);
        }
    
        $mobileNumber = trim($_POST["mobile"]);
    
        if (empty($mobileNumber)) {
            $mobileNumber_err = "Please enter your mobile number.";
        } else if (!is_numeric($mobileNumber)) {
            $mobileNumber_err = "Please enter a valid mobile number.";
        }
    
        $password = trim($_POST["password"]);
    
        if (empty($password)) {
            $password_err = "Please enter a password.";
        } else if (strlen($password) < 8) {
            $password_err = "Please enter a password with atleast 8 characters.";
        } elseif (!preg_match("#[0-9]+#", $password)) {
            $password_err = "Your Password Must Contain At Least 1 Number!";
        } elseif (!preg_match("#[A-Z]+#", $password)) {
            $password_err = "Your Password Must Contain At Least 1 Capital Letter!";
        } elseif (!preg_match("#[a-z]+#", $password)) {
            $password_err = "Your Password Must Contain At Least 1 Lowercase Letter!";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        }
    
        $confirmPassword = trim($_POST["confirmPassword"]);
    
        if (empty($confirmPassword)) {
            $confirmPassword_err = "Please enter a password.";
        } else if ($confirmPassword != $password) {
            $confirmPassword_err = "Password does not match.";
        }
    
        if (empty($firstName_err) && empty($lastName_err) && empty($emailAddress_err) && empty($mobileNumber_err) && empty($password_err) && empty($confirmPassword_err)) {
            insertAdminDetailstoDB($adminId, $firstName, $lastName, $emailAddress, $mobileNumber, $hashedPassword);
        }
    }


    function isAdminEmailUnique($email)
{
    global $conn;

    try {
        $stmt = $conn->prepare("SELECT * FROM tbl_admin WHERE email = ?");
        $stmt->bind_param("s", $email);

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $stmt->close();
            return false;
        }
        $stmt->close();
        return true;
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
}

function isAdminIdUnique($adminId)
{
    global $conn;

    try {
        $stmt = $conn->prepare("SELECT * FROM tbl_admin WHERE adminid = ?");
        $stmt->bind_param("s", $adminId);

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $stmt->close();
            return false;
        }
        $stmt->close();
        return true;
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
}

function insertAdminDetailstoDB($adminId, $firstName, $lastName, $emailAddress, $mobileNumber, $hashedPassword)
{
    global $conn;

    try {
        $stmt = $conn->prepare("INSERT INTO tbl_admin (adminid, firstname, lastname, email, mobilenumber, password) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param("ssssss", $adminId, $firstName, $lastName, $emailAddress, $mobileNumber, $hashedPassword);
        $stmt->execute();
        $stmt->close();
        header("location: login.php");
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
    $conn->close();
}
?>
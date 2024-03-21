<?php

class Validation
{
    protected $userType;

    public function getUserType()
    {
        return $this->userType;
    }

    public function setUserType($userType)
    {
        $this->userType = $userType;
    }

    public function validatePassword($password)
    {
        if (empty($password)) {
            return "Please enter a password.";
        } else if (strlen($password) < 8) {
            return "Please enter a password with atleast 8 characters.";
        } elseif (!preg_match("#[0-9]+#", $password)) {
            return "Your Password Must Contain At Least 1 Number!";
        } elseif (!preg_match("#[A-Z]+#", $password)) {
            return "Your Password Must Contain At Least 1 Capital Letter!";
        } elseif (!preg_match("#[a-z]+#", $password)) {
            return "Your Password Must Contain At Least 1 Lowercase Letter!";
        } else {
            $this->userType->setHashedPassword(password_hash($password, PASSWORD_DEFAULT));
            return "";
        }
    }
    public function validateEmail($email)
    {

        if (empty($email)) {
            return "Please enter your email address.";
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Please enter a valid email address";
        } else if (!$this->userType->isEmailUnique($email)) {
            return "Email already exist";
        } else {
            $this->userType->setEmail($email);
            return "";
        }
    }

    public function firstName($firstname)
    {
        if (empty($firstname)) {
            return "Please enter your first name.";
        } else {
            return "";
        }
    }

    public function payrate($payrate)
    {
        if (empty($payrate)) {
            return "Please enter the payrate.";
        } else {
            return "";
        }
    }


    public function position($position)
    {
        if (empty($position)) {
            return "Please enter the position.";
        } else {
            return "";
        }
    }





    public function time($time)
    {
        if (empty($time)) {
            return "Enter a value";
        } else {
            return "";
        }
    }


    public function lastName($lastname)
    {
        if (empty($lastname)) {
            return "Please enter your last name.";
        } else {
            return "";
        }
    }
    public function emailEmptyDoesNotExist($email)
    {
        if (empty($email)) {
            return "Please enter your email address.";
        } else if (!$this->userType->doesEmailExist($email)) {
            return "Email address does not exist";
        } else {
            return "";
        }
    }
    public function passwordEmpty($password)
    {
        if (empty($password)) {
            return "Please enter your password.";
        } else {
            return "";
        }
    }

    public function address($string)
    {
        if (empty($string)) {
            return "This field is required.";
        } else {
            return "";
        }
    }

    public function mobileNumber($mobile)
    {
        if (empty($mobile)) {
            return "Please enter your mobile number.";
        } else if (!is_numeric($mobile)) {
            return "Please enter a valid mobile number.";
        } else {
            return "";
        }
    }

    public function confirmPassword($confirmPassword, $password)
    {
        if (empty($confirmPassword)) {
            return "Please enter a password.";
        } else if ($confirmPassword != $password) {
            return "Password does not match.";
        } else {
            return "";
        }
    }

    //specific rani nga error handler sa profile_account o settings_account
    public function currentPassword($currentPassword, $password)
    {
        if (empty($currentPassword)) {
            return "Please enter a password.";
        } else if (!password_verify($currentPassword, $password)) {
            return "Incorrect Current Password";
        } else {
            return "";
        }
    }

    //reset_password exclusive error handler
    public function tokenHash($tokenHash, &$status)
    {
        if (!$this->userType->doesTokenExist($tokenHash)) {
            $status = "disabled";
            return "Invalid reset link";
        } else if (strtotime($this->userType->getTokenExpiry()) <= time()) {
            $status = "disabled";
            return "Expired reset link";
        } else {
            return "";
        }
    }

    public function serviceTitle($title)
    {
        if (empty($title)) {
            return "Please enter a service title.";
        } else {
            return "";
        }
    }

    public function serviceDuration($duration)
    {
        if (empty($duration)) {
            return "Please enter service duration.";
        } else {
            return "";
        }
    }
    public function servicePrice($price)
    {
        if (empty($price)) {
            return "Please enter service price.";
        } else {
            return "";
        }
    }

    public function selectedAddress($address)
    {
        if (empty($address)) {
            return "Please select an address.";
        } else {
            return "";
        }
    }

    public function radioButton($count)
    {
        if (empty($count)) {
            return "This field is required";
        } else {
            return "";
        }
    }
    public function supervisorChoose($supervisorName)
    {
        if (empty($supervisorName)) {
            return "Please select a supervisor to assign";
        } else {
            return "";
        }
    }
}

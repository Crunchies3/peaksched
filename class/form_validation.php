<?php

  class Validation
 {
    public function firstName($firstname)
    {
        if (empty($firstname)) {
            return "Please enter your first name.";
        }else{
            return "";
        }
    }

    public function lastName($lastname)
    {
        if (empty($lastname)) {
            return "Please enter your last name.";
        }else{
            return "";
        }
    }
    public function emailEmpty($email)
    {
        if (empty($email)) {
            return "Please enter your email address.";
        }else{
            return "";
        }
    }
    public function passwordEmpty($password)
    {
        if (empty($password)) {
            return "Please enter your password.";
        }else{
            return "";
        }
    }

    public function mobileNumber($mobile)
    {
        if (empty($mobile)) {
            return "Please enter your mobile number.";
        } else if (!is_numeric($mobile)) {
            return "Please enter a valid mobile number.";
        }else{
            return "";
        }
    }

    public function confirmPassword($confirmPassword, $password)
    {
        if (empty($confirmPassword)) {
            return "Please enter a password.";
        } else if ($confirmPassword != $password) {
            return "Password does not match.";
        }else{
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
        }else{
            return "";
        }
    }


 }




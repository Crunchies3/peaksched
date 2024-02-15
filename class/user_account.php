<?php

abstract class UserAccount
{
    protected $conn;
    protected $id;
    protected $email;
    protected $firstName;
    protected $lastName;
    protected $mobileNumber;
    protected $hashedPassword;
    protected $tokenExpiry;


    abstract public function login($email, $password);
    abstract public function register($customerId, $firstName, $lastName, $emailAddress, $mobileNumber, $hashedPassword);
    abstract public function isIdUnique($id);
    abstract public function isEmailUnique($email);
    abstract public function doesEmailExist($email);
    abstract public function addResetToken($tokenHash, $expiry, $email);
    abstract public function sendForgotPasswordLink($email, $token);
    abstract public function doesTokenExist($tokenHash);


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
            $this->setHashedPassword(password_hash($password, PASSWORD_DEFAULT));
            return "";
        }
    }

    public function validateEmail($email)
    {

        if (empty($email)) {
            return "Please enter your email address.";
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Please enter a valid email address";
        } else if (!$this->isEmailUnique($email)) {
            return "Email already exist";
        } else {
            $this->setEmail($email);
            return "";
        }
    }

    // *Getter
    public function getEmail()
    {
        return $this->email;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getHashedPassword()
    {
        return $this->hashedPassword;
    }

    public function getHashedToken($token)
    {
        return hash("sha256", $token);
    }

    public function getTokenExpiry()
    {
        return $this->tokenExpiry;
    }

    public function getFirstname()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getMobileNumebr()
    {
        return $this->mobileNumber;
    }

    // *Setter

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setFirstname($firstName)
    {
        $this->firstName = $firstName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function setMobileNumebr($mobileNumber)
    {
        $this->mobileNumber = $mobileNumber;
    }

    public function setHashedPassword($hashedPassword)
    {
        $this->hashedPassword = $hashedPassword;
    }
}

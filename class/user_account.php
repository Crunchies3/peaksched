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
    abstract public function doesTokenExist($tokenHash);
    abstract public function forgotResetPassword($hashedPassword, $id);
    abstract public function updateUserDetails($newFirstName, $newLastName, $newEmailAddress, $newMobileNumber);
    abstract public function changeUserPassword($newHashedPassword);







    // *Getter
    public function getConn()
    {
        return $this->conn;
    }
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

    public function getMobileNumber()
    {
        return $this->mobileNumber;
    }



    // *Setter

    public function setConn($conn)
    {
        $this->conn = $conn;
    }


    public function setId($id)
    {
        $this->id = $id;
    }

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

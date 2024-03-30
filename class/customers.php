<?php


class Customers
{
    private $conn;
    private $customerList;
    private $firstname;
    private $lastname;
    private $email;
    private $mobilenumber;


    public function fetchCustomerArr()
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM tbl_customer");
            $stmt->execute();
            $result = $stmt->get_result();

            $customerList = array();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($customerList, $row);
                }
            }
            return $customerList;
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function getIdFromName($name)
    {
        try {
            $stmt = $this->conn->prepare(
                "SELECT customerid
                FROM tbl_customer 
                WHERE concat(firstname, ' ' , lastname) = ?;"
            );
            $stmt->bind_param("s", $name);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $id = $row["customerid"];
                }
            }
            return $id;
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
    //view
    public function fetchCustomerList()
    {
        try {
            $stmt = $this->conn->prepare("SELECT*FROM tbl_customer");
            $stmt->execute();
            $result = $stmt->get_result();
            $this->customerList = $result;
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
    //view when editing
    public function displayCurrentCustomer($customerId)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM tbl_customer WHERE customerid = ?");
            $stmt->bind_param("s", $customerId);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $this->setFirstname($row["firstname"]);
                    $this->setLastname($row["lastname"]);
                    $this->setEmail($row["email"]);
                    $this->setMobilenumber($row["mobilenumber"]);
                }
            }
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
    //add
    public function addCustomer($firstName, $lastName, $email, $mobileNumber, $customerid, $tempPassword)
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO tbl_customer (customerid, firstname, lastname, email, mobileNumber, password) VALUES (?,?,?,?,?,?)");
            $stmt->bind_param("ssssss", $customerid, $firstName, $lastName, $email, $mobileNumber, $tempPassword);
            $stmt->execute();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
    //edit
    public function updateCustomerDetails($firstName, $lastName, $email, $mobileNumber, $customerId,)
    {
        try {
            $stmt = $this->conn->prepare("UPDATE tbl_customer SET firstname = ? , lastname = ? ,email = ? ,mobilenumber = ? WHERE customerid = ?");
            $stmt->bind_param("sssss", $firstName, $lastName, $email, $mobileNumber, $customerId);
            $stmt->execute();
            $this->conn->close();

            $this->setFirstname($firstName);
            $this->setLastname($lastName);
            $this->setEmail($email);
            $this->setMobilenumber($mobileNumber);
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
    //change customer pass
    public function changeCustomerPassword($newHashedPassword, $customerId)
    {

        try {
            $stmt = $this->conn->prepare("UPDATE tbl_customer SET password = ? WHERE customerid = ?");
            $stmt->bind_param("ss", $newHashedPassword, $customerId);
            $stmt->execute();
            $this->conn->close();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
    public function deleteCustomer($customerId)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM tbl_customer WHERE customerid = ?");
            $stmt->bind_param("s", $customerId);
            $stmt->execute();
            $this->conn->close();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
    public function fetchCustomerAppointment($customerId)
    {
        try {
            $stmt = $this->conn->prepare(
                "SELECT a.appointment_id,
                        CONCAT(b.firstname,' ',b.lastname) AS 'fullname',
                        c.title,
                        a.status,
                        DATE(a.start) AS 'date',
                        DATE_FORMAT(a.start, '%h:%i %p') AS 'time'
                FROM tbl_confirmed_appointment a,
                     tbl_customer b,
                     tbl_service c
                WHERE a.customer_id = b.customerid AND
                      a.service_id = c.service_id AND
                      a.customer_id = ?"
            );
            $stmt->bind_param("s", $customerId);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }


    /**
     * Get the value of conn
     */
    public function getConn()
    {
        return $this->conn;
    }
    public function getCustomerList()
    {
        return $this->customerList;
    }
    public function getFirstname()
    {
        return $this->firstname;
    }
    public function getLastname()
    {
        return $this->lastname;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getMobilenumber()
    {
        return $this->mobilenumber;
    }

    /**
     * Set the value of conn
     *
     * @return  self
     */
    public function setConn($conn)
    {
        $this->conn = $conn;

        return $this;
    }
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }
    public function setMobilenumber($mobilenumber)
    {
        $this->mobilenumber = $mobilenumber;

        return $this;
    }
}

<?php


class Employees
{
    private $conn;
    private $firstname;
    private $lastname;
    private $position; //type ni cy karon ra nako narealize
    private $email;
    private $mobilenumber;
    private $employeeList;
    public function fetchEmployeeArr()
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM tbl_employee WHERE type = 'supervisor'");
            $stmt->execute();
            $result = $stmt->get_result();

            $employeeList = array();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($employeeList, $row);
                }
            }
            return $employeeList;
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function getIdFromName($name)
    {
        try {
            $stmt = $this->conn->prepare(
                "SELECT employeeid
                FROM tbl_employee
                WHERE concat(firstname, ' ' , lastname) = ?;"
            );
            $stmt->bind_param("s", $name);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $id = $row["employeeid"];
                }
            }
            return $id;
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
    public function fetchEmployeesList(){
        try {
            $stmt = $this->conn->prepare("SELECT*FROM tbl_employee");
            $stmt->execute();
            $result = $stmt->get_result();
            $this->employeeList = $result;
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
      }
    }

    public function addEmployee($firstName, $lastName, $email, $mobileNumber, $position, $employeeid, $tempPassword)
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO tbl_employee (employeeid, firstname, lastname, email, mobileNumber, password, type) VALUES (?,?,?,?,?,?,?)");
            $stmt->bind_param("sssssss", $employeeid, $firstName, $lastName, $email, $mobileNumber, $tempPassword, $position);
            $stmt->execute();
            $this->conn->close();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
    public function displayCurrentEmployee($employeeId)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM tbl_employee WHERE employeeid = ?");
            $stmt->bind_param("s", $employeeId);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $this->setFirstname($row["firstname"]);
                    $this->setLastname($row["lastname"]);
                    $this->setEmail($row["email"]);
                    $this->setMobilenumber($row["mobilenumber"]);
                    $this->setPosition($row["type"]);
                }
            }
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
    public function updateEmployeeDetails($firstName, $lastName, $email, $mobileNumber, $position, $employeeId,)
    {
        try {
            $stmt = $this->conn->prepare("UPDATE tbl_employee SET firstname = ? , lastname = ? ,email = ? ,mobilenumber = ? ,type = ? WHERE employeeid = ?");
            $stmt->bind_param("ssssss", $firstName, $lastName, $email, $mobileNumber, $position, $employeeId);
            $stmt->execute();
            $this->conn->close();

            $this->setFirstname($firstName);
            $this->setLastname($lastName);
            $this->setEmail($email);
            $this->setMobilenumber($mobileNumber);
            $this->setPosition($position);
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
    public function getEmployeeList()
    {
        return $this->employeeList;
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
    public function getPosition()
    {
        return $this->position;
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
    public function setFirstname($firstName)
    {
        $this->firstname = $firstName;

        return $this;
    }
    public function setLastname($lastName)
    {
        $this->lastname = $lastName;

        return $this;
    }
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }
    public function setMobilenumber($mobileNumber)
    {
        $this->mobilenumber = $mobileNumber;

        return $this;
    }
}

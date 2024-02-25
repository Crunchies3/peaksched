<?php


class Employees
{
    private $conn;
    private $type;

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

    /**
     * Get the value of conn
     */
    public function getConn()
    {
        return $this->conn;
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
}

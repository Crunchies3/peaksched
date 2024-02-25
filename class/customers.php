<?php


class Customers
{
    private $conn;

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

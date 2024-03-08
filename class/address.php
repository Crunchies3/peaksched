<?php
class Address
{
    private $conn;

    public function fetchAddressArr($customerId)
    {
        try {
            $stmt = $this->conn->prepare(

                "SELECT CONCAT(street, '. ', city, ', ', province, '. ', country, ', ', zip_code)  as 'fullAddress'
                FROM    tbl_customer_address a,
                        tbl_customer b
                WHERE   b.customerid = a.customer_id &&
                        b.customerid = ?"
            );
            $stmt->bind_param("s", $customerId);
            $stmt->execute();
            $result = $stmt->get_result();

            $address_list = array();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($address_list, $row);
                }
            }
            return $address_list;
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function getIdByName($address)
    {
        try {
            $stmt = $this->conn->prepare(
                "SELECT address_id
                FROM tbl_customer_address
                WHERE concat(street, '. ' , city, ', ', province, '. ', country, ', ', zip_code) = ?;"
            );
            $stmt->bind_param("s", $address);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $id = $row["address_id"];
                }
            }
            return $id;
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }


    public function getConn()
    {
        return $this->conn;
    }

    public function setConn($conn)
    {
        $this->conn = $conn;

        return $this;
    }
}

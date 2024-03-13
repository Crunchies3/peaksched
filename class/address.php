<?php
class Address
{
    private $conn;
    private $address_id;
    private $customerId;
    private $street;
    private $city;
    private $province;
    private $zip_code;
    private $country;

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

    public function fetchAddressListByCustomer($customerId)
    {
        try {
            $stmt = $this->conn->prepare(

                "SELECT a.address_id,
                        CONCAT(street, '. ', city, ', ', province, '. ', country, ', ', zip_code)  as 'fullAddress'
                FROM    tbl_customer_address a,
                        tbl_customer b
                WHERE   b.customerid = a.customer_id &&
                        b.customerid = ?"
            );
            $stmt->bind_param("s", $customerId);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function isIdUnique($address_id)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM tbl_customer_address WHERE address_id = ?");
            $stmt->bind_param("s", $address_id);
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

    public function addAddress($customerId, $addressId, $street, $city, $province, $zipCode, $country)
    {
        try {
            $stmt = $this->conn->prepare(
                "INSERT INTO tbl_customer_address (address_id, 
                                                    customer_id, 
                                                    street, 
                                                    city, 
                                                    province, 
                                                    zip_code,
                                                    country) 
                VALUES (?,?,?,?,?,?,?)"
            );
            $stmt->bind_param("sssssss", $addressId, $customerId, $street, $city, $province, $zipCode, $country);
            $stmt->execute();
            $this->conn->close();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function getAddressById($address_id)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM tbl_customer_address WHERE address_id = ?");
            $stmt->bind_param("s", $address_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $this->setAddress_id($row['address_id']);
                    $this->setCustomerId($row['customer_id']);
                    $this->setStreet($row['street']);
                    $this->setCity($row['city']);
                    $this->setProvince($row['province']);
                    $this->setZip_code($row['zip_code']);
                    $this->setCountry($row['country']);
                }
            }
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

    /**
     * Get the value of address_list
     */
    public function getAddress_id()
    {
        return $this->address_id;
    }

    /**
     * Set the value of address_list
     *
     * @return  self
     */
    public function setAddress_id($address_id)
    {
        $this->address_id = $address_id;

        return $this;
    }

    /**
     * Get the value of customerId
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * Set the value of customerId
     *
     * @return  self
     */
    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;

        return $this;
    }


    public function getStreet()
    {
        return $this->street;
    }

    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    public function getProvince()
    {
        return $this->province;
    }


    public function setProvince($province)
    {
        $this->province = $province;

        return $this;
    }

    public function getZip_code()
    {
        return $this->zip_code;
    }


    public function setZip_code($zip_code)
    {
        $this->zip_code = $zip_code;

        return $this;
    }

    public function getCountry()
    {
        return $this->country;
    }


    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }
}

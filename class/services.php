<?php


class Services{
    private $conn;
    private $serviceID;
    private $title;
    private $color;
    private $description;
    private $duration;
    private $price;
    private $serviceList;

    
    public function addService($serviceId, $serviceTitle, $color, $description, $duration, $price)
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO tbl_service (service_id, title, color, description, duration, price) VALUES (?,?,?,?,?,?)");
            $stmt->bind_param("ssssss", $serviceId, $serviceTitle, $color, $description, $duration, $price);
            $stmt->execute();
            $this->conn->close();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function updateServiceDetails($serviceTitle, $color, $description, $duration, $price , $service_id,)
    {
        try {
            $stmt = $this->conn->prepare("UPDATE tbl_service SET title = ? , color = ? ,description = ? ,duration = ? ,price = ? WHERE service_id = ?");
            $stmt->bind_param("ssssss", $serviceTitle, $color, $description, $duration, $price, $service_id);
            $stmt->execute();
            $this->conn->close();

            $this->setTitle($serviceTitle);
            $this->setColor($color);
            $this->setDescription($description);
            $this->setDuration($duration);
            $this->setPrice($price);

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function displayCurrentService($serviceID){
        try {
            $stmt = $this->conn->prepare("SELECT * FROM tbl_service WHERE service_id = ?");
            $stmt->bind_param("s", $serviceID);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows >0){
                while($row = $result->fetch_assoc()){
                    $this->setTitle($row["title"]);
                    $this->setColor($row["color"]);
                    $this->setDescription($row["description"]);
                    $this->setDuration($row["duration"]);
                    $this->setPrice($row["price"]);

                }
            }
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
    //getters
    public function getConn()
    {
        return $this->conn;
    }
    public function getServiceList()
    {
        return $this->serviceList;
    }
    public function getServiceID()
    {
        return $this->serviceID;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function getColor()
    {
        return $this->color;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function getDuration()
    {
        return $this->duration;
    }
    public function getPrice()
    {
        return $this->price;
    }
    //setters
    public function setConn($conn)
    {
        $this->conn = $conn;
    }
    public function setServiceID($serviceID)
    {
        $this->serviceID = $serviceID;
    }
    public function setTitle($title)
    {
        $this->title = $title;
    }
    public function setColor($color)
    {
        $this->color = $color;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function setDuration($duration)
    {
        $this->duration = $duration;
    }
    public function setPrice($price)
    {
        $this->price = $price;
    }
}





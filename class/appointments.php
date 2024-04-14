<?php

class Appointment
{
    private $conn;
    private $appointmentId;
    private $customerId;
    private $serviceId;
    private $addressId;
    private $numOfFloors;
    private $numOfBeds;
    private $numOfBaths;
    private $start;
    private $end;
    private $status;
    private $note;
    private $displayTitle;
    private $displayDate;
    private $displayAssignedSupervisor;

    // private $appointmentList; // * JSON ni siya, dili array.

    public function fetchAppointmentList()
    {
        try {
            // dili magpakita sa calendar kung wala pay address ang customer
            $stmt = $this->conn->prepare(
                "SELECT a.appointment_id AS 'id',
                        CONCAT(b.firstname,' ', b.lastname) AS 'title',
                        d.title as 'service',
                        CONCAT(e.street, '. ', e.city, ', ', e.province, '. ', e.country, ', ', e.zip_code)  as 'fullAddress',
                        CONCAT(c.firstname,' ', c.lastname) AS 'supervisor',
                        a.num_floors,
                        a.num_beds,
                        a.num_baths,
                        a.start,
                        a.end,
                        a.note,
                        d.color,
                        d.duration,
                        d.price
                FROM    tbl_confirmed_appointment a,
                        tbl_customer b,
                        tbl_employee c,
                        tbl_service d,
                        tbl_customer_address e
                WHERE   b.customerid = a.customer_id &&
                        a.address_id = e.address_id &&
                        a.service_id = d.service_id &&
                        a.supervisor_id = c.employeeid;"
            );
            $stmt->execute();
            $result = $stmt->get_result();

            $appointmentList = array();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($appointmentList, $row);
                }
            }
            echo json_encode($appointmentList);
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function displayAppointmentRequest()
    {
        try {
            $stmt = $this->conn->prepare(
                "SELECT a.request_app_id,
                        CONCAT(b.firstname,' ', b.lastname) AS 'customer',
                        c.title,
                        b.email,
                        a.start,
                        a.status
                FROM    tbl_request_appointment a,
                        tbl_customer b,
                        tbl_service c,
                        tbl_customer_address d
                WHERE   a.customer_id = b.customerid AND
                        a.service_id = c.service_id AND
                        a.address_id = d.address_id AND
                        a.customer_id = d.customer_id AND
                        a.status != 'Denied' AND
                        a.status != 'Approved'
                ORDER BY a.start ASC;"
            );
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            return $result;
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }


    public function displayApprovedAppointments()
    {
        try {
            $stmt = $this->conn->prepare(
                "SELECT a.appointment_id,
                CONCAT(b.firstname,' ', b.lastname) AS 'customer',
                c.title,
                CONCAT(d.street, '. ', d.city, ', ', d.province, '. ', d.country, ', ', d.zip_code)  as 'fullAddress',
                a.start,
                a.status
                FROM    tbl_confirmed_appointment a,
                        tbl_customer b,
                        tbl_service c,
                        tbl_customer_address d
                WHERE   a.customer_id = b.customerid AND
                        a.service_id = c.service_id AND
                        a.address_id = d.address_id AND
                        a.customer_id = d.customer_id
                ORDER BY a.start ASC;"
            );
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            return $result;
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }



    public function isAppointmentIdUnique($id)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM tbl_confirmed_appointment WHERE appointment_id = ?");
            $stmt->bind_param("s", $id);
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

    public function isRequestAppointmentIdUnique($id)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM tbl_request_appointment WHERE request_app_id = ?");
            $stmt->bind_param("s", $id);
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

    public function deleteAppointmnet($appointmentId)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM tbl_confirmed_appointment WHERE appointment_id = ?");
            $stmt->bind_param("s", $appointmentId);
            $stmt->execute();

            return true;
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function editAppointmnet($appointmentId, $serviceId, $customerId, $employeeId, $dateTimeStart, $dateTimeEnd, $note)
    {
        try {
            $stmt = $this->conn->prepare(
                "UPDATE tbl_confirmed_appointment a
                SET     a.note = ?,
                        a.start = ?,
                        a.end = ?,
                        a.customer_id = ?,
                        a.supervisor_id = ?,
                        a.service_id = ?
                WHERE   a.appointment_id = ?;"
            );
            $stmt->bind_param("sssssss", $note, $dateTimeStart, $dateTimeEnd, $customerId, $employeeId, $serviceId, $appointmentId);
            $stmt->execute();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function addAppointmnet($appointmentId, $serviceId, $customerId, $employeeId, $dateTimeStart, $dateTimeEnd, $note, $addressId)
    {
        try {
            $stat = 'pending';
            $stmt = $this->conn->prepare(
                "INSERT INTO tbl_confirmed_appointment (appointment_id, 
                                                        customer_id, 
                                                        service_id, 
                                                        address_id,
                                                        supervisor_id,
                                                        start,
                                                        end,
                                                        note,
                                                        status) 
                VALUES (?,?,?,?,?,?,?,?,?);"
            );
            $stmt->bind_param("sssssssss", $appointmentId, $customerId, $serviceId, $addressId, $employeeId, $dateTimeStart, $dateTimeEnd, $note, $stat);
            $stmt->execute();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function addAppointment($appointmentId, $serviceId, $customerId, $employeeId, $dateTimeStart, $dateTimeEnd, $note)
    {
        $tempAddress = "1";
        try {
            $stmt = $this->conn->prepare(
                "INSERT INTO tbl_confirmed_appointment (appointment_id, 
                                                        customer_id, 
                                                        service_id, 
                                                        address_id,
                                                        supervisor_id,
                                                        start,
                                                        end,
                                                        note) 
                VALUES (?,?,?,?,?,?,?,?);"
            );
            $stmt->bind_param("ssssssss", $appointmentId, $customerId, $serviceId, $tempAddress, $employeeId, $dateTimeStart, $dateTimeEnd, $note);
            $stmt->execute();
            $stmt->close();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function updateConfirmedAppointmentStatus($appointmentid, $status)
    {
        try {
            $stmt = $this->conn->prepare(
                "UPDATE tbl_confirmed_appointment
                SET     
                        status = ?
                WHERE   appointment_id = ?"
            );
            $stmt->bind_param("ss", $status, $appointmentid);
            $stmt->execute();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function addRequestAppointment($requestAppointmentId, $service_id, $addressId, $customerId, $typeOfUnit, $numOfBeds, $numOfBath, $dateTimeStart, $dateTimeEnd, $note, $status)
    {
        try {
            $stmt = $this->conn->prepare(
                "INSERT INTO tbl_request_appointment (request_app_id, customer_id, service_id, address_id, num_floors, num_beds, num_bath, start, end, status, note) 
                VALUES (?,?,?,?,?,?,?,?,?,?,?)"
            );

            $stmt->bind_param("sssssssssss", $requestAppointmentId, $customerId, $service_id, $addressId, $typeOfUnit, $numOfBeds, $numOfBath, $dateTimeStart, $dateTimeEnd, $status, $note);
            $stmt->execute();
            $stmt->close();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }


    public function fetchAppointmentListByCustomer($customerId)
    {
        try {
            $stmt = $this->conn->prepare(
                "SELECT request_app_id,
                        (SELECT title FROM tbl_service WHERE service_id = a.service_id) as 'serviceName',
                        status,
                        start as 'date',
                        start as 'start'
                FROM tbl_request_appointment a
                WHERE customer_id = ?"
            );
            $stmt->bind_param("s", $customerId);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            return $result;
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function getAppointmentDetails($id)
    {
        try {
            $stmt = $this->conn->prepare(
                "SELECT *
                FROM tbl_request_appointment
                WHERE request_app_id = ?"
            );
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $this->setAppointmentId($row['request_app_id']);
                    $this->setCustomerId($row['customer_id']);
                    $this->setServiceId($row['service_id']);
                    $this->setAddressId($row['address_id']);
                    $this->setNumOfFloors($row['num_floors']);
                    $this->setNumOfBeds($row['num_beds']);
                    $this->setNumOfBaths($row['num_bath']);
                    $this->setStart($row['start']);
                    $this->setEnd($row['end']);
                    $this->setNote($row['note']);
                    $this->setStatus($row['status']);
                }
            }
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function getConfirmedAppointmentDetails($id)
    {
        try {
            $stmt = $this->conn->prepare(
                "SELECT *
                FROM tbl_confirmed_appointment
                WHERE appointment_id = ?"
            );
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $this->setAppointmentId($row['appointment_id']);
                    $this->setCustomerId($row['customer_id']);
                    $this->setServiceId($row['service_id']);
                    $this->setAddressId($row['address_id']);
                    $this->setNumOfFloors($row['num_floors']);
                    $this->setNumOfBeds($row['num_beds']);
                    $this->setNumOfBaths($row['num_baths']);
                    $this->setStart($row['start']);
                    $this->setEnd($row['end']);
                    $this->setNote($row['note']);
                    $this->setStatus($row['status']);
                }
            }
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function getConfirmedDisplayables()
    {
        try {
            $stmt = $this->conn->prepare(
                "SELECT b.title,
                        a.start
                 FROM tbl_confirmed_appointment a,
                      tbl_service b
                 WHERE a.service_id = b.service_id &&
                       a.appointment_id = ?
                "
            );
            $stmt->bind_param("s", $this->appointmentId);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            if ($result->num_rows > 0) {
                while ($rows = $result->fetch_assoc()) {
                    $this->setSpecificTitle($rows['title']);
                    $this->setSpecificDate($rows['start']);
                }
            }
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }


    public function getDisplayables()
    {
        try {
            $stmt = $this->conn->prepare(
                "SELECT b.title,
                        a.start
                 FROM tbl_request_appointment a,
                      tbl_service b
                 WHERE a.service_id = b.service_id &&
                       a.request_app_id = ?
                "
            );
            $stmt->bind_param("s", $this->appointmentId);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            if ($result->num_rows > 0) {
                while ($rows = $result->fetch_assoc()) {
                    $this->setSpecificTitle($rows['title']);
                    $this->setSpecificDate($rows['start']);
                }
            }
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }


    public function getAssignedSupervisor()
    {
        try {
            $stmt = $this->conn->prepare(
                "SELECT CONCAT(a.firstname,' ',a.lastname) AS 'fullname'
                 FROM tbl_employee a,
                      tbl_confirmed_appointment b,
                      tbl_request_appointment c
                 WHERE b.supervisor_id = a.employeeid &&
                       b.service_id = c.service_id &&
                       c.status = 'Approved' &&
                       c.request_app_id = ? &&
                       b.customer_id = ? 
                "
            );
            $stmt->bind_param("ss", $this->appointmentId, $this->customerId);
            $stmt->execute();
            $supervisor = $stmt->get_result();
            $stmt->close();
            while ($rows = $supervisor->fetch_assoc()) {
                $this->setSpecificSupervisorAssigned($rows['fullname']);
            }
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function rescheduleAppointment($dateTimestart, $dateTimeend, $note, $status, $appointmentId)
    { {
            try {
                $stmt = $this->conn->prepare(
                    "UPDATE tbl_request_appointment a
                    SET     a.start = ?,
                            a.end = ?,
                            a.note = ?,
                            a.status = ?
                    WHERE   a.request_app_id = ?"
                );
                $stmt->bind_param("sssss", $dateTimestart, $dateTimeend, $note, $status, $appointmentId);
                $stmt->execute();
            } catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
        }
    }
    public function confirmedAppointmentDeletion($customerId, $service_id)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM tbl_confirmed_appointment WHERE customer_id = ? && service_id = ?");
            $stmt->bind_param("ss", $customerId, $service_id);
            $stmt->execute();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
    public function cancelAppointment($id)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM tbl_request_appointment WHERE request_app_id = ?");
            $stmt->bind_param("s", $id);
            $stmt->execute();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
    public function approveAppointment($appointmentId, $customerId, $service_id, $addressId, $supervisorid, $num_floors, $num_beds, $num_baths, $start, $end, $note, $status)
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO tbl_confirmed_appointment (appointment_id, customer_id, service_id, address_id, supervisor_id, num_floors, num_beds, num_baths,
            start, end, note, status) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param("ssssssssssss", $appointmentId, $customerId, $service_id, $addressId, $supervisorid, $num_floors, $num_beds, $num_baths, $start, $end, $note, $status);
            $stmt->execute();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
    public function updateApprovedAppointment($appointmentId)
    {
        try {
            $stmt = $this->conn->prepare(
                "UPDATE tbl_request_appointment a SET a.status = 'Approved' WHERE request_app_id = ?"
            );
            $stmt->bind_param("s", $appointmentId);
            $stmt->execute();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
    public function denyCustRequest($id)
    {
        try {
            $stmt = $this->conn->prepare(
                "UPDATE tbl_request_appointment a SET a.status = 'Denied' WHERE request_app_id = ?"
            );
            $stmt->bind_param("s", $id);
            $stmt->execute();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
    public function getApprovedAppointmentDetails($appointmentId)
    {
        try {
            $stmt = $this->conn->prepare(
                "SELECT CONCAT(b.firstname,' ',b.lastname) AS 'fullname',
                        c.title,
                        CONCAT(d.street, '. ', d.city, ', ', d.province, '. ', d.country, ', ', d.zip_code)  as 'fullAddress',
                        a.status,
                        DATE(a.start) AS 'date',
                        DATE_FORMAT(a.start, '%h:%i %p') AS 'time',
                        a.num_floors,
                        a.num_beds,
                        a.num_baths,
                        CONCAT(e.firstname, ' ', e.lastname) AS 'supFullname'
                FROM tbl_confirmed_appointment a,
                     tbl_customer b,
                     tbl_service c,
                     tbl_customer_address d,
                     tbl_employee e
                WHERE a.customer_id = b.customerid AND
                      a.service_id = c.service_id AND
                      a.address_id = d.address_id AND
                      a.supervisor_id = e.employeeid AND
                      a.appointment_id = ?"
            );
            $stmt->bind_param("s", $appointmentId);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }


    public function fetchRepeatedDatesCurrentOnwards()
    {
        try {
            $stmt = $this->conn->prepare(
                "SELECT DATE(start) AS 'dates' FROM tbl_confirmed_appointment
                 WHERE DATE(start) >= CURRENT_DATE() 
                 GROUP BY DATE(start) HAVING COUNT(*) = 4"
            );
            $stmt->execute();
            $result = $stmt->get_result();
            $repeatedDates = array();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($repeatedDates, $row);
                }
            }
            echo json_encode($repeatedDates);
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

    public function setConn($conn)
    {
        $this->conn = $conn;

        return $this;
    }
    public function getSpecificTitle()
    {
        return $this->displayTitle;
    }
    public function setSpecificTitle($displayTitle)
    {
        $this->displayTitle = $displayTitle;

        return $this;
    }
    public function getSpecificDate()
    {
        return $this->displayDate;
    }
    public function setSpecificDate($displayDate)
    {
        $this->displayDate = $displayDate;

        return $this;
    }
    public function getSpecificSupervisorAssigned()
    {
        return $this->displayAssignedSupervisor;
    }
    public function setSpecificSupervisorAssigned($displayAssignedSupervisor)
    {
        $this->displayAssignedSupervisor = $displayAssignedSupervisor;

        return $this;
    }

    public function getAppointmentId()
    {
        return $this->appointmentId;
    }

    public function setAppointmentId($appointmentId)
    {
        $this->appointmentId = $appointmentId;

        return $this;
    }

    public function getCustomerId()
    {
        return $this->customerId;
    }


    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;

        return $this;
    }

    public function getServiceId()
    {
        return $this->serviceId;
    }


    public function setServiceId($serviceId)
    {
        $this->serviceId = $serviceId;

        return $this;
    }


    public function getAddressId()
    {
        return $this->addressId;
    }


    public function setAddressId($addressId)
    {
        $this->addressId = $addressId;

        return $this;
    }


    public function getNumOfFloors()
    {
        return $this->numOfFloors;
    }


    public function setNumOfFloors($numOfFloors)
    {
        $this->numOfFloors = $numOfFloors;

        return $this;
    }

    public function getNumOfBeds()
    {
        return $this->numOfBeds;
    }


    public function setNumOfBeds($numOfBeds)
    {
        $this->numOfBeds = $numOfBeds;

        return $this;
    }

    public function getNumOfBaths()
    {
        return $this->numOfBaths;
    }

    public function setNumOfBaths($numOfBaths)
    {
        $this->numOfBaths = $numOfBaths;

        return $this;
    }

    public function getStart()
    {
        return $this->start;
    }

    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd()
    {
        return $this->end;
    }

    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    public function getNote()
    {
        return $this->note;
    }

    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }
}

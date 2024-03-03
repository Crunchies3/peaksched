<?php

class Appointment
{
    private $conn;
    private $id;
    private $title;
    private $description;
    private $start;
    private $end;

    // private $appointmentList; // * JSON ni siya, dili array.

    public function fetchAppointmentList()
    {
        try {
            $stmt = $this->conn->prepare(
                "SELECT a.id AS 'id',
                        CONCAT(b.firstname,' ', b.lastname) AS 'title',
                        a.note,
                        a.start,
                        a.end,
                        CONCAT(c.firstname,' ', c.lastname) AS 'supervisor',
                        d.title as 'service',
                        d.color,
                        d.duration
                FROM    tbl_appointment a,
                        tbl_customer b,
                        tbl_employee c,
                        tbl_service d,
                        tbl_app_cust_sup e,
                        tbl_appointment_service f
                WHERE   a.id = e.appointment_id && 
                        e.customer_id = b.customerid &&
                        e.employee_id = c.employeeid &&
                        a.id = f.appointment_id &&
                        f.service_id = d.service_id;"
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

    public function isAppointmentIdUnique($id)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM tbl_appointment WHERE id = ?");
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
            $stmt = $this->conn->prepare("DELETE FROM tbl_appointment WHERE id = ?");
            $stmt->bind_param("s", $appointmentId);
            $stmt->execute();
            $stmt->close();
            return true;
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function editAppointmnet($appointmentId, $serviceId, $customerId, $employeeId, $dateTimeStart, $dateTimeEnd, $note)
    {
        try {
            $stmt = $this->conn->prepare(
                "UPDATE tbl_appointment a,
                        tbl_customer b,
                        tbl_employee c,
                        tbl_service d,
                        tbl_app_cust_sup e,
                        tbl_appointment_service f
                SET     a.note = ?,
                        a.start = ?,
                        a.end = ?,
                        e.customer_id = ?,
                        e.employee_id = ?,
                        f.service_id = ?
                WHERE   a.id = e.appointment_id && 
                        e.customer_id = b.customerid &&
                        e.employee_id = c.employeeid &&
                        a.id = f.appointment_id &&
                        f.service_id = d.service_id && 
                        a.id = ?;"
            );
            $stmt->bind_param("sssssss", $note, $dateTimeStart, $dateTimeEnd, $customerId, $employeeId, $serviceId, $appointmentId);
            $stmt->execute();
            $this->conn->close();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function addAppointmnet($appointmentId, $serviceId, $customerId, $employeeId, $dateTimeStart, $dateTimeEnd, $note)
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO tbl_appointment (id, note, start, end) VALUES (?,?,?,?)");
            $stmt->bind_param("ssss", $appointmentId, $note, $dateTimeStart, $dateTimeEnd);
            $stmt->execute();
            $stmt->close();

            $stmt = $this->conn->prepare("INSERT INTO tbl_app_cust_sup (appointment_id, customer_id, employee_id) VALUES (?,?,?)");
            $stmt->bind_param("sss", $appointmentId, $customerId, $employeeId);
            $stmt->execute();
            $stmt->close();

            $stmt = $this->conn->prepare("INSERT INTO tbl_appointment_service (appointment_id, service_id) VALUES (?,?)");
            $stmt->bind_param("ss", $appointmentId, $serviceId);
            $stmt->execute();
            $stmt->close();
            $this->conn->close();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function addRequestAppointment($appointmentId, $serviceId, $customerId, $employeeId, $dateTimeStart, $dateTimeEnd, $note)
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO tbl_appointment (id, note, start, end) VALUES (?,?,?,?)");
            $stmt->bind_param("ssss", $appointmentId, $note, $dateTimeStart, $dateTimeEnd);
            $stmt->execute();
            $stmt->close();

            $stmt = $this->conn->prepare("INSERT INTO tbl_app_cust_sup (appointment_id, customer_id, employee_id) VALUES (?,?,?)");
            $stmt->bind_param("sss", $appointmentId, $customerId, $employeeId);
            $stmt->execute();
            $stmt->close();

            $stmt = $this->conn->prepare("INSERT INTO tbl_appointment_service (appointment_id, service_id) VALUES (?,?)");
            $stmt->bind_param("ss", $appointmentId, $serviceId);
            $stmt->execute();
            $stmt->close();
            $this->conn->close();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }




    // ? getter and setters

    public function getConn()
    {
        return $this->conn;
    }

    public function setConn($conn)
    {
        $this->conn = $conn;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;

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
}

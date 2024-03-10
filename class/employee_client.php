<?php

class Employee_Client
{
    private $conn;
    private $assignedAppointmentsList;
    private $assignedWorkersAppointment;
    private $unassignedWorkersAppointment;
    private $appointmentId;
    private $fullname;
    private $serviceTitle;
    private $appointmentStatus;
    private $appointmentDate;


    public function fetchAssignedAppointments($supervisorId)
    {
        try {
            $stmt = $this->conn->prepare("SELECT a.appointment_id, CONCAT(b.firstname,' ',b.lastname) AS 'fullname', c.title, a.status, a.start, a.end FROM tbl_confirmed_appointment a, tbl_customer b, tbl_service c WHERE a.customer_id = b.customerid && a.service_id = c.service_id && a.supervisor_id = ?");
            $stmt->bind_param("s", $supervisorId);
            $stmt->execute();
            $result = $stmt->get_result();
            $this->assignedAppointmentsList = $result;
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function fetchAssignedWorkerAppointments($workerId)
    {
        try {
            $stmt = $this->conn->prepare(
                "SELECT a.appointment_id, 
                        CONCAT(b.firstname,' ',b.lastname) AS 'fullname', 
                        c.title, 
                        a.status, 
                        a.start, 
                        a.end 
                FROM    tbl_confirmed_appointment a,
                        tbl_customer b,
                        tbl_service c,
                        tbl_worker_appointment d
                WHERE   d.appointment_id = a.appointment_id &&
                        a.service_id = c.service_id &&
                        a.customer_id = b.customerid && 
                        d.worker_id = ?"
            );
            $stmt->bind_param("s", $workerId);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }


    public function displayCurrentAppointmentAssigned($appointmentId)
    {
        try {
            $stmt = $this->conn->prepare("SELECT a.appointment_id, CONCAT(b.firstname,' ',b.lastname) AS 'fullname', c.title, a.status, a.start FROM tbl_confirmed_appointment a, tbl_customer b, tbl_service c WHERE a.customer_id = b.customerid && a.service_id = c.service_id && a.appointment_id = ?");
            $stmt->bind_param("s", $appointmentId);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $this->setAppointmentId($row["appointment_id"]);
                    $this->setFullname($row["fullname"]);
                    $this->setServiceTitle($row["title"]);
                    $this->setAppointmentStatus($row["status"]);
                    $this->setAppointmentDate($row["start"]);
                }
            }
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function fetchAppointmentWorkers($appointmentId)
    {
        try {
            $stmt = $this->conn->prepare(
                "SELECT a.employeeid, 
                        CONCAT(a.firstname,' ',a.lastname) AS 'fullname',
                        a.email,
                        a.mobilenumber
                FROM    tbl_employee a,
                        tbl_worker_appointment b
                WHERE   b.worker_id = a.employeeid &&
                        b.appointment_id = ?");
            $stmt->bind_param("s", $appointmentId);
            $stmt->execute();
            $result = $stmt->get_result();
            $this->assignedWorkersAppointment = $result;
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
    public function fetchUnassignedAppointmentWorkers($appointmentId)
    {
        try {
            $stmt = $this->conn->prepare(
                "SELECT DISTINCT a.employeeid,
                                a.firstname,
                                a.lastname,
                                a.email,
                                a.mobilenumber 
                            FROM tbl_employee a,
                                tbl_supervisor_worker b,
                                tbl_worker_appointment c
                            WHERE a.type = 'worker' &&
                                a.employeeid = b.worker_id &&
                                !EXISTS(SELECT *FROM tbl_worker_appointment WHERE appointment_id = ? && worker_id = b.worker_id)");
            $stmt->bind_param("s",$appointmentId);
            $stmt->execute();
            $result = $stmt->get_result();
            $this->unassignedWorkersAppointment = $result;
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
    public function addWorkerToAppointment($appointmentId, $workerId)
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO tbl_worker_appointment (appointment_id, worker_id) VALUES (?,?)");
            $stmt->bind_param("ss", $appointmentId, $workerId);
            $stmt->execute();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
    public function removeWorkerInAppointment($appointmentId, $workerId)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM tbl_worker_appointment WHERE appointment_id = ? && worker_id = ?");
            $stmt->bind_param("ss", $appointmentId, $workerId);
            $stmt->execute();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    //getters
    public function getConn()
    {
        return $this->conn;
    }
    public function getAssignedAppointments()
    {
        return $this->assignedAppointmentsList;
    }
    public function getAssignedWorkers()
    {
        return $this->assignedWorkersAppointment;
    }
    public function getUnassignedWorkers()
    {
        return $this->unassignedWorkersAppointment;
    }
    public function getAppointmentId()
    {
        return $this->appointmentId;
    }
    public function getFullname()
    {
        return $this->fullname;
    }
    public function getServicetitle()
    {
        return $this->serviceTitle;
    }
    public function getAppointmentstatus()
    {
        return $this->appointmentStatus;
    }
    public function getAppointmentdate()
    {
        return $this->appointmentDate;
    }

    //setters
    public function setConn($conn)
    {
        $this->conn = $conn;

        return $this;
    }
    public function setAppointmentId($appointmentId)
    {
        $this->appointmentId = $appointmentId;

        return $this;
    }
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;

        return $this;
    }
    public function setServiceTitle($serviceTitle)
    {
        $this->serviceTitle = $serviceTitle;

        return $this;
    }
    public function setAppointmentStatus($appointmentStatus)
    {
        $this->appointmentStatus = $appointmentStatus;

        return $this;
    }
    public function setAppointmentDate($appointmentDate)
    {
        $this->appointmentDate = $appointmentDate;

        return $this;
    }
}

<?php
class Report
{

    private $conn;
    private $dateReported;
    private $timeReported;
    private $note;

    public function createReport($reportId, $workerIds, $workerHour, $workerMinute, $dateNow, $timeNow, $appointmentId, $supervisorId, $notes)
    {
        try {
            $status = 'Pending';
            $stmt = $this->conn->prepare(
                "INSERT INTO tbl_supervisor_report (report_id, 
                                                        appointment_id, 
                                                        supervisor_id, 
                                                        report_date,
                                                        report_time,
                                                        notes,
                                                        status) 
                VALUES (?,?,?,?,?,?,?);"
            );
            $stmt->bind_param("sssssss", $reportId, $appointmentId, $supervisorId, $dateNow, $timeNow, $notes, $status);
            $stmt->execute();
            $stmt->close();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }


        // insert para sa worked hours sa employee

        try {
            for ($i = 0; $i < count($workerIds); $i++) {
                $hour = $workerHour[$i] . ':' . $workerMinute[$i];
                $stmt = $this->conn->prepare(
                    "INSERT INTO tbl_report_employee_hours (report_id, 
                                                            employee_id, 
                                                            hours_worked) 
                    VALUES (?,?,?);"
                );
                $stmt->bind_param("sss", $reportId, $workerIds[$i], $hour);
                $stmt->execute();
                $stmt->close();
            }
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function editReport($reportId, $workerIds, $workerHour, $workerMinute, $dateNow, $timeNow, $notes)
    {
        try {

            $status = 'Pending';
            $stmt = $this->conn->prepare(
                "UPDATE tbl_supervisor_report 
                SET report_date = ?,
                    report_time = ?,
                    notes = ?,
                    status = ?
                WHERE report_id = ?"
            );
            $stmt->bind_param("sssss", $dateNow, $timeNow, $notes, $status, $reportId);
            $stmt->execute();

            $stmt->close();

            for ($i = 0; $i < count($workerIds); $i++) {
                $hour = $workerHour[$i] . ':' . $workerMinute[$i];
                $stmt = $this->conn->prepare(
                    "UPDATE tbl_report_employee_hours
                    SET hours_worked = ?
                    WHERE employee_id = ? &&
                    report_id = ?"
                );
                $stmt->bind_param("sss", $hour, $workerIds[$i], $reportId);
                $stmt->execute();
                $stmt->close();
            }
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function approveReport($reportId)
    {
        try {
            $status = 'Approved';
            $stmt = $this->conn->prepare(
                "UPDATE tbl_supervisor_report 
                SET status = ?
                WHERE report_id = ?"
            );
            $stmt->bind_param("ss", $status, $reportId);
            $stmt->execute();
            $stmt->close();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function deleteReport($reportId)
    {
        try {
            $stmt = $this->conn->prepare(
                "DELETE FROM tbl_supervisor_report  WHERE  report_id = ?;"
            );
            $stmt->bind_param("s", $reportId);
            $stmt->execute();
            $stmt->close();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function getSupervisorNameByReportID($reportId)
    {
        try {
            $stmt = $this->conn->prepare("  SELECT  CONCAT(b.firstname, ' ' , b.lastname) as 'Supervisor'
                                            FROM    tbl_supervisor_report a,
                                                    tbl_employee b
                                            WHERE   a.supervisor_id = b.employeeid && a.report_id = ?;
                                                    ");
            $stmt->bind_param("s", $reportId);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    return $row['Supervisor'];
                }
            }
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function getAllReports()
    {
        try {
            $stmt = $this->conn->prepare("  SELECT  a.report_id,
                                                    CONCAT(b.firstname, ' ' , b.lastname) as 'Supervisor',
                                                    a.appointment_id,
                                                    a.report_date,
                                                    a.report_time,
                                                    a.status
                                            FROM    tbl_supervisor_report a,
                                                    tbl_employee b
                                            WHERE   a.supervisor_id = b.employeeid;
                                                    ");
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }



    public function getReportDetails($reportId)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM tbl_report_employee_hours WHERE report_id = ?");
            $stmt->bind_param("s", $reportId);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function getReportedDateTime($reportId)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM tbl_supervisor_report  WHERE report_id = ?");
            $stmt->bind_param("s", $reportId);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $this->setDateReported($row['report_date']);
                    $this->setTimeReported($row['report_time']);
                    $this->setNote($row['notes']);
                }
            }
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function isReportIdUnique($reportId)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM tbl_supervisor_report WHERE report_id = ?");
            $stmt->bind_param("s", $reportId);
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
     * Get the value of dateReported
     */
    public function getDateReported()
    {
        return $this->dateReported;
    }

    public function setDateReported($dateReported)
    {
        $this->dateReported = $dateReported;

        return $this;
    }

    public function getTimeReported()
    {
        return $this->timeReported;
    }

    public function setTimeReported($timeReported)
    {
        $this->timeReported = $timeReported;

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

<?php
class Report
{

    public function createReport($reportId, $workerIds, $workerHour, $workerMinute, $dateNow, $timeNow, $appointmentId, $supervisorId, $notes)
    {
        try {
            $stmt = $this->conn->prepare(
                "INSERT INTO tbl_supervisor_report (report_id, 
                                                        appointment_id, 
                                                        supervisor_id, 
                                                        report_date,
                                                        report_time,
                                                        notes) 
                VALUES (?,?,?,?,?,?);"
            );
            $stmt->bind_param("ssssss", $reportId, $appointmentId, $supervisorId, $dateNow, $timeNow, $notes);
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



    private $conn;

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

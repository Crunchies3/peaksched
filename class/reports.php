<?php
class Report
{

    public function createReport($workerIds, $workerHour, $workerMinute, $dateNow, $timeNow)
    {
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

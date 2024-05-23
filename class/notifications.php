<?php

class Notifications
{
    private $conn;
    private $recipientidS;
    private $recipientidC;
    private $senderid;
    private $unread;
    private $dateCreated;
    private $senderUserType;
    private $receiverUserType;
    private $displayNotifs;

    //supervisor-worker notif side (manotify ang worker)
    //if mag assign o remove ang supervisor ug appointment sa usa ka worker
    //isulod ang notif message sa database
    //content sa notif kay current appointment kung asa na assign o remove
    //kung na assign included ang time kung kanus.a
    //kung wala kay wala.

    public function insertNotif($reciever, $unread, $created_at, $message)
    {
        try {
            $stmt = $this->conn->prepare(
                "INSERT INTO tbl_notifications (recipient_type, unread, created_at, message)
            VALUES (?,?,?,?) "
            );
            $stmt->bind_param("ssss", $reciever, $unread, $created_at, $message);
            $stmt->execute();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
    public function insertNotifAdmin($unread, $created_at, $message)
    {
        try {
            $stmt = $this->conn->prepare(
                "INSERT INTO tbl_notifications (recipient_type, unread, created_at, message) 
                VALUEs ('admin', ?, ?, ?)
                "
            );
            $stmt->bind_param("sss", $unread, $created_at, $message);
            $stmt->execute();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function displayNotification($Id)
    {
        try {
            $stmt = $this->conn->prepare(
                "SELECT * FROM tbl_notifications WHERE recipient_type = ?"
            );
            $stmt->bind_param("s", $Id);
            $stmt->execute();
            $result = $stmt->get_result();
            $this->displayNotifs = $result;
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
    public function displayAdminNotification()
    {
        try {
            $stmt = $this->conn->prepare(
                "SELECT * FROM tbl_notifications WHERE recipient_type = 'admin'"
            );
            $stmt->execute();
            $result = $stmt->get_result();
            $this->displayNotifs = $result;
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    //admin-supervisor notif side (manotify ang supervisor)
    //if mag assign o remove ang admin ug appointment sa supervisor
    //if naay changes sa appointment nahitabo na nacancel o naresched (assuming nga na approve na sa admin kadto nga changes)



    //admin-customer notif side (manotify ang customer)
    //if ma approve or denied ang appointment created sa customer


    //customer-admin notif side (manotify ang admin)
    //if naay changes gibuhat (resched/cancel) ang customer na need i approve



    public function getConn()
    {
        return $this->conn;
    }
    public function getsenderUserType()
    {
        return $this->senderUserType;
    }
    public function getreceiverUserType()
    {
        return $this->receiverUserType;
    }
    public function getDisplayNotifs()
    {
        return $this->displayNotifs;
    }
    public function getRecipientIdS()
    {
        return $this->recipientidS;
    }
    public function getRecipientIdC()
    {
        return $this->recipientidC;
    }




    public function setConn($conn)
    {
        $this->conn = $conn;

        return $this;
    }
    public function setRecipientIdS($recipientidS)
    {
        $this->recipientidS = $recipientidS;

        return $this;
    }
    public function setRecipientIdC($recipientidC)
    {
        $this->recipientidC = $recipientidC;

        return $this;
    }

    public function setsenderUserType($senderUserType)
    {
        $this->senderUserType = $senderUserType;

        return $this;
    }
    public function setreceiverUserType($receiverUserType)
    {
        $this->receiverUserType = $receiverUserType;

        return $this;
    }
}

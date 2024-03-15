<?php

class Notifications{
    private $conn;
    private $recipientid;
    private $senderid;
    private $unread;
    private $notifType;
    private $dateCreated;
    private $senderName;
    private $senderUserType; 
    private $receiverUserType;
    private $displayNotifs;

    //supervisor-worker notif side (manotify ang worker)
    //if mag assign o remove ang supervisor ug appointment sa usa ka worker
    //isulod ang notif message sa database
    //content sa notif kay current appointment kung asa na assign o remove
    //kung na assign included ang time kung kanus.a
    //kung wala kay wala.

    public function insertSuptoWorkerNotif($reciever,$sender,$unread,$created_at,$message){
        try {
            $stmt = $this->conn->prepare(
            "INSERT INTO tbl_notifications (recipient_type, sender_type, unread, created_at, message)
            VALUES (?,?,?,?,?) ");
            $stmt->bind_param("sssss", $reciever,$sender,$unread,$created_at,$message);
            $stmt->execute();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function displayNotification($Id){
        try {
            $stmt = $this->conn->prepare(
                "SELECT * FROM tbl_notifications WHERE recipient_type = ?");
            $stmt->bind_param("s",$Id);
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



    //plano
    //taga execute sa operation nga involve ug notification ing anion lang ang tirada nga magneed ug parameter
    //siguro ang need kadalasan kay ang senderType ug receiverType sa sql query side
    //sample sa backend
    // public function notifySupervisorFromAdmin($senderType , $receiverType) : string
    // {
    //     return $senderType->getName() . 'Has assigned you to an appointment '. $AppointmentName . 'on' .$currentDate. 'Please view your appointment tab for more details'.; 
    // }
    //sample sa query
    // public function supervisorNotifications($senderid, $recepientid, $notifType, $dateCreated)
    // {
            //INSERT INTO tbl_notification 
            //senderid = $senderType->getId
            //recepientid = id sa supervisor
            //notiftype = dpende kugn appointment related or dli
    // }

    public function getConn()
    {
        return $this->conn;
    }
    public function getsenderName()
    {
        return $this->senderName;
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



    public function setConn($conn)
    {
        $this->conn = $conn;

        return $this;
    }
    public function setsenderUserType($senderUserType)
    {
        $this->senderUserType = $senderUserType;

        return $this;
    }
    public function setsenderName($senderName)
    {
        $this->senderName = $senderName;

        return $this;
    }
    public function setreceiverUserType($receiverUserType)
    {
        $this->receiverUserType = $receiverUserType;

        return $this;
    }
}
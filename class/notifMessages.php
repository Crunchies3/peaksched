<?php
require_once "notifications.php";

class NotifMessages extends Notifications{

    public function supToWorkerAssign($appointmentName) : string{

        return $this->getsenderName() . ' has assigned you to the appointment ' . $appointmentName;

    }
    public function supToWorkerRemove($appointmentName) : string{

        return $this->getsenderName() . ' has removed you to the appointment' . $appointmentName;

    }

}
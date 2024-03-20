<?php
require_once "notifications.php";

class NotifMessages extends Notifications{

    //mao ning side sa supervisor if mag assign ug worker sa iyang appointment
    //sa employee-supervisor ni nga side assigning_app_supervisor.php ug assigned_app_supervisor_view.php
    public function supToWorkerAssign($appointmentName) : string{

        return 'Your supervisor has assigned you to the appointment ' . $appointmentName;

    }
    public function supToWorkerRemove($appointmentName) : string{

        return 'Your supervisor has removed you to the appointment ' . $appointmentName;

    }
    //mao ning side sa admin if mag add ug worker under sa specific na supervisor
    //manotify sad apil ang worker if maremove sya sa isa ka supervisor o ma add.
    //sa worker_assigning_page.php ug asigned_worker_super.php rani nga side
    public function adminAssignWorkerstoSup($workerName) : string {

        return ' Admin has assigned a worker to you ('. $workerName .')' ;

    }
    public function adminRemoveWorkerstoSup($workerName) : string {

        return ' Admin has removed a worker from you ('. $workerName .')' ;

    }
    public function adminAddSuptoWorker($supervisorName) : string {
        return 'Admin has assigned you to a new supervisor '.$supervisorName;
    }
    public function adminRemoveSuptoWorker($supervisorName) : string {
        return 'Admin has removed you from your supervisor '.$supervisorName;
    }

    //mao ning side sa admin if magadd ug new appointment ang admin sa isa ka customer.
    //manotify sad ug apil ang supervisor if naa syay bag.ong appointment na naassing saiya
    //manotify ang customer ug supervisor if ang appointment na assign saila kay nadelete o giedit.
    //sa dashboard.php rani nga side
    public function adminToCustomerAppointment($appointmentName, $appointmentDate) : string {
        return 'Admin has made you a new appointment '.$appointmentName.' on '.$appointmentDate;
    }
    public function adminToSupervisorAppointment($appointmentName) : string {
        return 'Admin has assigned you to a new appointment '. $appointmentName;
    }
    public function adminToCustomerEdit($appointmentName) : string{
        return 'Admin has edited your appointment ' . $appointmentName;
    }
    public function adminToSupervisorEdit($appointmentName) : string{
        return 'Admin has edited your assigned appointment ' . $appointmentName;
    }
    public function adminToCustomerDelete($appointmentName, $appointmentDate) : string{
        return 'Admin has cancelled your appointment ' .$appointmentName .' in '.$appointmentDate;
    }
    public function adminToSupervisorDelete($appointmentName, $appointmentDate) : string{
        return 'Admin has cancelled your assigned appointment ' . $appointmentName .' in '.$appointmentDate;
    }
    
}
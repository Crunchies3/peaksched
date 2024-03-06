<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Appointments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- DataTables CDN -->

    <link href="https://cdn.datatables.net/v/bs5/dt-2.0.0/b-3.0.0/b-html5-3.0.0/r-3.0.0/sl-2.0.0/sr-1.4.0/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/v/bs5/dt-2.0.0/b-3.0.0/b-html5-3.0.0/r-3.0.0/sl-2.0.0/sr-1.4.0/datatables.min.js"></script>
    <!-- end -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="./css/dashboard_styles.css" />
    <link rel="stylesheet" href="./css/assigning-appointment-supervisor-view.css">
    <link rel="stylesheet" href="../components/_components.css">
</head>

<body>
    <div class="wrapper">
        <aside id="sidebar" class="shadow-lg">
            <div class="d-flex mb-2">
                <button id="toggle-btn" type="button">
                    <i class="bi bi-calendar-week"></i>
                </button>
                <div class="sidebar-logo">
                    <a href="#">PeakSched</a>
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="dashboard.php" class="sidebar-link">
                        <i class="bi bi-house"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link selected">
                        <i class="bi bi-calendar2-fill"></i>
                        <span>Appointments</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="bi bi-bell"></i>
                        <span>Notifications</span>
                    </a>
                </li>
                <li class="sidebar-footer">
                    <a href="setting_account_page.php" class="sidebar-link ">
                        <i class="bi bi-gear"></i>
                        <span>Settings</span>
                    </a>
                </li>
            </ul>
            <div class="sidebar-footer">
                <a href="php/logout.php" class="sidebar-link">
                    <i class="bi bi-box-arrow-left"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>
        <section class="main" id="main">
            <div class="container-fluid" id="assignedAppointmentArea">
                <div class="mb-5">
                    <h1>Appointment</h1>
                </div>
                <div class="container-fluid" id="assignedAppointmentTableArea">
                    <div>
                        <h5>Assign Appointment</h5>
                    </div>
                    <input type="hidden" id="supId" value="<?php echo $supervisorId ?>">
                    <div class="d-flex justify-content-between mb-3">
                        <div>Supervisor ID: </div> 
                        <div>Supervisor Name: </div>
                    </div>
                    <table id="myTable" class="table table-hover table-striped">
                        <!-- //!TODO: para mailisan ang color sa header -->
                        <thead id="tableHead">
                            <th style="color: white;">Appointment Id</th>
                            <th style="color: white;">Customer</th>
                            <th style="color: white;">Service</th>
                            <th style="color: white;">Status</th>
                            <th style="color: white;">Date</th>
                            <th style="color: white;">Actions</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>123123</td>
                                <td>Cyril Alvez</td>
                                <td>Bathroom Cleaning</td>
                                <td style="color: red";>On-going</td>
                                <td>2011-06-25</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>525121</td>
                                <td>Kenneth Manon og</td>
                                <td>Backyard Cleaning</td>
                                <td style="color: green";>Completed</td>
                                <td>2011-05-25</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>5555121</td>
                                <td>Dennis Nazareno</td>
                                <td>Room Cleaning</td>
                                <td style="color: green";>Completed</td>
                                <td>2011-04-25</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <script src = "./js/data-table-assigning-view.js"></script>                  
        <script src="./js/script.js"></script>
</body>

</html>


<div class="modal fade" id="AssignWorkerModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="AssignWorkerModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="width: 500px;">
        <div class="modal-content shadow p-3 mb-5 bg-white rounded border">
            <div class="modal-header">
                <h1 class="modal-title" style="font-size: 20px;" id="exampleModalLabel">Confirm assign worker?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Worker will be assigned.
            </div>
            <div class="modal-footer">
                <button name="AssignWorkerModal" form="AssignWorkerForm" class="btn my-button-yes">Confirm</button>
                <button type="button" class="btn my-button-no" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
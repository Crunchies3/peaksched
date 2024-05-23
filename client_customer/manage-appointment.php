<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}

require_once "./php_backend/appointment.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TwinPeaks</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>



    <!-- kani ang i copy paste =. ilisan ang karaan na datatables na link -->
    <link href="https://cdn.datatables.net/v/bs5/dt-2.0.2/b-3.0.1/r-3.0.0/sc-2.4.1/sb-1.7.0/sp-2.3.0/sl-2.0.0/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/v/bs5/dt-2.0.2/b-3.0.1/r-3.0.0/sc-2.4.1/sb-1.7.0/sp-2.3.0/sl-2.0.0/datatables.min.js"></script>

    <link rel="stylesheet" href="./css/dashboard_styles.css" />
    <link rel="stylesheet" href="./css/appointment-styles.css" />
    <link rel="stylesheet" href="../components/_components.css" />

</head>

<body>
    <div class="app-bar d-lg-none d-flex">
        <a href="#">
            <button id="burger-menu" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
                <i class="bi bi-list"></i>
            </button>
        </a>
        <span class="mx-3 sidebar-logo"><a href="#">TwinPeaks</a></span>
    </div>
    <div class="wrapper">
        <aside id="sidebar" tabindex="-1" class="shadow-lg offcanvas-lg offcanvas-start" data-bs-backdrop="true">
            <div class="d-flex mb-2">
                <button id="toggle-btn" type="button">
                    <i class="bi bi-tree-fill"></i>
                </button>
                <div class="sidebar-logo">
                    <a href="#">TwinPeaks</a>
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="dashboard.php" class="sidebar-link ">
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
                    <a href="./address" class="sidebar-link">
                        <i class="bi bi-geo-alt"></i>
                        <span>Address</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="./notification" class="sidebar-link">
                        <i class="bi bi-bell"></i>
                        <span>Notifications</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="setting_account_page.php" class="sidebar-link ">
                        <i class="bi bi-gear"></i>
                        <span>Settings</span>
                    </a>
                </li>
            </ul>
            <div class="sidebar-footer">
                <a href="php_backend/logout.php" class="sidebar-link">
                    <i class="bi bi-box-arrow-left"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>
        <div class="main p-2" id="main">
            <div class="container-fluid" id="mainArea">
                <div class="mb-4">
                    <h1>Appointments</h1>
                </div>
                <div class="row ">
                    <div class="mb-3 col-xxl-3">
                        <a href="./request-appointment-service.php" class="btn my-button-unselected w-100">Request Appointment</a>
                    </div>
                    <div class="mb-4 col-xxl-3">
                        <a href="./manage-appointment.php" class="btn my-button-selected w-100">Manage Appointments</a>
                    </div>
                </div>
                <div class="container-fluid" id="subArea-single">
                    <div class="mb-5">
                        <h5>Manage Appointments</h5>
                    </div>
                    <label class="form-label mb-3">ALL APPOINTMENTS</label>
                    <table id="myTable" class="table table-hover table-striped">
                        <!-- //!TODO: para mailisan ang color sa header -->
                        <thead id="tableHead">
                            <th style="color: white;">Appointment Id</th>
                            <th style="color: white;">Service</th>
                            <th style="color: white;">Date</th>
                            <th style="color: white;">Time</th>
                            <th style="color: white;">Status</th>
                            <th style="color: white;">numberedDate</th>
                            <th style="color: white;">Actions</th>
                        </thead>
                        <tbody>
                            <?php
                            // LOOP TILL END OF DATA
                            while ($rows = $resultAppointment->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td><?php echo $rows['request_app_id']; ?></td>
                                    <td><?php echo $rows['serviceName']; ?></td>
                                    <?php

                                    $date = date_create($rows['start']);
                                    $numberedDateOnly = date_format($date, "m-d-Y");
                                    $dateOnly =  date_format($date, "M d, Y");
                                    $time = date_create($rows['start']);
                                    $timeOnly = date_format($time, "h: i A");

                                    if ($rows['status'] == 'Pending Approval') $badgeType = 'my-badge-pending';
                                    else if ($rows['status'] == 'Denied') $badgeType = 'my-badge-denied';
                                    else if ($rows['status'] == 'Completed' || $rows['status'] == 'Approved') $badgeType = 'my-badge-approved';
                                    else if ($rows['status'] == 'Cancelled') $badgeType = 'my-badge-denied';
                                    ?>
                                    <td><?php echo $dateOnly; ?></td>
                                    <td><?php echo $timeOnly; ?></td>
                                    <td><span class="badge rounded-pill <?php echo $badgeType ?>"><?php echo $rows['status']; ?></span></td>
                                    <td><?php echo $numberedDateOnly; ?></td>
                                    <td></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <script src="./js/data-table-appointments.js"></script>
            <script src="./js/script.js"></script>
</body>

</html>



<!-- Modal -->
<div class="modal" id="exampleModal" data-bs-backdrop="true" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow p-3 mb-5 bg-white rounded border">
            <div class="modal-header">
                <h5 class="modal-title" style="font-size: 16px;" id="exampleModalLabel">Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
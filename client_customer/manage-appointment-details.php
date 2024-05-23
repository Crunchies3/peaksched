<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    echo '<script type="text/javascript"> window.location="index.php";</script>';
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

    <link href="https://cdn.datatables.net/v/bs5/dt-2.0.0/b-3.0.0/b-html5-3.0.0/r-3.0.0/sl-2.0.0/sr-1.4.0/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/v/bs5/dt-2.0.0/b-3.0.0/b-html5-3.0.0/r-3.0.0/sl-2.0.0/sr-1.4.0/datatables.min.js"></script>

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
                    <a href="" class="sidebar-link ">
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
                        <span>Adress</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
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
                        <?php
                        if ($status == 'Pending Approval') $badgeType = 'my-badge-pending';
                        else if ($status == 'Denied') $badgeType = 'my-badge-denied';
                        else if ($status == 'Completed') $badgeType = 'my-badge-approved';
                        else if ($status == 'Approved') $badgeType = 'my-badge-approved';
                        ?>
                        <h5><span><a href="./manage-appointment.php" class="btn my-button-back"><i class="bi bi-chevron-left"></i></a></span>Appointment Details <span class="badge rounded-pill <?php echo $badgeType ?>"><?php echo $status ?></span></h5>
                    </div>
                    <div class="row mb-5">
                        <form id="appointmentId" class="col-md-6 mb-4" action="./manage-appointment-reschedule.php" method="get">
                            <label class="form-label mb-1">APPOINTMENT ID</label>
                            <input hidden name="appointmentId" type="text" class="form-control input-field" aria-label="Appointment Id" value="<?php echo $appointmentId ?>">
                            <input disabled type="text" class="form-control input-field" aria-label="Appointment Id" value="<?php echo $appointmentId ?>">
                        </form>

                        <form hidden id="appointmentCancel" class="col-md-6 mb-4" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <input name="appointmentId" type="text" class="form-control input-field" aria-label="Appointment Id" value="<?php echo $appointmentId ?>">
                        </form>

                        <div class="col-md-6 mb-4">
                            <label class="form-label mb-1">SELECTED SERVICE</label>
                            <input disabled name="selectedService" type="text" class="form-control input-field" aria-label="Selected Service" value="<?php echo $selectedService ?>">
                        </div>
                        <div class="mb-4 col-lg-6 mb-4">
                            <label class="form-label mb-1">DATE</label>
                            <input disabled name="text" class="form-control fs-6 input-field" value="<?php echo $dateOnly ?>">
                        </div>
                        <div class="mb-4 col-lg-6 mb-4">
                            <label class="form-label mb-1">TIME</label>
                            <input disabled name="text" type="text" class="form-control fs-6 input-field" value="<?php echo $timeOnly ?>">
                        </div>
                        <div class="mb-4 col-lg-6 mb-4">
                            <label class="form-label mb-1">ASSIGNED SUPERVISOR</label>
                            <input disabled name="supervisor" type="text" class="form-control fs-6 input-field" value="<?php echo $assignedSupervisor ?>">
                        </div>
                    </div>
                    <div class="row ">
                        <div class="mb-3 col-xxl-3">
                            <button form="appointmentId" class="btn btn-lg fs-6 w-100 my-button-yes">Reschedule Appointment</button>
                        </div>
                        <div class="mb-0 col-xxl-3">
                            <button data-bs-toggle="modal" data-bs-target="#cancelAppointment" class="btn btn-lg fs-6 w-100 my-button-danger">Cancel Appointment</button>
                        </div>
                    </div>
                </div>
            </div>
            <script src="./js/script.js"></script>
</body>

</html>



<!-- Modal -->
<div class="modal fade" id="cancelAppointment" data-bs-backdrop="static" tabindex="-1" aria-labelledby="cancelAppointment" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow p-3 mb-5 bg-white rounded border">
            <div class="modal-header">
                <h1 class="modal-title" style="font-size: 20px;" id="exampleModalLabel">Cancel Appointment?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Your appointment will be cancelled.
            </div>
            <div class="modal-footer">
                <button name="cancelApp" form="appointmentCancel" class="btn my-button-danger">Confirm</button>
                <button type="button" class="btn my-button-no" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
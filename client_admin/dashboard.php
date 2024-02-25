<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}

require_once "php/dashboard.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/bootstrap5@6.1.10/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <script src="./js/full_calendar.js"></script>
    <link rel="stylesheet" href="./css/dashboard_styles.css" />
    <link rel="stylesheet" href="../components/_components.css">
    <script src="https://momentjs.com/downloads/moment.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">

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
                    <a href="" class="sidebar-link selected">
                        <i class="bi bi-house-fill"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="bi bi-calendar2"></i>
                        <span>Appointments</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="employee_page.php" class="sidebar-link">
                        <i class="bi bi-person"></i>
                        <span>Employee</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="./services_page.php" class="sidebar-link">
                        <i class="bi bi-file-post-fill"></i>
                        <span>Services</span>
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
        <div class="main" id="main">
            <div id="calendar"></div>
            <!-- <a class="btn btn-danger" href="./php_backend/logout.php">
                Logout
            </a> -->
        </div>
        <script src="./js/script.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
</body>

</html>



<!-- Modal -->
<div class="modal" id="editAppointment" data-bs-backdrop="true" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="width: 450px;">
        <div class="modal-content shadow p-2 mb-5 bg-white border my-modal">
            <div class="modal-header my-header">
                <h5 class="modal-title" style="font-size: 16px;" id="exampleModalLabel">Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" id="createAppointment" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>
                    <div class="mb-3">
                        <i class="bi bi-circle-fill mx-2" style="color: grey;"></i>
                        <input name="title" id="service" type="text" class="form-control input-field selecServiceInput my-input-field" placeholder="Select a service" value="">
                        <div class="invalid-feedback">
                            Please enter choose a service.
                        </div>
                    </div>
                    <div class="mb-3">
                        <i class="bi bi-calendar mx-2"></i>
                        <input name="date" id="selectedDate" type="date" class="form-control input-field selecServiceInput my-input-field" placeholder="Select a service">
                    </div>
                    <div class="mb-3">
                        <i class="bi bi-clock mx-2"></i>
                        <input name="start" id="start" type="text" class="form-control input-field selecServiceInput my-input-field timepicker" placeholder="" style="width: 163px;" value="12:00 AM">
                        <i class="bi bi-dash-lg"></i>
                        <input name="end" id="end" type="text" class="form-control input-field selecServiceInput my-input-field timepicker" placeholder="" style="width: 163px;" value="12:15 AM">
                        <script src="./js/time_picker.js"></script>
                    </div>
                    <div class="mb-3">
                        <i class="bi bi-person mx-2"></i>
                        <input id="customer" name="customer" type="text" class="form-control input-field selecServiceInput my-input-field" placeholder="Add customer">
                    </div>
                    <div class="mb-3">
                        <i class="bi bi-clock mx-2" style="color: transparent;"></i>
                        <textarea name="description" type="text" rows="3" class="form-control input-field selecServiceInput my-input-field" placeholder="notes to supervisor"></textarea>
                    </div>
                    <div class="mb-3">
                        <i class="bi bi-person mx-2"></i>
                        <input id="supervisor" name="supervisor" type="text" class="form-control input-field selecServiceInput my-input-field" placeholder="Assign supervisor">
                    </div>
                </form>
                <script src="./js/client_validation.js"></script>
            </div>
            <div class="modal-footer my-footer">
                <button class="btn my-button-yes" form="createAppointment">create</button>
                <button type="button" class="btn my-button-no" data-bs-dismiss="modal">cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal" id="appointment" data-bs-backdrop="true" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="width: 450px;">
        <div class="modal-content shadow p-2 mb-5 bg-white border my-modal">
            <div class="modal-header my-header">
                <h5 class="modal-title" style="font-size: 16px;" id="exampleModalLabel">Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" id="addAppointment" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>
                    <div class="mb-3">
                        <i class="bi bi-circle-fill mx-2" style="color: grey;"></i>
                        <input required name="title" id="service" type="text" class="form-control input-field selecServiceInput my-input-field" placeholder="Select a service" value="">
                    </div>
                    <div class="mb-3">
                        <i class="bi bi-calendar mx-2"></i>
                        <input required name="date" id="selectedDateApp" type="date" class="form-control input-field selecServiceInput my-input-field" placeholder="Select a service">
                    </div>
                    <div class="mb-3">
                        <i class="bi bi-clock mx-2"></i>
                        <input required name="start" id="startApp" type="text" class="form-control input-field selecServiceInput my-input-field timepicker" placeholder="" style="width: 163px;" value="12:00 AM">
                        <i class="bi bi-dash-lg"></i>
                        <input required name="end" id="endApp" type="text" class="form-control input-field selecServiceInput my-input-field timepicker" placeholder="" style="width: 163px;" value="12:15 AM">
                        <script src="./js/time_picker.js"></script>
                    </div>
                    <div class="mb-3">
                        <i class="bi bi-person mx-2"></i>
                        <input required id="customer" name="customer" type="text" class="form-control input-field selecServiceInput my-input-field" placeholder="Add customer">
                    </div>
                    <div class="mb-3">
                        <i class="bi bi-clock mx-2" style="color: transparent;"></i>
                        <textarea name="description" type="text" rows="3" class="form-control input-field selecServiceInput my-input-field" placeholder="notes to supervisor"></textarea>
                    </div>
                    <div class="mb-3">
                        <i class="bi bi-person mx-2"></i>
                        <input required id="supervisor" name="supervisor" type="text" class="form-control input-field selecServiceInput my-input-field" placeholder="Assign supervisor">
                    </div>
                    <script src="./js/client_validation.js"></script>
                </form>
            </div>
            <div class="modal-footer my-footer">
                <button class="btn my-button-yes" type="submit" form="addAppointment">create</button>
                <button type="button" class="btn my-button-no" data-bs-dismiss="modal">cancel</button>
            </div>
        </div>
    </div>
</div>
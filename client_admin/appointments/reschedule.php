<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}

require_once "../php/appointment-request-details.php";
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/vanilla-calendar-pro/build/vanilla-calendar.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/vanilla-calendar-pro/build/vanilla-calendar.min.js" defer></script>

    <link href="https://cdn.datatables.net/v/bs5/dt-2.0.0/b-3.0.0/b-html5-3.0.0/r-3.0.0/sl-2.0.0/sr-1.4.0/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/v/bs5/dt-2.0.0/b-3.0.0/b-html5-3.0.0/r-3.0.0/sl-2.0.0/sr-1.4.0/datatables.min.js"></script>

    <link rel="stylesheet" href="../css/dashboard_styles.css" />
    <link rel="stylesheet" href="../css/appointment-styles.css" />
    <link rel="stylesheet" href="../../components/_components.css" />
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
                    <i class="bi bi-calendar-week"></i>
                </button>
                <div class="sidebar-logo">
                    <a href="../">PeakSched</a>
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="../dashboard.php" class="sidebar-link">
                        <i class="bi bi-house"></i>
                        <span>Home</span>
                    </a>
                <li class="sidebar-item">
                    <a href="./" class="sidebar-link selected">
                        <i class="bi bi-calendar2-fill"></i>
                        <span>Appointments</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../employee_page.php" class="sidebar-link ">
                        <i class="bi bi-person"></i>
                        <span>Employee</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../customer_page.php" class="sidebar-link">
                        <i class="bi bi-emoji-smile"></i>
                        <span>Customer</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../payroll/" class="sidebar-link ">
                        <i class="bi bi-wallet"></i>
                        <span>Payroll</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../services_page.php" class="sidebar-link">
                        <i class="bi bi-file-post-fill"></i>
                        <span>Services</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../reports/" class="sidebar-link">
                        <i class="bi bi-flag"></i>
                        <span>Reports</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="bi bi-bell"></i>
                        <span>Notifications</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../setting_account_page.php" class="sidebar-link ">
                        <i class="bi bi-gear"></i>
                        <span>Settings</span>
                    </a>
                </li>
            </ul>
            <div class="sidebar-footer">
                <a href="../php/logout.php" class="sidebar-link">
                    <i class="bi bi-box-arrow-left"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>
        <section class="main p-2" id="main">
            <div class="container-fluid" id="mainArea">
                <div class="mb-5">
                    <h1>Appointments</h1>
                </div>
                <div class="container-fluid" id="subArea-single">
                    <div>
                        <h5><span><a href="./" class="btn my-button-back"><i class="bi bi-chevron-left"></i></a></span> Appointment Request Details</h5>
                    </div>
                    <form id="reSched" class="row mb-5" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="col-md-6 mb-4">
                            <div class="mb-4">
                                <label class="form-label mb-1">APPOINTMENT ID</label>
                                <input hidden name="appointmentId" type="text" class="form-control input-field" aria-label="Appointment Id" value="<?php echo $appointmentId ?>">
                                <input disabled type="text" class="form-control input-field" aria-label="Appointment Id" value="<?php echo $appointmentId ?>">
                            </div>
                            <div>
                                <label class="form-label mb-1 <?php echo (!empty($selectedDate_err)) ? 'is-invalid' : ''; ?>">DATE <span class="my-form-required">*</span></label>
                                <div class="invalid-feedback">
                                    <?php echo $selectedDate_err; ?>
                                </div>
                                <div id="calendar" class="w-100 mb-2"></div>
                                <script src="../js/vanilla-calendar.js"></script>
                                <input hidden id="selectedDate" class="form-control input-field" name="selectedDate" value="">
                            </div>
                        </div>
                        <div class="col-lg-6 p-3">
                            <label class="form-label mb-1 <?php echo (!empty($selectedTime_err)) ? 'is-invalid' : ''; ?>">TIME <span class="my-form-required">*</span></label>
                            <div class="invalid-feedback">
                                <?php echo $selectedTime_err; ?>
                            </div>
                            <div class="form-check mb-2 mt-4">
                                <input type="radio" class="btn-check" name="options" id="option1" autocomplete="off" value="8:00 AM" <?php if (isset($_POST['options']) && $_POST['options'] == '8:00 AM') echo 'checked'; ?>>
                                <label class="btn btn-outline-secondary w-100" for="option1">8:00 AM</label>
                            </div>
                            <div class="form-check mb-2">
                                <input type="radio" class="btn-check" name="options" id="option2" autocomplete="off" value="9:00 AM" <?php if (isset($_POST['options']) && $_POST['options'] == '9:00 AM') echo 'checked'; ?>>
                                <label class="btn btn-outline-secondary w-100" for="option2">9:00 AM</label>
                            </div>
                            <div class="form-check mb-2">
                                <input type="radio" class="btn-check" name="options" id="option3" autocomplete="off" value="10:00 AM" <?php if (isset($_POST['options']) && $_POST['options'] == '10:00 AM') echo 'checked'; ?>>
                                <label class="btn btn-outline-secondary w-100" for="option3">10:00 AM</label>
                            </div>
                            <div class="form-check mb-2">
                                <input type="radio" class="btn-check" name="options" id="option4" autocomplete="off" value="11:00 AM" <?php if (isset($_POST['options']) && $_POST['options'] == '11:00 AM') echo 'checked'; ?>>
                                <label class="btn btn-outline-secondary w-100" for="option4">11:00 AM</label>
                            </div>
                            <div class="form-check mb-2">
                                <input type="radio" class="btn-check" name="options" id="option5" autocomplete="off" value="12:00 PM" <?php if (isset($_POST['options']) && $_POST['options'] == '12:00 PM') echo 'checked'; ?>>
                                <label class="btn btn-outline-secondary w-100" for="option5">12:00 PM</label>
                            </div>
                            <div class="form-check mb-2">
                                <input type="radio" class="btn-check" name="options" id="option6" autocomplete="off" value="1:00 PM" <?php if (isset($_POST['options']) && $_POST['options'] == '1:00 PM') echo 'checked'; ?>>
                                <label class="btn btn-outline-secondary w-100" for="option6">1:00 PM</label>
                            </div>
                            <div class="form-check mb-2">
                                <input type="radio" class="btn-check" name="options" id="option7" autocomplete="off" value="2:00 PM" <?php if (isset($_POST['options']) && $_POST['options'] == '2:00 PM') echo 'checked'; ?>>
                                <label class="btn btn-outline-secondary w-100" for="option7">2:00 PM</label>
                            </div>
                            <div class="form-check mb-5">
                                <input type="radio" class="btn-check" name="options" id="option8" autocomplete="off" value="3:00 PM" <?php if (isset($_POST['options']) && $_POST['options'] == '3:00 PM') echo 'checked'; ?>>
                                <label class="btn btn-outline-secondary w-100" for="option8">3:00 PM</label>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="mb-3 col-xxl-2">
                            <button data-bs-toggle="modal" data-bs-target="#reschedApp" class="btn btn-lg fs-6 w-100 my-button-yes">Submit Request</button>
                        </div>
                        <div class="mb-0 col-xxl-2">
                            <a href="./manage-appointment.php" class="btn btn-lg fs-6 w-100 my-button-no">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
            <script src="./js/script.js"></script>
</body>

</html>



<!-- Modal -->
<div class="modal fade" id="reschedApp" data-bs-backdrop="static" tabindex="-1" aria-labelledby="reschedApp" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="width: 500px;">
        <div class="modal-content shadow p-3 mb-5 bg-white rounded border">
            <div class="modal-header">
                <h1 class="modal-title" style="font-size: 20px;" id="exampleModalLabel">Request Reschedule Appointment?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Your request will be submitted.
            </div>
            <div class="modal-footer">
                <button name="reschedApp" form="reSched" class="btn my-button-yes">Confirm</button>
                <button type="button" class="btn my-button-no" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
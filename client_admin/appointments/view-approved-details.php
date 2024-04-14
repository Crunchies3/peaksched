<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}

require_once "../php/appointment-approved-details.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Employee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="../css/dashboard_styles.css" />
    <link rel="stylesheet" href="../../components/_components.css">
    <link href="../../select_box/dist/jquery-editable-select.min.css" rel="stylesheet">
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
                <div class="container-fluid" id="subArea-top">
                    <div>
                        <h5><span><a href="./approved-appointments.php" class="btn my-button-back"><i class="bi bi-chevron-left"></i></a></span>Appointment Details</h5>
                    </div>
                    <form id="appointmentDetails" class="row mb-3" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" novalidate>
                        <input type="hidden" name="appointmentId" value="<?= htmlspecialchars($appointmentId) ?>" id="appointmentId">
                        <div class="col-md-6 mb-4">
                            <label class="form-label mb-1">APPOINTMENT ID</label>
                            <input disabled name="firstName" type="text" class="form-control input-field" placeholder="Enter your first name" aria-label="Current Password" value="<?php echo $appointmentId ?>">
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label mb-1">CUSTOMER NAME</label>
                            <input disabled name="lastName" type="text" class="form-control input-field" placeholder="Enter your last name" aria-label="Last name" value="<?php echo $fullname ?>">
                        </div>
                        <div class="mb-4 col-lg-6 mb-4">
                            <label class="form-label mb-1">SERVICE</label>
                            <input disabled name="email" type="email" class="form-control fs-6 input-field" placeholder="Enter your email address" value="<?php echo $serviceTitle ?>">
                        </div>
                        <div class="mb-4 col-lg-6 mb-4">
                            <label class="form-label mb-1">ADDRESS</label>
                            <input disabled name="email" type="email" class="form-control fs-6 input-field" placeholder="Enter your email address" value="<?php echo $fullAddress ?>">
                        </div>
                        <div class="mb-4 col-lg-6 mb-4">
                            <label class="form-label mb-1">DATE</label>
                            <input disabled name="position" type="text" class="form-control fs-6 input-field" placeholder="Enter your position" value="<?php echo $date ?>">
                        </div>
                        <div class="mb-4 col-lg-6 mb-4">
                            <label class="form-label mb-1">TIME</label>
                            <input disabled name="position" type="text" class="form-control fs-6 input-field" placeholder="Enter your position" value="<?php echo $time ?>">
                        </div>
                        <div class="mb-4 col-lg-6 mb-4">
                            <label class="form-label mb-1">NUMBER OF FLOORS</label>
                            <input disabled name="position" type="text" class="form-control fs-6 input-field" placeholder="other" value="<?php echo $num_floors ?>">
                        </div>
                        <div class="mb-4 col-lg-6 mb-4">
                            <label class="form-label mb-1">NUMBER OF BEDS</label>
                            <input disabled name="position" type="text" class="form-control fs-6 input-field" placeholder="other" value="<?php echo $num_beds ?>">
                        </div>
                        <div class="mb-4 col-lg-6 mb-4">
                            <label class="form-label mb-1">NUMBER OF BATHS</label>
                            <input disabled name="position" type="text" class="form-control fs-6 input-field" placeholder="other" value="<?php echo $num_baths ?>">
                        </div>
                        <div class="mb-4 col-lg-6 mb-4">
                            <label class="form-label mb-1">ASSIGNED SUPERVISOR</label>
                            <input disabled name="position" type="text" class="form-control fs-6 input-field" placeholder="" value="<?php echo $supFullname ?>">
                        </div>
                        <div>
                            <label class="form-label mb-2">SPECIAL INSTRUCTION OR COMMENTS</label>
                            <textarea readonly name="note" type="text" rows="3" class="form-control input-field w-100 selecServiceInput " placeholder=""><?php echo $note ?></textarea>
                        </div>
                    </form>
                    <div class="row justify-content-between">
                        <div class="col-xxl-2 mb-4">
                            <div class="mb-6">
                                <button href="./manage-appointment.php" class="btn my-button-yes w-100">Reschedule</button>
                            </div>
                        </div>
                        <div class="mb-4 col-xxl-2">
                            <button data-bs-toggle="modal" data-bs-target="#denyRequestModal" class="btn my-button-danger w-100">Cancel Appointment</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script src="../js/script.js"></script>

</body>

</html>
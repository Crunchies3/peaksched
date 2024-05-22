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
                        <h5><span><a href="./" class="btn my-button-back"><i class="bi bi-chevron-left"></i></a></span> Appointment Request Details</h5>
                    </div>
                    <form id="appointmentDetails" class="row mb-3" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" novalidate>
                        <input type="hidden" name="appointmentId" value="<?= htmlspecialchars($appointmentId) ?>" id="appointmentId">
                        <div class="col-md-6 mb-4">
                            <label class="form-label mb-1">APPOINTMENT ID</label>
                            <input disabled name="firstName" type="text" class="form-control input-field" placeholder="Enter your first name" aria-label="Current Password" value="<?php echo $appointmentId ?>">
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label mb-1">CUSTOMER NAME</label>
                            <input disabled name="lastName" type="text" class="form-control input-field" placeholder="Enter your last name" aria-label="Last name" value="<?php echo $customerName ?>">
                        </div>
                        <div class="mb-4 col-lg-6 mb-4">
                            <label class="form-label mb-1">SERVICE</label>
                            <input disabled name="email" type="email" class="form-control fs-6 input-field" placeholder="Enter your email address" value="<?php echo $service ?>">
                        </div>
                        <div class="mb-4 col-lg-6 mb-4">
                            <label class="form-label mb-1">ADDRESS</label>
                            <input disabled name="email" type="email" class="form-control fs-6 input-field" placeholder="Enter your email address" value="<?php echo $address ?>">
                        </div>
                        <div class="mb-4 col-lg-6 mb-4">
                            <label class="form-label mb-1">DATE</label>
                            <input disabled name="position" type="text" class="form-control fs-6 input-field" placeholder="Enter your position" value="<?php echo $dateOnly ?>">
                        </div>
                        <div class="mb-4 col-lg-6 mb-4">
                            <label class="form-label mb-1">TIME</label>
                            <input disabled name="position" type="text" class="form-control fs-6 input-field" placeholder="Enter your position" value="<?php echo $timeOnly ?>">
                        </div>
                        <div class="mb-4 col-lg-6 mb-4">
                            <label class="form-label mb-1">NUMBER OF FLOORS</label>
                            <input disabled name="position" type="text" class="form-control fs-6 input-field" placeholder="Enter your position" value="<?php echo $numOfFloors ?>">
                        </div>
                        <div class="mb-4 col-lg-6 mb-4">
                            <label class="form-label mb-1">NUMBER OF BEDS</label>
                            <input disabled name="position" type="text" class="form-control fs-6 input-field" placeholder="Enter your position" value="<?php echo $numOfBeds ?>">
                        </div>
                        <div class="mb-4 col-lg-6 mb-4">
                            <label class="form-label mb-1">NUMBER OF BATHS</label>
                            <input disabled name="position" type="text" class="form-control fs-6 input-field" placeholder="Enter your position" value="<?php echo $numOfBaths ?>">
                        </div>
                        <div class="mb-4 col-lg-6 mb-4">
                            <label class="form-label mb-1 <?php echo (!empty($supervisorErr)) ? 'is-invalid' : ''; ?>">ASSIGN A SUPERVISOR <span class="my-form-required">*</span></label>
                            <div class="invalid-feedback">
                                <?php echo $supervisorErr; ?>
                            </div>
                            <select required id="supervisorList3">
                                <?php
                                // LOOP TILL END OF DATA
                                for ($i = 0; $i < count($supervisorList); $i++) {
                                ?>
                                    <option><?php echo  $supervisorList[$i]['firstname'] . ' ' .  $supervisorList[$i]['lastname']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div>
                            <label class="form-label mb-2">SPECIAL INSTRUCTION OR COMMENTS</label>
                            <textarea readonly name="note" type="text" rows="3" class="form-control input-field w-100 selecServiceInput " placeholder=""><?php echo $note ?></textarea>
                        </div>
                    </form>
                    <form id="reschedApp" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" novalidate>
                        <input type="hidden" name="appointmentId" value="<?= htmlspecialchars($appointmentId) ?>" id="appointmentId">
                    </form>
                    <div class="row justify-content-between">
                        <div class="row col-lg-6">
                            <div class="mb-6 col-xxl-4">
                                <button data-bs-toggle="modal" data-bs-target="#approveRequestModal" class="btn btn-lg fs-6 w-100 my-button-yes">Approve Appointment</button>
                            </div>
                            <div class="mb-6 col-xxl-4">
                                <form action="./reschedule.php" id="resched" method="get"><input id="appointmentId" hidden type="text" name="appointmentId" value="<?php echo $appointmentId ?>"></form><button form="resched" class="btn my-button-no w-100" id="actionClick">Reschedule</button>
                            </div>
                        </div>
                        <div class="mb-4 col-xxl-2">
                            <button data-bs-toggle="modal" data-bs-target="#denyRequestModal" class="btn my-button-danger w-100">Deny Request</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script src="../js/script.js"></script>
        <script src="../../select_box/dist/jquery-editable-select.js"></script>
        <script src="../../select_box/src/jquery-editable-select.js"></script>
        <script src="../js/select_box.js"></script>
</body>

</html>

<div class="modal fade" id="approveRequestModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="approveRequestModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="width: 500px;">
        <div class="modal-content shadow p-3 mb-5 bg-white rounded border">
            <div class="modal-header">
                <h1 class="modal-title" style="font-size: 20px;" id="exampleModalLabel">Approve Appointment?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Appointment will be approved
            </div>
            <div class="modal-footer">
                <button name="approveApp" form="appointmentDetails" class="btn my-button-yes">Confirm</button>
                <button type="button" class="btn my-button-no" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="denyRequestModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="denyRequestModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="width: 500px;">
        <div class="modal-content shadow p-3 mb-5 bg-white rounded border">
            <div class="modal-header">
                <h1 class="modal-title" style="font-size: 20px;" id="exampleModalLabel">Deny Appointment?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Appointment will be denied
            </div>
            <div class="modal-footer">
                <button name="denyRequestModal" form="appointmentDetails" class="btn my-button-danger">Confirm</button>
                <button type="button" class="btn my-button-no" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}

require_once "php/assigned_app_supervisor_view.php";
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

    <!-- DataTables CDN -->

    <link href="https://cdn.datatables.net/v/bs5/dt-2.0.0/b-3.0.0/b-html5-3.0.0/r-3.0.0/sl-2.0.0/sr-1.4.0/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/v/bs5/dt-2.0.0/b-3.0.0/b-html5-3.0.0/r-3.0.0/sl-2.0.0/sr-1.4.0/datatables.min.js"></script>
    <!-- end -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="./css/dashboard_styles.css" />
    <link rel="stylesheet" href="./css/assigned-app-view-sup-styles.css">
    <link rel="stylesheet" href="../components/_components.css">
    <link rel="stylesheet" href="./css/setting_page_styles.css">
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
                    <a href="dashboard_supervisor.php" class="sidebar-link">
                        <i class="bi bi-house"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="assigned-appointment-supervisor.php" class="sidebar-link selected">
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
                    <a href="supervisor_setting_account_page.php" class="sidebar-link ">
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

            <div class="container-fluid" id="employeeArea">
                <div class="mb-5">
                    <h1>Appointment</h1>
                </div>
                <div class="container-fluid" id="addWorkerArea">
                    <div>
                        <h5>Appointment Details</h5>
                    </div>
                    <form id="editWorkerForm" class="row" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" novalidate>
                        <input type="hidden" name="appointmentId" value="<?= htmlspecialchars($appointmentId) ?>" id="appointmentId">
                        <div class="col-md-6 mb-4">
                            <label class="form-label mb-1">APPOINTMENT ID</label>
                            <input name="firstName" type="text" class="form-control input-field <?php echo (!empty($firstName_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter your first name" aria-label="Current Password" value="<?php echo $appointmentId ?>">
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label mb-1">FULL NAME</label>
                            <input name="lastName" type="text" class="form-control input-field <?php echo (!empty($lastName_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter your last name" aria-label="Last name" value="<?php echo $fullname ?>">
                        </div>
                        <div class="mb-4 col-lg-6 mb-4">
                            <label class="form-label mb-1">SERVICE</label>
                            <input name="email" type="email" class="form-control fs-6 input-field <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter your email address" value="<?php echo $title ?>">
                        </div>
                        <div class="mb-4 col-lg-6 mb-4">
                            <label class="form-label mb-1">STATUS</label>
                            <input name="mobile" type="text" class="form-control fs-6 input-field <?php echo (!empty($mobileNumber_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter your mobile number" value="<?php echo $status ?>">
                        </div>
                        <div class="mb-4 col-lg-6 mb-4">
                            <label class="form-label mb-1">DATE</label>
                            <input name="position" type="text" class="form-control fs-6 input-field <?php echo (!empty($mobileNumber_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter your position" value="<?php echo $date ?>">
                        </div>
                    </form>
                </div>
            </div>
            <div class="container-fluid" id="appointmentArea">
                <div class="container-fluid" id="appointmentTableArea">
                    <div>
                        <h5>Assigned workers</h5>
                    </div>
                    <table id="myTable" class="table table-hover table-striped">
                        <!-- //!TODO: para mailisan ang color sa header -->
                        <thead id="tableHead">
                        <th style="color: white;">Id</th>
                            <th style="color: white;">Fullname</th>
                            <th style="color: white;">Email</th>
                            <th style="color: white;">Phone</th>
                            <th style="color: white;">Actions</th>
                        </thead>
                        <tbody>
                        <?php
                            // LOOP TILL END OF DATA
                            while ($rows = $result->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td><?php echo $rows['employeeid']; ?></td>
                                    <td><?php echo $rows['fullname']; ?></td>
                                    <td><?php echo $rows['email']; ?></td>
                                    <td><?php echo $rows['mobilenumber']; ?></td>
                                    <td></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </section>
        <script src="./js/data-table-appointment-view.js"></script>
        <script src="./js/script.js"></script>
</body>

</html>


<!-- //? modal paras confirmation sa pag update sa details -->

<div class="modal fade" id="updateInfoModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="updateInfoModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="width: 500px;">
        <div class="modal-content shadow p-3 mb-5 bg-white rounded border">
            <div class="modal-header">
                <h1 class="modal-title" style="font-size: 20px;" id="exampleModalLabel">Confirm changes?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Your account details will be updated.
            </div>
            <div class="modal-footer">
                <button name="updateInfo" form="editWorkerForm" class="btn my-button-yes">Confirm</button>
                <button type="button" class="btn my-button-no" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>




<!-- //? modal paras confirmation sa pag delete sa user -->

<div class="modal fade" id="deleteEmployeeAccountModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="deleteEmployeeAccountModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="width: 500px;">
        <div class="modal-content shadow p-3 mb-5 bg-white rounded border">
            <div class="modal-header">
                <h1 class="modal-title" style="font-size: 20px;" id="exampleModalLabel">Confirm delete account?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Your account will be deleted.
            </div>
            <div class="modal-footer">
                <button name="deleteAccount" form="RemoveWorkerForm" class="btn my-button-danger">Confirm</button>
                <button type="button" class="btn my-button-no" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- //? modal paras confirmation sa pag delete sa worker -->

<div class="modal fade" id="RemoveWorker" data-bs-backdrop="static" tabindex="-1" aria-labelledby="RemoveWorker" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="width: 500px;">
        <div class="modal-content shadow p-3 mb-5 bg-white rounded border">
            <div class="modal-header">
                <h1 class="modal-title" style="font-size: 20px;" id="exampleModalLabel">Confirm remove worker?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               Assigned worker will be removed.
            </div>
            <div class="modal-footer">
                <button name="RemoveWorker" form="RemoveWorkerForm" class="btn my-button-danger">Confirm</button>
                <button type="button" class="btn my-button-no" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
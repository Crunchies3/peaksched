<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    echo '<script type="text/javascript"> window.location="index.php";</script>';
    exit;
}
require_once "php/asigned_worker_super.php"; // para sa table ni supervisor na makita ang mga naka assign na workers
require_once "php/employee_supervisor_editing.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PeakSched</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- DataTables CDN -->

    <link href="https://cdn.datatables.net/v/bs5/dt-2.0.0/b-3.0.0/b-html5-3.0.0/r-3.0.0/sl-2.0.0/sr-1.4.0/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/v/bs5/dt-2.0.0/b-3.0.0/b-html5-3.0.0/r-3.0.0/sl-2.0.0/sr-1.4.0/datatables.min.js"></script>
    <!-- end -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="./css/dashboard_styles.css" />
    <link rel="stylesheet" href="./css/employee_supervisor_view_styles.css">
    <link rel="stylesheet" href="../components/_components.css">
    <link rel="stylesheet" href="./css/setting_page_styles.css">
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
                    <a href="./appointments/" class="sidebar-link">
                        <i class="bi bi-calendar2"></i>
                        <span>Appointments</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="employee_page.php" class="sidebar-link selected">
                        <i class="bi bi-person-fill"></i>
                        <span>Employee</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="./customer_page.php" class="sidebar-link">
                        <i class="bi bi-emoji-smile"></i>
                        <span>Customer</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="./payroll/" class="sidebar-link ">
                        <i class="bi bi-wallet"></i>
                        <span>Payroll</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="./services_page.php" class="sidebar-link">
                        <i class="bi bi-file-post-fill"></i>
                        <span>Services</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="./reports/" class="sidebar-link">
                        <i class="bi bi-flag"></i>
                        <span>Reports</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="./notifcation/" class="sidebar-link">
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
                <a href="php/logout.php" class="sidebar-link">
                    <i class="bi bi-box-arrow-left"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>
        <section class="main p-2" id="main">

            <div class="container-fluid" id="mainArea">
                <div class="mb-5">
                    <h1>Employee</h1>
                </div>
                <div class="container-fluid" id="subArea-top">
                    <div>
                        <h5><span><a href="./employee_page.php" class="btn my-button-back"><i class="bi bi-chevron-left"></i></a></span> Edit Employee</h5>
                    </div>
                    <form id="editEmployeeForm" class="row" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" novalidate>
                        <input type="hidden" name="employeeId" value="<?= htmlspecialchars($employeeId) ?>" id="supervisorId">
                        <div class="col-md-6 mb-4">
                            <label class="form-label mb-1">FIRST NAME</label>
                            <input name="firstName" type="text" class="form-control input-field <?php echo (!empty($firstName_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter your first name" aria-label="Current Password" value="<?php echo $firstName ?>">
                            <div class="invalid-feedback">
                                <?php echo $firstName_err; ?>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label mb-1">LAST NAME</label>
                            <input name="lastName" type="text" class="form-control input-field <?php echo (!empty($lastName_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter your last name" aria-label="Last name" value="<?php echo $lastName ?>">
                            <div class="invalid-feedback">
                                <?php echo $lastName_err; ?>
                            </div>
                        </div>
                        <div class="mb-4 col-lg-6 mb-4">
                            <label class="form-label mb-1">EMAIL ADDRESS</label>
                            <input name="email" type="email" class="form-control fs-6 input-field <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter your email address" value="<?php echo $email ?>">
                            <div class="invalid-feedback">
                                <?php echo $email_err; ?>
                            </div>
                        </div>
                        <div class="mb-4 col-lg-6 mb-4">
                            <label class="form-label mb-1">PHONE NUMBER</label>
                            <input name="mobile" type="text" class="form-control fs-6 input-field <?php echo (!empty($mobileNumber_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter your mobile number" value="<?php echo $mobileNumber ?>">
                            <div class="invalid-feedback">
                                <?php echo $mobileNumber_err; ?>
                            </div>
                        </div>
                        <div class="mb-4 col-lg-6 mb-4">
                            <label class="form-label mb-1">POSITION</label>
                            <input name="position" type="text" class="form-control fs-6 input-field <?php echo (!empty($mobileNumber_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter your position" value="<?php echo $position ?>">
                            <div class="invalid-feedback">
                                <?php echo $position_err; ?>
                            </div>
                        </div>
                        <div class="mb-4 col-lg-6 mb-4">
                            <label class="form-label mb-1">PAYRATE</label>
                            <input name="payrate" type="number" class="form-control fs-6 input-field <?php echo (!empty($payrate_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter employee's payrate" value="<?php echo $payrate ?>">
                            <div class="invalid-feedback">
                                <?php echo $payrate_err; ?>
                            </div>
                        </div>
                        <!-- //! gitangaal nako ang status -->
                        <!-- <div class="mb-4 col-lg-6 mb-4">
                            <label class="form-label mb-1">STATUS</label>
                            <input name="status" type="text" class="form-control fs-6 input-field <?php echo (!empty($status_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter employee's status" value="<?php echo $status ?>">
                            <div class="invalid-feedback">
                                <?php echo $status_err; ?>
                            </div>
                        </div> -->
                    </form>
                    <div class="row">
                        <div class="mb-3 col-xxl-2">
                            <button data-bs-toggle="modal" data-bs-target="#updateInfoModal" class="btn btn-lg fs-6 w-100 my-button-yes">Save Changes</button>
                        </div>
                        <div class="mb-0 col-xxl-2">
                            <a href="./employee_page.php" name="discardChanges" class="btn btn-lg fs-6 w-100 my-button-no">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid" id="employeeArea">
                <div class="container-fluid" id="tablelistTableArea">
                    <div>
                        <h5>Assigned workers</h5>
                    </div>
                    <table id="myTable" class="table table-hover table-striped">
                        <!-- //!TODO: para mailisan ang color sa header -->
                        <thead id="tableHead">
                            <th style="color: white;">Id</th>
                            <th style="color: white;">Fullname</th>
                            <th style="color: white;">Position</th>
                            <th style="color: white;">Email</th>
                            <th style="color: white;">Phone</th>
                            <th style="color: white;">Actions</th>
                        </thead>
                        <tbody>
                            <?php
                            // LOOP TILL END OF DATA
                            while ($rows = $supervisorWorkers->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td><?php echo $rows['employeeid']; ?></td>
                                    <td><?php echo $rows['fullname']; ?></td>
                                    <td><?php echo $rows['type']; ?></td>
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

            <div class="container-fluid" id="employeeArea">
                <div class="container-fluid" id="subArea-bottom">
                    <div>
                        <h5>Account</h5>
                    </div>
                    <form id="editPasswordForm" class="row" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" novalidate>
                        <input type="hidden" name="employeeId" value="<?= htmlspecialchars($employeeId) ?>" id="supId">

                        <div class="col-lg-6 mb-4">
                            <label class="form-label mb-1">NEW PASSWORD</label>
                            <input name="newPassword" type="password" class="form-control input-field <?php echo (!empty($newPassword_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter your new password" aria-label="Last name" value="<?php echo $newPassword; ?>">
                            <div class="invalid-feedback">
                                <?php echo $newPassword_err; ?>
                            </div>
                        </div>
                        <div class="mb-4 col-lg-6 mb-4">
                            <label class="form-label mb-1">CONFIRM NEW PASSWORD</label>
                            <input name="confirmPassword" type="password" class="form-control fs-6 input-field mb-2 <?php echo (!empty($confirmPassword_err)) ? 'is-invalid' : ''; ?>" placeholder="Re-enter your new password" value="<?php echo $confirmPassword; ?>">
                            <div class="invalid-feedback">
                                <?php echo $confirmPassword_err; ?>
                            </div>
                            <div class="password-reminder">
                                <small>Password must be atleast 8 characters long and include a mix of uppercase letters, lowercase letters, and numbers.</small>
                            </div>
                        </div>
                    </form>
                    <div class="row justify-content-between">
                        <div class="mb-3 col-xxl-2">
                            <button data-bs-toggle="modal" data-bs-target="#updatePasswordModal" class="btn btn-lg fs-6 w-100 my-button-yes">Save Changes</button>
                        </div>
                        <div class="mb-0 col-xxl-2">
                            <button data-bs-toggle="modal" data-bs-target="#deleteEmployeeAccountModal" class="btn btn-lg fs-6 w-100 my-button-danger">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script src="./js/data_table_supervisor_view.js"></script>
        <script src="./js/script.js"></script>
</body>

</html>


<!-- //? modal paras confirmation sa pag update sa details -->

<div class="modal fade" id="updateInfoModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="updateInfoModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow p-3 mb-5 bg-white rounded border">
            <div class="modal-header">
                <h1 class="modal-title" style="font-size: 20px;" id="exampleModalLabel">Confirm changes?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Your account details will be updated.
            </div>
            <div class="modal-footer">
                <button name="updateInfo" form="editEmployeeForm" class="btn my-button-yes">Confirm</button>
                <button type="button" class="btn my-button-no" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>




<!-- //? modal paras confirmation sa pag delete sa user -->

<div class="modal fade" id="deleteEmployeeAccountModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="deleteEmployeeAccountModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
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

<div class="modal fade" id="deleteWorkerAccountModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="RemoveWorker" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow p-3 mb-5 bg-white rounded border">
            <div class="modal-header">
                <h1 class="modal-title" style="font-size: 20px;" id="exampleModalLabel">Confirm remove worker?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Assigned worker will be removed.
            </div>
            <div class="modal-footer">
                <button name="deleteWorkerAccountModal" form="RemoveWorkerForm" class="btn my-button-danger">Confirm</button>
                <button type="button" class="btn my-button-no" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>




<!-- //? modal paras confirmation sa pag update sa password -->

<div class="modal fade" id="updatePasswordModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="updatePasswordModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="width: 500px;">
        <div class="modal-content shadow p-3 mb-5 bg-white rounded border">
            <div class="modal-header">
                <h1 class="modal-title" style="font-size: 20px;" id="exampleModalLabel">Confirm change password?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Your password will be updated.
            </div>
            <div class="modal-footer">
                <button name="changePassword" form="editPasswordForm" class="btn my-button-yes">Confirm</button>
                <button type="button" class="btn my-button-no" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    echo '<script type="text/javascript"> window.location="index.php";</script>';
    exit;
}

require_once "php/employee_adding.php";

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
    <script src="./js/colorPick.js"></script>

    <link rel="stylesheet" href="./css/dashboard_styles.css" />
    <link rel="stylesheet" href="./css/employee_page_styles.css" />
    <link rel="stylesheet" href="../components/_components.css">
    <link href="../select_box/dist/jquery-editable-select.min.css" rel="stylesheet">

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
                    <a href="./employee_page.php" class="sidebar-link selected">
                        <i class="bi bi-person-fill"></i>
                        <span>Employee</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="./customer_page.php" class="sidebar-link ">
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
                    <a href="./setting_account_page.php" class="sidebar-link">
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
                <div class="container-fluid" id="subArea-single">
                    <div>
                        <h5> <span><a href="./employee_page.php" class="btn my-button-back"><i class="bi bi-chevron-left"></i></a></span> Add Employee</h5>
                    </div>
                    <form id="addEmployeeForm" class="row needs-validation" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" novalidate>
                        <div class="col-md-6 mb-4">
                            <label class="form-label mb-1">FIRST NAME <span class="my-form-required">*</span></label>
                            <input name="firstName" type="text" class="form-control input-field <?php echo (!empty($firstName_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter your first name" aria-label="Current Password" value="<?php echo $firstName ?>">
                            <div class="invalid-feedback">
                                <?php echo $firstName_err; ?>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label mb-1">LAST NAME <span class="my-form-required">*</span></label>
                            <input name="lastName" type="text" class="form-control input-field <?php echo (!empty($lastName_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter your last name" aria-label="Last name" value="<?php echo $lastName ?>">
                            <div class="invalid-feedback">
                                <?php echo $lastName_err; ?>
                            </div>
                        </div>
                        <div class="mb-4 col-lg-6 mb-4">
                            <label class="form-label mb-1">EMAIL ADDRESS <span class="my-form-required">*</span></label>
                            <input name="email" type="email" class="form-control fs-6 input-field <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter your email address" value="<?php echo $email ?>">
                            <div class="invalid-feedback">
                                <?php echo $email_err; ?>
                            </div>
                        </div>
                        <div class="mb-4 col-lg-6 mb-4">
                            <label class="form-label mb-1">PHONE NUMBER <span class="my-form-required">*</span></label>
                            <input name="mobile" type="text" class="form-control fs-6 input-field <?php echo (!empty($mobileNumber_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter your mobile number" value="<?php echo $mobileNumber ?>">
                            <div class="invalid-feedback">
                                <?php echo $mobileNumber_err; ?>
                            </div>
                        </div>
                        <div class="mb-4 col-lg-6 mb-4">
                            <label class="form-label mb-1">POSITION <span class="my-form-required">*</span></label>
                            <select required id="positionList" required>
                                <option>supervisor</option>
                                <option>worker</option>
                            </select>
                            <!-- <input name="position" type="text" class="form-control fs-6 input-field <?php echo (!empty($position_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter your position" value="<?php echo $position ?>"> -->
                            <div class="invalid-feedback">
                                <?php echo $position_err; ?>
                            </div>
                        </div>
                        <div class="mb-4 col-lg-6 mb-4">
                            <label class="form-label mb-1">PAY RATE <span class="my-form-required">*</span></label>
                            <input name="payrate" type="number" class="form-control fs-6 input-field <?php echo (!empty($payrate_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter payrate" value="<?php echo $payrate ?>">
                            <div class="invalid-feedback">
                                <?php echo $payrate_err; ?>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="mb-3 col-xxl-2">
                            <button data-bs-toggle="modal" data-bs-target="#addEmployeeModal" type="submit" class="btn btn-lg fs-6 w-100 my-button-yes">Save</button>
                        </div>
                        <div class="mb-0 col-xxl-2">
                            <a href="./employee_page.php" name="discardChanges" class="btn btn-lg fs-6 w-100 my-button-no">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script src="./js/script.js"></script>
        <script src="../select_box/dist/jquery-editable-select.js"></script>
        <script src="../select_box/src/jquery-editable-select.js"></script>
        <script src="./js/client_validation.js"></script>
        <script src="./js/select_box.js"></script>

</body>

</html>

<div class="modal fade" id="addEmployeeModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="addEmployeeModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow p-3 mb-5 bg-white rounded border">
            <div class="modal-header">
                <h1 class="modal-title" style="font-size: 20px;" id="exampleModalLabel">Confirm add employee?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Employee will be added.
            </div>
            <div class="modal-footer">
                <button name="addEmployee" form="addEmployeeForm" class="btn my-button-yes">Confirm</button>
                <button type="button" class="btn my-button-no" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
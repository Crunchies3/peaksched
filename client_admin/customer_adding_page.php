<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}

require_once "php/customer_adding.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Settings</title>
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
    <link rel="stylesheet" href="./css/customer_page_styles.css" />
    <link rel="stylesheet" href="../components/_components.css">

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
                    <a href="./employee_page.php" class="sidebar-link">
                        <i class="bi bi-person"></i>
                        <span>Employee</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="customer_page.php" class="sidebar-link selected">
                        <i class="bi bi-emoji-smile-fill"></i>
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
                    <h1>Customer</h1>
                </div>
                <div class="container-fluid" id="subArea-single">
                    <div>
                        <h5><span><a href="./customer_page.php" class="btn my-button-back"><i class="bi bi-chevron-left"></i></a></span>Add Customer</h5>
                    </div>
                    <form id="addCustomerForm" class="row" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" novalidate>
                        <div class="col-md-6 mb-4">
                            <label class="form-label mb-1">FIRST NAME <span class="my-form-required">*</span></label>
                            <input name="firstName" type="text" class="form-control input-field <?php echo (!empty($firstName_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter first name" aria-label="Current Password" value="<?php echo $firstName ?>">
                            <div class="invalid-feedback">
                                <?php echo $firstName_err; ?>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label mb-1">LAST NAME <span class="my-form-required">*</span></label>
                            <input name="lastName" type="text" class="form-control input-field <?php echo (!empty($lastName_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter last name" aria-label="Last name" value="<?php echo $lastName ?>">
                            <div class="invalid-feedback">
                                <?php echo $lastName_err; ?>
                            </div>
                        </div>
                        <div class="mb-4 col-lg-6 mb-4">
                            <label class="form-label mb-1">EMAIL ADDRESS <span class="my-form-required">*</span></label>
                            <input name="email" type="email" class="form-control fs-6 input-field <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter email address" value="<?php echo $email ?>">
                            <div class="invalid-feedback">
                                <?php echo $email_err; ?>
                            </div>
                        </div>
                        <div class="mb-4 col-lg-6 mb-5">
                            <label class="form-label mb-1">PHONE NUMBER <span class="my-form-required">*</span></label>
                            <input name="mobile" type="text" class="form-control fs-6 input-field <?php echo (!empty($mobileNumber_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter mobile number" value="<?php echo $mobileNumber ?>">
                            <div class="invalid-feedback">
                                <?php echo $mobileNumber_err; ?>
                            </div>
                        </div>
                        <div>
                            <h5>Address</h5>
                        </div>
                        <div class="col-md-4 mb-4">
                            <label class="form-label mb-1">STREET <span class="my-form-required">*</span></label>
                            <input name="street" type="text" class="form-control input-field <?php echo (!empty($street_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter street" aria-label="Current Password" value="<?php echo $street ?>">
                            <div class="invalid-feedback">
                                <?php echo $street_err; ?>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <label class="form-label mb-1">CITY <span class="my-form-required">*</span></label>
                            <input name="city" type="text" class="form-control input-field <?php echo (!empty($city_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter city" aria-label="Current Password" value="<?php echo $city ?>">
                            <div class="invalid-feedback">
                                <?php echo $city_err; ?>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <label class="form-label mb-1">PROVINCE <span class="my-form-required">*</span></label>
                            <input name="province" type="text" class="form-control input-field <?php echo (!empty($province_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter province" aria-label="Current Password" value="<?php echo $province ?>">
                            <div class="invalid-feedback">
                                <?php echo $province_err; ?>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <label class="form-label mb-1">COUNTRY <span class="my-form-required">*</span></label>
                            <input name="country" type="text" class="form-control input-field <?php echo (!empty($country_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter country" aria-label="Current Password" value="<?php echo $country ?>">
                            <div class="invalid-feedback">
                                <?php echo $country_err; ?>
                            </div>
                        </div>
                        <div class="col-md-4 mb-5">
                            <label class="form-label mb-1">ZIP CODE</label>
                            <input name="zipCode" type="text" class="form-control input-field" placeholder="Enter zip code" aria-label="Current Password" value="<?php echo $zipCode ?>">
                        </div>
                    </form>
                    <div class="row">
                        <div class="mb-3 col-xxl-2">
                            <button data-bs-toggle="modal" data-bs-target="#addCustomerModal" type="submit" class="btn btn-lg fs-6 w-100 my-button-yes">Add Customer</button>
                        </div>
                        <div class="mb-0 col-xxl-2">
                            <a href="./customer_page.php" name="discardChanges" class="btn btn-lg fs-6 w-100 my-button-no">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script src="./js/script.js"></script>
</body>

</html>

<div class="modal fade" id="addCustomerModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="addCustomerModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="width: 500px;">
        <div class="modal-content shadow p-3 mb-5 bg-white rounded border">
            <div class="modal-header">
                <h1 class="modal-title" style="font-size: 20px;" id="exampleModalLabel">Confirm add customer?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Customer will be added.
            </div>
            <div class="modal-footer">
                <button name="addEmployee" form="addCustomerForm" class="btn my-button-yes">Confirm</button>
                <button type="button" class="btn my-button-no" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
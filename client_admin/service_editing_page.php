<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}

require_once "php/service_editing.php";

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
    <link rel="stylesheet" href="./css/service_page_styles.css" />
    <link rel="stylesheet" href="./css/colorPick.css" />


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
                    <a href="dashboard.php" class="sidebar-link">
                        <i class="bi bi-house"></i>
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
                    <a href="./services_page.php" class="sidebar-link selected">
                        <i class="bi bi-file-post"></i>
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
        <section class="main" id="main">
            <div class="container-fluid" id="serviceArea">
                <div class="mb-5">
                    <h1>Services</h1>
                </div>
                <div class="container-fluid" id="addServiceArea">
                    <div class="container">
                        <div>
                            <h5>Edit Service</h5>
                        </div>
                        <form id="addServiceForm" class="row mb-5" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" novalidate>
                        <input type="hidden" name="serviceId" value="<?= htmlspecialchars($service_id) ?>">
                            <div class="col-md-6 mb-4">
                                <label class="form-label mb-1">SERVICE TITLE</label>
                                <input name="serviceTitle" type="text" class="form-control input-field <?php echo (!empty($serviceTitle_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter your service title" aria-label="Current Password" value="<?php echo $serviceTitle ?>">
                                <div class=" invalid-feedback">
                                    <?php echo $serviceTitle_err; ?>
                                </div>
                            </div>
                            <div class="col-6 mb-4">
                                <label class="form-label mb-1">COLOR TAG</label>
                                <div class="picker rounded" style="height: 39px; width: 44px;"></div>
                            </div>
                            <div class="col-xl-12 mb-4">
                                <label class="form-label mb-1">DESCRIPTION</label>
                                <textarea name="description" type="text" rows="3" class="form-control input-field" placeholder="Enter service description"></textarea>
                            </div>
                            <div class="mb-4 col-lg-6 mb-4">
                                <label class="form-label mb-1">DURATION</label>
                                <div class="input-group <?php echo (!empty($duration_err)) ? 'is-invalid' : ''; ?>">
                                    <input name="duration" type="text" class="form-control fs-6 input-field " placeholder="Enter service duration" value="<?php echo $duration ?>">
                                    <span class="input-group-text">minutes</span>
                                </div>
                                <div class="invalid-feedback">
                                    <?php echo $duration_err; ?>
                                </div>
                            </div>
                            <div class="mb-4 col-lg-6 mb-4">
                                <label class="form-label mb-1">PRICE</label>
                                <div class="input-group <?php echo (!empty($price_err)) ? 'is-invalid' : ''; ?>">
                                    <span class="input-group-text">$</span>
                                    <input name="price" type="text" class="form-control fs-6 input-field" placeholder="Enter service price" value="<?php echo $price ?>">
                                    <span class="input-group-text">.00</span>
                                </div>
                                <div class="invalid-feedback">
                                    <?php echo $price_err; ?>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="mb-3 col-xxl-2">
                                <button name = "editService"data-bs-toggle="modal" data-bs-target="#addServiceModal" type="submit" class="btn btn-lg fs-6 w-100 add-service-button">Save Changes</button>
                            </div>
                            <div class="mb-0 col-xxl-2">
                                <a href="./services_page.php" name="discardChanges" class="btn btn-lg fs-6 w-100 cancel-button">cancel</a>
                            </div>
                            <div class="mb-0 col-xxl-2">
                            <button data-bs-toggle="modal" data-bs-target="#deleteEmployeeAccountModal" class="btn btn-lg fs-6 w-100 my-button-danger">Delete</button>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script>
            $(".picker").colorPick();
        </script>
        <script src="./js/script.js"></script>
        <script src="./js/colorPick.js"></script>
</body>

</html>

<div class="modal fade" id="addServiceModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="addServiceModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="width: 500px;">
        <div class="modal-content shadow p-3 mb-5 bg-white rounded border">
            <div class="modal-header">
                <h1 class="modal-title" style="font-size: 20px;" id="exampleModalLabel">Confirm add service?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Service will be added.
            </div>
            <div class="modal-footer">
                <button name="changePassword" form="addServiceForm" class="btn add-service-button">Confirm</button>
                <button type="button" class="btn cancel-button" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
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
                <button name="deleteAccount" form="addServiceForm" class="btn my-button-danger">Confirm</button>
                <button type="button" class="btn my-button-no" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
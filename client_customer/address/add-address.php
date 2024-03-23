<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}

require_once "../php_backend/address-adding.php";

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="../css/dashboard_styles.css" />
    <link rel="stylesheet" href="../css/address-styles.css">
    <link rel="stylesheet" href="../../components/_components.css">

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
                    <a href="../dashboard.php" class="sidebar-link ">
                        <i class="bi bi-house"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../request-appointment-service.php" class="sidebar-link">
                        <i class="bi bi-calendar2"></i>
                        <span>Appointments</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="./index.php" class="sidebar-link selected">
                        <i class="bi bi-geo-alt-fill"></i>
                        <span>Address</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../notification" class="sidebar-link">
                        <i class="bi bi-bell"></i>
                        <span>Notifications</span>
                    </a>
                </li>
                <li class="sidebar-footer">
                    <a href="../setting_account_page.php" class="sidebar-link ">
                        <i class="bi bi-gear"></i>
                        <span>Settings</span>
                    </a>
                </li>
            </ul>
            <div class="sidebar-footer">
                <a href="../php_backend/logout.php" class="sidebar-link">
                    <i class="bi bi-box-arrow-left"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>
        <section class="main" id="main">
            <div class="container-fluid" id="mainArea">
                <div class="mb-5">
                    <h1>Addresses</h1>
                </div>
                <div class="container-fluid" id="subArea-top">
                    <div class="col">
                        <h5><span><a href="./index.php" class="btn my-button-back"><i class="bi bi-chevron-left"></i></a></span> Add Address</h5>
                    </div>
                    <form id="addAddress" class="row mb-4" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" novalidate>
                        <input type="hidden" name="employeeId" value="<?= htmlspecialchars($employeeId) ?>">
                        <div class="col-md-6 mb-4">
                            <label class="form-label mb-1">STREET</label>
                            <input name="street" type="text" class="form-control input-field <?php echo (!empty($street_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter Street" aria-label="Current Password" value="<?php echo $street ?>">
                            <div class="invalid-feedback">
                                <?php echo $street_err; ?>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label mb-1">CITY / TOWN</label>
                            <input name="city" type="text" class="form-control input-field <?php echo (!empty($city_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter City" aria-label="Last name" value="<?php echo $city ?>">
                            <div class="invalid-feedback">
                                <?php echo $city_err; ?>
                            </div>
                        </div>
                        <div class="mb-4 col-lg-6 mb-4">
                            <label class="form-label mb-1">PROVINCE</label>
                            <input name="province" type="text" class="form-control fs-6 input-field <?php echo (!empty($province_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter Province" value="<?php echo $province ?>">
                            <div class="invalid-feedback">
                                <?php echo $province_err; ?>
                            </div>
                        </div>
                        <div class="mb-4 col-lg-6 mb-4">
                            <label class="form-label mb-1">ZIP CODE</label>
                            <input name="zipCode" type="text" class="form-control fs-6 input-field <?php echo (!empty($zipCode_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter Zipcode" value="<?php echo $zipCode ?>">
                            <div class="invalid-feedback">
                                <?php echo $zipCode_err; ?>
                            </div>
                        </div>
                        <div class="mb-4 col-lg-6 mb-4">
                            <label class="form-label mb-1">COUNTRY</label>
                            <input name="country" type="text" class="form-control fs-6 input-field <?php echo (!empty($country_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter Country" value="<?php echo $country ?>">
                            <div class="invalid-feedback">
                                <?php echo $country_err; ?>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="mb-3 col-xxl-2">
                            <button name="editAddress" data-bs-toggle="modal" data-bs-target="#editAddressModal" type="submit" class="btn btn-lg fs-6 w-100 my-button-yes">Add Address</button>

                        </div>
                        <div class="mb-3 col-xxl-2">
                            <a href="./index.php" name="discardChanges" class="btn btn-lg fs-6 w-100 my-button-no">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script src="../js/script.js"></script>
</body>

</html>

<div class="modal fade" id="editAddressModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="editAddressModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="width: 500px;">
        <div class="modal-content shadow p-3 mb-5 bg-white rounded border">
            <div class="modal-header">
                <h1 class="modal-title" style="font-size: 20px;" id="exampleModalLabel">Add Address?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                The address will be added.
            </div>
            <div class="modal-footer">
                <button name="updateInfo" form="addAddress" class="btn my-button-yes">Confirm</button>
                <button type="button" class="btn my-button-no" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
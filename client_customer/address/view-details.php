<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}

require_once "../php_backend/address-editing.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TwinPeaks</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- DataTables CDN -->

    <link href="https://cdn.datatables.net/v/bs5/dt-2.0.0/b-3.0.0/b-html5-3.0.0/r-3.0.0/sl-2.0.0/sr-1.4.0/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/v/bs5/dt-2.0.0/b-3.0.0/b-html5-3.0.0/r-3.0.0/sl-2.0.0/sr-1.4.0/datatables.min.js"></script>
    <!-- end -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="./js/colorPick.js"></script>

    <link rel="stylesheet" href="../css/dashboard_styles.css" />
    <link rel="stylesheet" href="../css/address-styles.css">
    <link rel="stylesheet" href="../../components/_components.css">

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
                    <a href="../address/" class="sidebar-link selected">
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
                <li class="sidebar-item">
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
        <section class="main p-2" id="main">
            <div class="container-fluid" id="mainArea">
                <div class="mb-5">
                    <h1>Addresses</h1>
                </div>
                <div class="container-fluid" id="subArea-top">
                    <h5><span><a href="./index.php" class="btn my-button-back"><i class="bi bi-chevron-left"></i></a></span> Address Details</h5>
                    <form id="editAddressForm" class="row mb-5" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" novalidate>
                        <input type="hidden" name="addressId" value="<?= htmlspecialchars($addressId) ?>">
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
                    <div class="mb-0 col-xxl-2">
                        <button id="showEdit" name="editAddress" type="submit" class="btn btn-lg fs-6 w-100 my-button-yes">Edit Address</button>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-xxl-2">
                            <button style="display: none;" id="editAddress" name="editAddress" data-bs-toggle="modal" data-bs-target="#editAddressModal" type="submit" class="btn btn-lg fs-6 w-100 my-button-yes">Save Changes</button>
                        </div>
                        <div class="mb-3 col-xxl-2">
                            <button style="display: none;" id="discardChanges" href="./index.php" name="discardChanges" class="btn btn-lg fs-6 w-100 my-button-no">Cancel</button>
                        </div>
                        <div class="mb-0 col-xxl-2 ms-auto">
                            <button style="display: none;" data-bs-toggle="modal" id="deleteAddress" data-bs-target="#deleteAddressModal" class="btn btn-lg fs-6 w-100 my-button-danger">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script src="../js/data-table-address.js"></script>
        <script src="../js/script.js"></script>

</body>

</html>

<div class="modal fade" id="editAddressModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="editAddressModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow p-3 mb-5 bg-white rounded border">
            <div class="modal-header">
                <h1 class="modal-title" style="font-size: 20px;" id="exampleModalLabel">Confirm Changes?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Changes Will be Saved.
            </div>
            <div class="modal-footer">
                <button name="updateInfo" form="editAddressForm" class="btn my-button-yes">Confirm</button>
                <button type="button" class="btn my-button-no" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- //? modal paras confirmation sa pag delete sa Address -->

<div class="modal fade" id="deleteAddressModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="deleteAddressModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" >
        <div class="modal-content shadow p-3 mb-5 bg-white rounded border">
            <div class="modal-header">
                <h1 class="modal-title" style="font-size: 20px;" id="exampleModalLabel">Confirm delete address?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                The address will be deleted.
            </div>
            <div class="modal-footer">
                <button name="deleteAddress" form="editAddressForm" class="btn my-button-danger">Confirm</button>
                <button type="button" class="btn my-button-no" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
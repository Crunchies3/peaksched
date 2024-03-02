<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}

require_once "./php_backend/appointment.php";

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

    <link rel="stylesheet" href="./css/dashboard_styles.css" />
    <link rel="stylesheet" href="./css/appointment-styles.css" />
    <link rel="stylesheet" href="../components/_components.css" />
    <link href="../select_box/dist/jquery-editable-select.min.css" rel="stylesheet">

</head>

<body>
    <div class="wrapper">
        <aside id="sidebar" class="shadow-lg">
            <div class="d-flex mb-2">
                <button id="toggle-btn" type="button">
                    <i class="bi bi-tree-fill"></i>
                </button>
                <div class="sidebar-logo">
                    <a href="#">TwinPeaks</a>
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="" class="sidebar-link ">
                        <i class="bi bi-house"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link selected">
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
                    <a href="setting_account_page.php" class="sidebar-link ">
                        <i class="bi bi-gear"></i>
                        <span>Settings</span>
                    </a>
                </li>
            </ul>
            <div class="sidebar-footer">
                <a href="php_backend/logout.php" class="sidebar-link">
                    <i class="bi bi-box-arrow-left"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>
        <div class="main" id="main">
            <div class="container-fluid" id="settingsArea">
                <div class="mb-4">
                    <h1>Appointments</h1>
                </div>
                <div class="mb-4">
                    <a href="#" class="btn my-button-selected mt-2">Request Appointment</a>
                    <a href="#" class="btn my-button-unselected mx-2 mt-2">Manage Appointments</a>
                </div>
                <div class="container-fluid" id="accountSettingArea">
                    <div class="mb-5">
                        <h5>Request Appointment</h5>
                    </div>
                    <div class="row">
                        <div class="col-lg-5">
                            <form id="updateAccountDetails" class="row" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" novalidate>
                                <div class="col-md-12 mb-4">
                                    <label class="form-label mb-1">SELECTED SERVICE</label>
                                    <input name="firstName" type="text" class="form-control input-field <?php echo (!empty($firstName_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter your first name" aria-label="Current Password" value="">
                                    <div class="invalid-feedback">
                                        <?php echo $firstName_err; ?>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-4">
                                    <label class="form-label mb-1">ADDRESS</label>
                                    <input name="firstName" type="text" class="form-control input-field <?php echo (!empty($firstName_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter your first name" aria-label="Current Password" value="">
                                    <div class="invalid-feedback">
                                        <?php echo $firstName_err; ?>
                                    </div>
                                </div>
                                <div class="container mx-3">
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label class="form-label mb-1">WHAT TYPE OF UNIT DO YOU HAVE? <span class="my-form-required">*</span></label>
                                            <div class="invalid-feedback">
                                                <?php echo $lastName_err; ?>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="numberOfFloors" id="numberOfFloors1" value="one">
                                                <label class="form-check-label" for="numberOfFloors1">
                                                    One floor unit
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="numberOfFloors" id="numberOfFloors2" value="two">
                                                <label class="form-check-label" for="numberOfFloors2">
                                                    Two floors unit
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="numberOfFloors" id="numberOfFloors3" value="three">
                                                <label class="form-check-label" for="numberOfFloors3">
                                                    Three floors unit
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="numberOfFloors" id="numberOfFloors4" value="other">
                                                <label class="form-check-label" for="numberOfFloors4">
                                                    Other
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <label class="form-label mb-1">HOW MANY BATHROOMS? <span class="my-form-required">*</span></label>
                                            <div class="invalid-feedback">
                                                <?php echo $lastName_err; ?>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="numberOfBathrooms" id="numberOfBathrooms1" value="one">
                                                <label class="form-check-label" for="numberOfBathrooms1">
                                                    One bath
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="numberOfBathrooms" id="numberOfBathrooms2" value="two">
                                                <label class="form-check-label" for="numberOfBathrooms2">
                                                    Two baths
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="numberOfBathrooms" id="numberOfBathrooms3" value="three">
                                                <label class="form-check-label" for="numberOfBathrooms3">
                                                    Three baths
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="numberOfBathrooms" id="numberOfBathrooms4" value="other">
                                                <label class="form-check-label" for="numberOfBathrooms4">
                                                    Other
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label class="form-label mb-1">HOW MANY BEDS? <span class="my-form-required">*</span></label>
                                            <div class="invalid-feedback">
                                                <?php echo $lastName_err; ?>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="numberOfBeds" id="numberOfBeds1" value="option1">
                                                <label class="form-check-label" for="numberOfBeds1">
                                                    One bed
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="numberOfBeds" id="numberOfBeds2" value="option2">
                                                <label class="form-check-label" for="numberOfBeds2">
                                                    Two beds
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="numberOfBeds" id="numberOfBeds3" value="option3">
                                                <label class="form-check-label" for="numberOfBeds3">
                                                    Three beds
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="numberOfBeds" id="numberOfBeds4" value="option4">
                                                <label class="form-check-label" for="numberOfBeds4">
                                                    Other
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <label class="form-label mb-1">HOW MANY BEDS? <span class="my-form-required">*</span></label>
                                            <div class="invalid-feedback">
                                                <?php echo $lastName_err; ?>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="numberOfBeds" id="numberOfBeds1" value="option1">
                                                <label class="form-check-label" for="numberOfBeds1">
                                                    One bed
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="numberOfBeds" id="numberOfBeds2" value="option2">
                                                <label class="form-check-label" for="numberOfBeds2">
                                                    Two beds
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="numberOfBeds" id="numberOfBeds3" value="option3">
                                                <label class="form-check-label" for="numberOfBeds3">
                                                    Three beds
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="numberOfBeds" id="numberOfBeds4" value="option4">
                                                <label class="form-check-label" for="numberOfBeds4">
                                                    Other
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>

                        <div class="container col-lg-4">
                            <div class=" d-flex justify-content-center">
                                <div id="calendar" class="col-lg-4"></div>
                            </div>


                            <script src="./js/vanilla-calendar.js"></script>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label mb-3">TIME</label>
                            <form id="updateAccountDetails" class="" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" novalidate>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="numberOfFloors" id="numberOfFloors1" value="one">
                                    <label class="form-check-label" for="numberOfFloors1">
                                        8:00 AM
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="numberOfFloors" id="numberOfFloors2" value="two">
                                    <label class="form-check-label" for="numberOfFloors2">
                                        9:00 AM
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="numberOfFloors" id="numberOfFloors3" value="three">
                                    <label class="form-check-label" for="numberOfFloors3">
                                        10:00 AM
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="numberOfFloors" id="numberOfFloors4" value="other">
                                    <label class="form-check-label" for="numberOfFloors4">
                                        11:00 AM
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="numberOfFloors" id="numberOfFloors1" value="one">
                                    <label class="form-check-label" for="numberOfFloors1">
                                        12:00 PM
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="numberOfFloors" id="numberOfFloors2" value="two">
                                    <label class="form-check-label" for="numberOfFloors2">
                                        1:00 PM
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="numberOfFloors" id="numberOfFloors3" value="three">
                                    <label class="form-check-label" for="numberOfFloors3">
                                        2:00 PM
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="numberOfFloors" id="numberOfFloors4" value="other">
                                    <label class="form-check-label" for="numberOfFloors4">
                                        3:00 PM
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="numberOfFloors" id="numberOfFloors1" value="one">
                                    <label class="form-check-label" for="numberOfFloors1">
                                        4:00 PM
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="numberOfFloors" id="numberOfFloors2" value="two">
                                    <label class="form-check-label" for="numberOfFloors2">
                                        5:00 PM
                                    </label>
                                </div>
                            </form>

                        </div>

                    </div>
                </div>
            </div>

            <script src="./js/data-table-service.js"></script>
            <script src="./js/script.js"></script>
            <script src="../select_box/dist/jquery-editable-select.js"></script>
            <script src="../select_box/src/jquery-editable-select.js"></script>
            <script src="./js/select_box.js"></script>
</body>

</html>



<!-- Modal -->
<div class="modal" id="exampleModal" data-bs-backdrop="true" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="width: 400px;">
        <div class="modal-content shadow p-3 mb-5 bg-white rounded border">
            <div class="modal-header">
                <h5 class="modal-title" style="font-size: 16px;" id="exampleModalLabel">Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
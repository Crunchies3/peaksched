<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}

require_once "./php_backend/request-appointment-details.php";

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
                    <i class="bi bi-tree-fill"></i>
                </button>
                <div class="sidebar-logo">
                    <a href="#">TwinPeaks</a>
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="./index.php" class="sidebar-link ">
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
                    <a href="./address" class="sidebar-link">
                        <i class="bi bi-geo-alt"></i>
                        <span>Address</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
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
                <a href="php_backend/logout.php" class="sidebar-link">
                    <i class="bi bi-box-arrow-left"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>
        <div class="main p-2" id="main">
            <div class="container-fluid" id="mainArea">
                <div class="mb-4">
                    <h1>Appointments</h1>
                </div>
                <div class="row ">
                    <div class="mb-3 col-xxl-3">
                        <a href="./request-appointment-service.php" class="btn my-button-selected w-100">Request Appointment</a>
                    </div>
                    <div class="mb-4 col-xxl-3">
                        <a href="./manage-appointment.php" class="btn my-button-unselected w-100">Manage Appointments</a>
                    </div>
                </div>
                <div class="container-fluid" id="subArea-single">
                    <div class="mb-3">
                        <h5><span><a href="./request-appointment-service.php" class="btn my-button-back"><i class="bi bi-chevron-left"></i></a></span> Request Appointment </h5>
                    </div>
                    <form id="requestAppointmentDetails" class="row" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" novalidate>
                        <input type="hidden" name="serviceId" value="<?php echo $service_id ?>">
                        <div class="row remove-gutter" id="requestAppoint">
                            <div class="col-xxl-5 p-3">
                                <div class="col-md-12 mb-4">
                                    <label class="form-label mb-1">SELECTED SERVICE <span class="my-form-required">*</span></label>
                                    <input disabled name="firstName" type="text" class="form-control input-field" placeholder="Enter your first name" aria-label="Current Password" value="<?php echo $serviceName ?>">
                                </div>
                                <div class="col-md-12 mb-4">
                                    <label class="form-label mb-1 <?php echo (!empty($address_Err)) ? 'is-invalid' : ''; ?>">ADDRESS <span class="my-form-required">*</span></label>
                                    <div class="invalid-feedback">
                                        <?php echo $address_Err; ?>
                                    </div>
                                    <select required id="addressList" class="mt-2">
                                        <?php
                                        // LOOP TILL END OF DATA
                                        for ($i = 0; $i < count($address_list); $i++) {
                                        ?>
                                            <option><?php echo  $address_list[$i]['fullAddress']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="container mx-3">
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label class="form-label mb-1 <?php echo (!empty($typeOfUnit_err)) ? 'is-invalid' : ''; ?>">WHAT TYPE OF UNIT DO YOU HAVE? <span class="my-form-required">*</span></label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="numberOfFloors" id="numberOfFloors1" value="one" <?php if (isset($_POST['numberOfFloors']) && $_POST['numberOfFloors'] == 'one') echo 'checked'; ?>>
                                                <label class="form-check-label" for="numberOfFloors1">
                                                    One floor unit
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="numberOfFloors" id="numberOfFloors2" value="two" <?php if (isset($_POST['numberOfFloors']) && $_POST['numberOfFloors'] == 'two') echo 'checked'; ?>>
                                                <label class="form-check-label" for="numberOfFloors2">
                                                    Two floors unit
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="numberOfFloors" id="numberOfFloors3" value="three" <?php if (isset($_POST['numberOfFloors']) && $_POST['numberOfFloors'] == 'three') echo 'checked'; ?>>
                                                <label class="form-check-label" for="numberOfFloors3">
                                                    Three floors unit
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="numberOfFloors" id="numberOfFloors4" value="other" <?php if (isset($_POST['numberOfFloors']) && $_POST['numberOfFloors'] == 'other') echo 'checked'; ?>>
                                                <label class="form-check-label" for="numberOfFloors4">
                                                    Other
                                                </label>
                                            </div>
                                            <div class="invalid-feedback">
                                                <?php echo $typeOfUnit_err; ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <label class="form-label mb-1 <?php echo (!empty($numOfBath_err)) ? 'is-invalid' : ''; ?>">HOW MANY BATHROOMS? <span class="my-form-required">*</span></label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="numberOfBathrooms" id="numberOfBathrooms1" value="one" <?php if (isset($_POST['numberOfBathrooms']) && $_POST['numberOfBathrooms'] == 'one') echo 'checked'; ?>>
                                                <label class="form-check-label" for="numberOfBathrooms1">
                                                    One bath
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="numberOfBathrooms" id="numberOfBathrooms2" value="two" <?php if (isset($_POST['numberOfBathrooms']) && $_POST['numberOfBathrooms'] == 'two') echo 'checked'; ?>>
                                                <label class="form-check-label" for="numberOfBathrooms2">
                                                    Two baths
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="numberOfBathrooms" id="numberOfBathrooms3" value="three" <?php if (isset($_POST['numberOfBathrooms']) && $_POST['numberOfBathrooms'] == 'three') echo 'checked'; ?>>
                                                <label class="form-check-label" for="numberOfBathrooms3">
                                                    Three baths
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="numberOfBathrooms" id="numberOfBathrooms4" value="other" <?php if (isset($_POST['numberOfBathrooms']) && $_POST['numberOfBathrooms'] == 'other') echo 'checked'; ?>>
                                                <label class="form-check-label" for="numberOfBathrooms4">
                                                    Other
                                                </label>
                                            </div>
                                            <div class="invalid-feedback">
                                                <?php echo $numOfBath_err; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label class="form-label mb-1 <?php echo (!empty($numOfBeds_err)) ? 'is-invalid' : ''; ?>">HOW MANY BEDS? <span class="my-form-required">*</span></label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="numberOfBeds" id="numberOfBeds1" value="one" <?php if (isset($_POST['numberOfBeds']) && $_POST['numberOfBeds'] == 'one') echo 'checked'; ?>>
                                                <label class="form-check-label" for="numberOfBeds1">
                                                    One bed
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="numberOfBeds" id="numberOfBeds2" value="two" <?php if (isset($_POST['numberOfBeds']) && $_POST['numberOfBeds'] == 'two') echo 'checked'; ?>>
                                                <label class="form-check-label" for="numberOfBeds2">
                                                    Two beds
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="numberOfBeds" id="numberOfBeds3" value="three" <?php if (isset($_POST['numberOfBeds']) && $_POST['numberOfBeds'] == 'three') echo 'checked'; ?>>
                                                <label class="form-check-label" for="numberOfBeds3">
                                                    Three beds
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="numberOfBeds" id="numberOfBeds4" value="other" <?php if (isset($_POST['numberOfBeds']) && $_POST['numberOfBeds'] == 'other') echo 'checked'; ?>>
                                                <label class="form-check-label" for="numberOfBeds4">
                                                    Other
                                                </label>
                                            </div>
                                            <div class="invalid-feedback">
                                                <?php echo $numOfBeds_err; ?>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row col-xxl-7 dateTimeArea">
                                <div class="container col-lg-6 p-3">
                                    <label class="form-label mb-1 <?php echo (!empty($selectedDate_err)) ? 'is-invalid' : ''; ?>">DATE <span class="my-form-required">*</span></label>
                                    <div class="invalid-feedback">
                                        <?php echo $selectedDate_err; ?>
                                    </div>
                                    <div id="calendar" class="w-100 mb-2"></div>
                                    <script src="./js/vanilla-calendar.js"></script>
                                    <input hidden id="selectedDate" class="form-control input-field" name="selectedDate" value="">
                                    <label class="form-label mb-2">ANY SPECIAL INSTRUCTION OR COMMENTS</label>
                                    <textarea name="note" type="text" rows="3" class="form-control input-field w-100 selecServiceInput " placeholder=""></textarea>
                                </div>
                                <div class="col-lg-6 p-3">
                                    <label class="form-label mb-1 <?php echo (!empty($selectedTime_err)) ? 'is-invalid' : ''; ?>">TIME <span class="my-form-required">*</span></label>
                                    <div class="invalid-feedback">
                                        <?php echo $selectedTime_err; ?>
                                    </div>
                                    <div class="form-check mb-2 mt-4">
                                        <input type="radio" class="btn-check" name="options" id="option1" autocomplete="off" value="8:00 AM" <?php if (isset($_POST['options']) && $_POST['options'] == '8:00 AM') echo 'checked'; ?>>
                                        <label class="btn btn-outline-secondary w-100" for="option1">8:00 AM</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="radio" class="btn-check" name="options" id="option2" autocomplete="off" value="9:00 AM" <?php if (isset($_POST['options']) && $_POST['options'] == '9:00 AM') echo 'checked'; ?>>
                                        <label class="btn btn-outline-secondary w-100" for="option2">9:00 AM</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="radio" class="btn-check" name="options" id="option3" autocomplete="off" value="10:00 AM" <?php if (isset($_POST['options']) && $_POST['options'] == '10:00 AM') echo 'checked'; ?>>
                                        <label class="btn btn-outline-secondary w-100" for="option3">10:00 AM</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="radio" class="btn-check" name="options" id="option4" autocomplete="off" value="11:00 AM" <?php if (isset($_POST['options']) && $_POST['options'] == '11:00 AM') echo 'checked'; ?>>
                                        <label class="btn btn-outline-secondary w-100" for="option4">11:00 AM</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="radio" class="btn-check" name="options" id="option5" autocomplete="off" value="12:00 PM" <?php if (isset($_POST['options']) && $_POST['options'] == '12:00 PM') echo 'checked'; ?>>
                                        <label class="btn btn-outline-secondary w-100" for="option5">12:00 PM</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="radio" class="btn-check" name="options" id="option6" autocomplete="off" value="1:00 PM" <?php if (isset($_POST['options']) && $_POST['options'] == '1:00 PM') echo 'checked'; ?>>
                                        <label class="btn btn-outline-secondary w-100" for="option6">1:00 PM</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="radio" class="btn-check" name="options" id="option7" autocomplete="off" value="2:00 PM" <?php if (isset($_POST['options']) && $_POST['options'] == '2:00 PM') echo 'checked'; ?>>
                                        <label class="btn btn-outline-secondary w-100" for="option7">2:00 PM</label>
                                    </div>
                                    <div class="form-check mb-5">
                                        <input type="radio" class="btn-check" name="options" id="option8" autocomplete="off" value="3:00 PM" <?php if (isset($_POST['options']) && $_POST['options'] == '3:00 PM') echo 'checked'; ?>>
                                        <label class="btn btn-outline-secondary w-100" for="option8">3:00 PM</label>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="mb-2 col-md">
                            <a href="./request-appointment-service.php" class="btn my-button-no w-100">Back</a>
                        </div>
                        <div class="mb-2 col-md">
                            <button class="btn my-button-yes w-100" data-bs-toggle="modal" data-bs-target="#submitRequest">Request Appointment</button>
                        </div>
                    </div>

                </div>
            </div>

            <script src="./js/script.js"></script>
            <script src="../select_box/dist/jquery-editable-select.js"></script>
            <script src="../select_box/src/jquery-editable-select.js"></script>
            <script src="./js/select_box.js"></script>
</body>

</html>



<!-- Modal -->

<div class="modal fade" id="submitRequest" data-bs-backdrop="static" tabindex="-1" aria-labelledby="updateInfoModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" >
        <div class="modal-content shadow p-3 mb-5 bg-white rounded border">
            <div class="modal-header">
                <h1 class="modal-title" style="font-size: 20px;" id="exampleModalLabel">Confirm Request?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Your request will be submitted
            </div>
            <div class="modal-footer">
                <button name="submitRequest" form="requestAppointmentDetails" class="btn my-button-yes">Confirm</button>
                <button type="button" class="btn my-button-no" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
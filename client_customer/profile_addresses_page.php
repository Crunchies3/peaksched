<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}
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
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/bootstrap5@6.1.10/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="./css/dashboard_styles.css" />
    <link rel="stylesheet" href="./css/profile_page_styles.css" />


</head>

<body>
    <div class="wrapper">
        <aside id="sidebar" class="shadow-lg">
            <div class="d-flex">
                <button id="toggle-btn" type="button">
                    <i class="bi bi-apple"></i>
                </button>
                <div class="sidebar-logo">
                    <a href="#">TwinPeaks</a>
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="dashboard.php" class="sidebar-link">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="bi bi-calendar2"></i>
                        <span>Appointments</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="bi bi-gear"></i>
                        <span>Notification</span>
                    </a>
                </li>
                <li class="sidebar-footer">
                    <a href="profile_page.php" class="sidebar-link selected">
                        <i class="bi bi-person-circle"></i>
                        <span>Profile</span>
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
        <section class="main">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3">
                        <a class="choices mb-3 p-3 btn" href="./profile_account_page.php">
                            <h5>Account Setting</h5>
                            <small>Details about your Personal Information</small>
                        </a>
                        <a class="choices mb-3 p-3 btn" href="./profile_security_page.php">
                            <h5>Login & Security</h5>
                            <small>Details about your Security Information</small>
                        </a>
                        <a class="choices mb-3 p-3 btn selected-choice">
                            <h5>Addresses</h5>
                            <small>Details about your Addresses and Locations</small>
                        </a>
                    </div>
                    <div class="col-lg" id="contents">
                        <div class="container-fluid">
                            <div class="row p-3 rounded" style="background-color: #e5e5e5;">
                                <h1 class="mb-4">Your Profile</h1>
                                <div class="col-lg mb-4">
                                    <h5 class="mb-0">Cyril Charles Alvez</h5>
                                    <small>alvezcyrilcharles@outlook.com</small>
                                </div>
                                <h5 class="mb-4">Basic Information</h5>
                                <div class="col-lg">
                                    <form class="row g-4" method="post" novalidate>
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label">First Name</label>
                                            <input name="firstName" type="text" class="form-control input-field" placeholder="First name" aria-label="First name" value="Cyril Charles">
                                            <div class="invalid-feedback">
                                                <?php echo $firstName_err; ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label">Last Name</label>
                                            <input name="lastName" type="text" class="form-control input-field <?php echo (!empty($lastName_err)) ? 'is-invalid' : ''; ?>" placeholder="Last name" aria-label="Last name" value="Alvez">
                                            <div class="invalid-feedback">
                                                <?php echo $lastName_err; ?>
                                            </div>
                                        </div>
                                        <div class="mb-2 col-lg-6">
                                            <label class="form-label">Email Address</label>
                                            <input name="email" type="email" class="form-control fs-6 input-field <?php echo (!empty($emailAddress_err)) ? 'is-invalid' : ''; ?>" placeholder="Email Address" value="alvezcyrilcharles@outlook.com">
                                            <div class="invalid-feedback">
                                                <?php echo $emailAddress_err; ?>
                                            </div>
                                        </div>
                                        <div class="mb-2 col-lg-6">
                                            <label class="form-label">Mobile Number</label>
                                            <input name="mobile" type="text" class="form-control fs-6 input-field <?php echo (!empty($mobileNumber_err)) ? 'is-invalid' : ''; ?>" placeholder="Mobile Number" value="09550717073">
                                            <div class="invalid-feedback">
                                                <?php echo $mobileNumber_err; ?>
                                            </div>
                                        </div>
                                        <div class="mb-2 col-md-3">
                                            <button class="btn btn-lg w-100 fs-6" style="background-color: #124F6F; color: whitesmoke; font-weight: 600;">Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <script src="./js/script.js"></script>
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
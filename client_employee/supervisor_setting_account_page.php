<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}

require_once "php/settings_account.php";

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
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/bootstrap5@6.1.10/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="./css/dashboard_styles.css" />
    <link rel="stylesheet" href="./css/setting_page_styles.css" />


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
                    <a href="#" class="sidebar-link">
                        <i class="bi bi-bell"></i>
                        <span>Notifications</span>
                    </a>
                </li>
                <li class="sidebar-footer">
                    <a href="./supervisor_setting_account_page.php" class="sidebar-link selected">
                        <i class="bi bi-gear-fill"></i>
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
            <div class="container-fluid" id="settingsArea">
                <div class="mb-4">
                    <h1>Settings</h1>
                </div>
                <div class="container-fluid" id="accountSettingArea">
                    <div>
                        <h5>Account Settings</h5>
                    </div>
                    <form id="updateAccountDetails" class="row" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" novalidate>
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
                            <input name="mobile" type="email" class="form-control fs-6 input-field <?php echo (!empty($mobileNumber_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter your mobile number" value="<?php echo $mobileNumber ?>">
                            <div class="invalid-feedback">
                                <?php echo $mobileNumber_err; ?>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="mb-3 col-xxl-2">
                            <button data-bs-toggle="modal" data-bs-target="#updateInfoModal" class="btn btn-lg fs-6 w-100 save-changes-button">Save changes</button>
                        </div>
                        <div class="mb-0 col-xxl-2">
                            <a href="./supervisor_setting_account_page.php" name="discardChanges" class="btn btn-lg fs-6 w-100 discard-changes-button">Discard changes</a>
                        </div>
                    </div>
                </div>
                <div class="container-fluid" id="securitySettingArea">
                    <div>
                        <h5>Security</h5>
                    </div>
                    <form class="row" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="securityForm" novalidate>
                        <div class="col-lg-6 mb-4">
                            <label class="form-label mb-1">CURRENT PASSWORD</label>
                            <input name="currentPassword" type="password" class="form-control input-field <?php echo (!empty($currentPassword_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter your current password" aria-label="Current Password" value="<?php echo $currentPassword; ?>">
                            <div class="invalid-feedback">
                                <?php echo $currentPassword_err; ?>
                            </div>
                        </div>
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
                    <div class="row">
                        <div class="mb-0 col-xxl-2">
                            <button data-bs-toggle="modal" data-bs-target="#updatePasswordModal" type="submit" class="btn btn-lg fs-6 w-100 change-password-button">Change password</button>
                        </div>
                        <div class="mb-0 col-xxl-2">
                            <a href="./worker_setting_account_page.php" name="discardChanges" class="btn btn-lg fs-6 w-100 discard-changes-button">Discard changes</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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
                <button name="updateInfo" form="updateAccountDetails" class="btn save-changes-button">Confirm</button>
                <button type="button" class="btn discard-changes-button" data-bs-dismiss="modal">Cancel</button>
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
                <button name="changePassword" form="securityForm" class="btn save-changes-button">Confirm</button>
                <button type="button" class="btn discard-changes-button" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
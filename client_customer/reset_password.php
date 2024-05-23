<?php
session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    echo '<script type="text/javascript"> window.location="dashboard.php";</script>';
    exit;
}

require_once 'php_backend/reset_password.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/styles.css">
    <script src="https://kit.fontawesome.com/3a742f337b.js" crossorigin="anonymous"></script> <!-- MATA SA PASSWORd -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>TwinPeaks</title>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">

        <div class="row box-area shadow-lg">
            <div class="col-lg-6 d-flex justify-content-center align-items-center flex-column left-box">
                <div class="feature-image mb-3">
                    <img src="./images/twinpeaks.png" alt="Twin Peaks" style="width: 250px;" class="mt-4 mb-3">
                </div>
            </div>
            <div class="col-lg-6 right-box">
                <div class="row align-items-center">
                    <div class="header-text mt-5">
                        <h1 class="title">Enter a new password</h1>
                    </div>
                    <div class="header-text mb-4">
                        <small class="sub-title fs-7">Make sure it's a good one.</small>
                    </div>
                    <div class="alert alert-danger" role="alert" <?php echo $visibility ?>>
                        Invalid reset link. Request a new password again.
                    </div>
                    <form class="g-2" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>

                        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

                        <fieldset <?php echo $status ?>>
                            <div class="input-group col-12" id="show_hide_password">
                                <input name="password" type="password" class="form-control fs-6 input-field mb-2 <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" placeholder="Password" value="<?php echo $password; ?>">
                                <div class="input-group-text">
                                    <a href="#" id="togglePassword1" style="color: #124F6F;">
                                        <i class="fa-solid fa-eye-slash" aria-hidden="true"></i></a>
                                </div>
                                <div class="invalid-feedback">
                                    <?php echo $password_err; ?>
                                </div>
                            </div>
                            <div class="mb-3 password-reminder">
                                <small>Password must be atleast 8 characters long and include a mix of uppercase letters, lowercase letters, and numbers.</small>
                            </div>
                            <div class="mb-4 col-12">
                                <input name="confirmPassword" type="password" class="form-control fs-6 input-field <?php echo (!empty($confirmPassword_err)) ? 'is-invalid' : ''; ?>" placeholder="Confirm Password" value="<?php echo $confirmPassword; ?>">
                                <div class="invalid-feedback">
                                    <?php echo $confirmPassword_err; ?>
                                </div>
                            </div>
                            <div class="input-group mb-5">
                                <button class="btn btn-lg w-100 fs-6" style="background-color: #124F6F; color: whitesmoke; font-weight: 600;">Submit
                                </button>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        class PasswordToggle {
            constructor(containerID, toggleID) {
                this.container = document.getElementById(containerID);
                this.toggleID = toggleID;

                if (!this.container) {
                    console.error(`Container not found with ID: ${containerID}`);
                    return;
                }

                this.passwordInput = this.container.querySelector('input[type="password"]');
                this.eyeIcon = this.container.querySelector(`#${toggleID} i`);

                if (!this.passwordInput) {
                    console.error("Password input not found. Check HTML structure.");
                    return;
                }

                this.setupEventListeners();
            }

            setupEventListeners() {
                this.eyeIcon.addEventListener("click", () => this.toggleVisibility());
            }

            toggleVisibility() {
                if (this.passwordInput.type === "password") {
                    this.passwordInput.type = "text";
                    this.eyeIcon.classList.remove("fa-eye-slash");
                    this.eyeIcon.classList.add("fa-eye");
                } else {
                    this.passwordInput.type = "password";
                    this.eyeIcon.classList.remove("fa-eye");
                    this.eyeIcon.classList.add("fa-eye-slash");
                }
            }
        }

        // Initialize for each password input
        const passwordToggle1 = new PasswordToggle('show_hide_password', 'togglePassword1');
        const passwordToggle2 = new PasswordToggle('show_hide_confirm_password', 'togglePassword2');
    </script>
</body>

</html>
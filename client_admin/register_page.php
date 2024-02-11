<?php require_once './php/backend_register_page.php'; ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/register_page_styles.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!-- sa icons ni nald -->
    <script src="https://kit.fontawesome.com/3a742f337b.js" crossorigin="anonymous"></script>
    <title>PeakSched</title>
</head>

<body>

    <div class="left-section">
        <div class="background-white"></div>
    </div>
    <div class="right-section">
        <div class="background-blue"></div>
    </div>


    <div class="container d-flex justify-content-center align-items-center min-vh-100">

        <div class="row box-area shadow-lg">

            <div class="col-lg-6 d-flex justify-content-center align-items-center flex-column left-box">
                <div class="peak-sched">
                    <h1>#PeakSched</h1>
                </div>
            </div>

            <div class="col-lg-6 right-box">
                <div class="row align-items-center">
                    <div class="header-text mb-1">
                        <h1 class="title">Sign Up</h1>
                    </div>
                    <div class="header-text mb-3">
                        <small class="sub-title">Clean Home, Clear Mind: Get Started!</small>
                    </div>
                    <form class="row g-2" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>
                        <div class="col-md-6 mb-2">
                            <input name="firstName" type="text" class="form-control input-field <?php echo (!empty($firstName_err)) ? 'is-invalid' : ''; ?>" placeholder="First name" aria-label="First name" value="<?php echo $firstName; ?>">
                            <div class="invalid-feedback">
                                <?php echo $firstName_err; ?>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <input name="lastName" type="text" class="form-control input-field <?php echo (!empty($lastName_err)) ? 'is-invalid' : ''; ?>" placeholder="Last name" aria-label="Last name" value="<?php echo $lastName; ?>">
                            <div class="invalid-feedback">
                                <?php echo $lastName_err; ?>
                            </div>
                        </div>
                        <div class="mb-2 col-12">
                            <input name="email" type="email" class="form-control fs-6 input-field <?php echo (!empty($emailAddress_err)) ? 'is-invalid' : ''; ?>" placeholder="Email Adress" value="<?php echo $emailAddress; ?>">
                            <div class="invalid-feedback">
                                <?php echo $emailAddress_err; ?>
                            </div>
                        </div>
                        <div class="mb-2 col-12">
                            <input name="mobile" type="text" class="form-control fs-6 input-field <?php echo (!empty($mobileNumber_err)) ? 'is-invalid' : ''; ?>" placeholder="Mobile Number" value="<?php echo $mobileNumber; ?>">
                            <div class="invalid-feedback">
                                <?php echo $mobileNumber_err; ?>
                            </div>
                        </div>
                        <div class="input-group mb-2 col-12" id="show_hide_password">
                            <input name="password" type="password" class="form-control fs-6 input-field <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" placeholder="Password" value="<?php echo $password; ?>">
                            <div class="input-group-text">
                                <a href="#" id="togglePassword1" style="color: #124F6F;">
                                    <i class="fa-solid fa-eye-slash" aria-hidden="true"></i></a>
                            </div>
                            <div class="invalid-feedback">
                                <?php echo $password_err; ?>
                            </div>
                        </div>
                        <div class="mb-2 col-12">
                            <input name="confirmPassword" type="password" class="form-control fs-6 input-field <?php echo (!empty($confirmPassword_err)) ? 'is-invalid' : ''; ?>" placeholder="Confirm Password" value="<?php echo $confirmPassword; ?>">
                            <div class="invalid-feedback">
                                <?php echo $confirmPassword_err; ?>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <button type="submit" name="submit" class="btn btn-lg w-100 fs-6" style="background-color: #124F6F; color: whitesmoke; font-weight: 600;">Sign
                                Up</button>
                        </div>
                        <div style="text-align: center;">
                            <small class="signin-now">Already have an account? <a href="./index.php" style="text-decoration: none;">Sign In!</a></small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- only god knows how this works -->
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
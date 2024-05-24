<?php
session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    echo '<script type="text/javascript"> window.location="./request-appointment-service.php";</script>';
    exit;
}

require_once 'php_backend/create_account.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/3a742f337b.js" crossorigin="anonymous"></script>
    <title>TwinPeaks </title>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">

        <div class="row box-area shadow-lg">

            <div class="col-lg-6 d-flex justify-content-center align-items-center flex-column left-box">
                <div class="feature-image mb-3 ">
                    <img src="./images/twinpeaks.png" alt="Twin Peaks" class="mt-4 mb-3 logo">
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
                            <input name="email" type="email" class="form-control fs-6 input-field <?php echo (!empty($emailAddress_err)) ? 'is-invalid' : ''; ?>" placeholder="Email Address" value="<?php echo $emailAddress; ?>">
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
                        <div class="input-group col-12" id="show_hide_password">
                            <input name="password" type="password" class="form-control fs-6 input-field <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" placeholder="Password" value="<?php echo $password; ?>">
                            <div class="input-group-text">
                                <a href="#" id="togglePassword1" style="color: #124F6F;">
                                    <i class="fa-solid fa-eye-slash" aria-hidden="true"></i></a>
                            </div>
                            <div class="invalid-feedback">
                                <?php echo $password_err; ?>
                            </div>
                        </div>
                        <div class="mb-2 password-reminder">
                            <small>Password must be atleast 8 characters long and include a mix of uppercase letters, lowercase letters, and numbers.</small>
                        </div>
                        <div class="mb-2 col-12">
                            <input name="confirmPassword" type="password" class="form-control fs-6 input-field <?php echo (!empty($confirmPassword_err)) ? 'is-invalid' : ''; ?>" placeholder="Confirm Password" value="<?php echo $confirmPassword; ?>">
                            <div class="invalid-feedback">
                                <?php echo $confirmPassword_err; ?>
                            </div>
                        </div>
                        <div class="form-check mb-4">
                            <input name="checkBox" type="checkbox" id="formCheck" class="form-check-input chk-box <?php echo (!empty($checkBox_err)) ? 'is-invalid' : ''; ?>" <?php echo $checkbox; ?>>
                            <label class="lbl-chk terms-service">
                                <small>I agree to the <a href="#" data-bs-toggle="modal" data-bs-target="#termsOfService">terms of services</a> and <a href="#" data-bs-toggle="modal" data-bs-target="#privacyPolicyModal">privacy policy</a></small>
                            </label>
                            <div class="invalid-feedback">
                                <?php echo $checkBox_err; ?>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <button type="submit" name="submit" class="btn btn-lg w-100 fs-6" style="background-color: #124F6F; color: whitesmoke; font-weight: 600;">Sign
                                Up</button>
                        </div>
                        <div style="text-align: center;">
                            <small class="signin-now">Already have an account? <a href="./index.php" style="text-decoration: none;">Log In!</a></small>
                        </div>
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

<!-- modal -->

<div class="modal fade" id="privacyPolicyModal" tabindex="-1" aria-labelledby="privacyPolicyModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content shadow p-3 bg-white rounded border">
            <div class="modal-header">
                <h5 class="modal-title" style="font-weight: bold;" id="exampleModalLabel">Privacy Policy</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Privacy Policy

                We at Peaksched want you to understand the privacy and policy we adhere to. This policy
                outlines how we collect, use, communicate, and disclose personal information.<br>
                <br>
                Why we collect data and information?<br>
                <br>
                As necessary to fulfill our contract with you. This means providing the services
                laid out in our Terms of Services/Terms of Use.
                As necessary to comply with a legal obligation.<br>
                <br>
                What information we will collect?<br>
                <br>
                • Your activity and information you provide.
                • App, browser, and device information.
                We collect personal information for the purpose of providing professional cleaning services.
                Before collecting any data, we will clearly state the purpose.
                We only collect information necessary for our services and other compatible purposes.
                Therefore, personal data should be relevant, accurate, complete, and up-to-date.<br>
                <br>
                What data will be stored?<br>
                <br>
                We retain personal information only as long as necessary to fulfill our service obligations.
                Once the purpose is fulfilled, we securely dispose of or anonymize the data.<br>
                <br>
                What are the security measures for your information?<br>
                <br>
                We protect personal information using reasonable security safeguards. Safeguards include measures
                against loss, theft, unauthorized access, disclosure, copying, use, or modification.<br>
                <br>
                Lawful and Fair Collection<br>
                <br>
                We collect personal information through lawful and fair means. Consent is obtained where appropriate.
                Canadian Privacy Notice
                Canada has two federal privacy laws that we adhere to:<br>
                <br>
                The Privacy Act:<br>
                <br>
                Covers how the federal government handles personal information.
                The Personal Information Protection and Electronic Documents Act (PIPEDA):<br>
                <br>
                Covers how businesses handle personal information
                This notice applies to our processing of your information to support Peaksched and
                other products to the extent such processing is subject to Canadian Law.<br>
                <br>
                Confidentiality Agreement for Cleaners<br>
                <br>
                Our employees sign confidentiality agreements to protect company information.<br>
                <br>
                How will you know the policy has changes?<br>
                <br>
                We will notify you before we make material changes to this policy. You’ll have the opportunity to review the revised Policy before you choose to continue using our service.
                <br>
                Contact Us<br>
                <br>
                For any privacy-related inquiries, please reach out to us.
                Your trust is essential to us, and we are committed to maintaining the confidentiality of your personal information.



            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">I Understand</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="termsOfService" tabindex="-1" aria-labelledby="termsOfService" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content shadow p-3 bg-white rounded border">
            <div class="modal-header">
                <h5 class="modal-title" style="font-weight: bold;" id="exampleModalLabel">Terms of Services</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                TERMS: <br>
                <br>
                The terms of this agreement shall take place once the contractor and client
                have agreed on the services provided by the company. Services provided by Twin Peaks
                will include all and other various cleaning tasks set forth by the company and which
                by the parties may agree on.<br>
                <br>
                PERFORMANCE: <br>
                <br>
                The company agrees to provide services to the best of their abilities at
                all time. The client shall have the right to, at any point, perform an inspection
                of the suppliers work and detail any issues during, or after services.<br>
                <br>
                DURATION AND PRICING: <br>
                <br>
                Regular cleaning service Minimum of 3.5 hrs Flat Rate (1 or more person) or starting
                rate at $140 Canadian dollars tax not included. Detailed and move-out cleaning with a
                minimum 6 hrs Flat rate (1 or more person) or starting rate at $210 Canadian dollars
                tax not included. Moreover any extra hours consumed after the minimum starting rate an
                additional charge at $40 dollars per hour.<br>
                <br>
                PAYMENT: <br>
                <br>
                The Service Provider shall perform the above-listed services on an as-needed
                basis, and shall invoice the client as such. The Service Provider shall generate a
                complete invoice for all services rendered every after the job is finished. Client
                agrees to pay all invoices associated with this agreement after receiving invoice
                issued of receipt unless notice of fault or failure to perform allows for delayed payment.<br>
                <br>
                INDEMNIFICATION: <br>
                <br>
                Should circumstances of neglect, wrongdoing or failure to complete services
                standard, each party agrees to indemnify and hold harmless the other party and its
                respective affiliates, partners and employees. Each party then agrees to the
                appropriate monetary, and/or services reprimandation through Twin Peaks’ services
                by re-cleaning, and/or resolving through appropriate measures of satisfaction
                between both parties. Twin Peaks agrees to fully address and remedy such errors
                as soon as reasonably possible. The clients/customers must request a re-cleaning
                schedule as soon as possible. (Not more than 8 hours for re-cleaning) any
                re-cleaning request after 8 hours will be charge regularly at $40 per hour.<br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">I Understand</button>
            </div>
        </div>
    </div>
</div>
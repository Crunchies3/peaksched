<?php
require_once './php_backend/login_account.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>Login</title>
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
                <div class="feature-image mb-3">
                    <img src="./images/twin-peaks-logo.png" alt="Twin Peaks" style="width: 250px;" class="mt-4 mb-3">
                </div>
            </div>

            <div class="col-lg-6 right-box">
                <div class="row align-items-center">
                    <div class="header-text mt-5">
                        <h1 class="title">Welcome Back</h1>
                    </div>
                    <div class="header-text mb-4">
                        <small class="sub-title fs-7">The <span style="color: #124F6F; ">TwinPeaks</span> is excited to see you again!</small>
                    </div>
                    <form class="g-2" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>
                        <div class="input-group mb-3">
                            <input name="email" type="email" class="form-control input-field <?php echo (!empty($emailAddress_err) || !empty($login_err)) ? 'is-invalid' : ''; ?>" placeholder="Email Adress" value="<?php echo $emailAddress; ?>">
                            <div class="invalid-feedback">
                                <?php echo $emailAddress_err; ?>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input name="password" type="password" class="form-control input-field <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" placeholder="password" value="<?php echo $password; ?>">
                            <div class="invalid-feedback">
                                <?php echo $password_err; ?>
                            </div>
                        </div>
                        <div class="input-group mb-4 d-flex justify-content-between">
                            <div class="form-check">
                                <input type="checkbox" id="formCheck" class="form-check-input chk-box">
                                <label for="formCheck" class="form-check-label">
                                    <small>Remember Me</small>
                                </label>
                            </div>
                            <div class="forgot">
                                <small><a href="#" style="text-decoration: underlined; color: #124F6F; font-weight: bold;">Forgot
                                        Password?</a></small>
                            </div>
                        </div>
                        <div class="input-group mb-5">
                            <button class="btn btn-lg w-100 fs-6" style="background-color: #124F6F; color: whitesmoke; font-weight: 600;">Sign
                                In</button>
                        </div>
                        <!-- Tanawon kung sayon lang ba ang google login -->
                        <!-- <div class="input-group mb-5">
                        <button class="btn btn-lg btn-light w-100 fs-6 google"><img src="/assets/images/google.png"
                                alt="google" style="width: 20px;" class="me-2"><small>Sign in with
                                Google</small></button>
                            </div> -->
                        <div class="row" style="text-align: center;">
                            <small class="signin-now">Don't have an account? <a href="./register_page.php" style="text-decoration: none; color: #124F6F;">Sign
                                    Up!</a></small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
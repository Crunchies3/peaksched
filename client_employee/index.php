<?php
session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {

    if ($_SESSION["type"] == "supervisor") {
        header("location: dashboard_supervisor.php");
    } else {
        header("location: dashboard_worker.php");
    }

    exit;
}
require_once "./php/backend_login.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/login_page_styles.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/3a742f337b.js" crossorigin="anonymous"></script> <!-- MATA SA PASSWORd -->
    <title>Login</title>
</head>

<body>

    <div class="container d-flex justify-content-center align-items-center min-vh-100">

        <div class="row box-area shadow-lg">
            <div class="col-lg-6 d-flex justify-content-center align-items-center flex-column left-box">
                <div class="feature-image mb-3">
                    <img src="./images/twin-peaks-logo.png" alt="Twin Peaks" style="width: 250px;" class="mt-4 mb-3">
                </div>
            </div>

            <div class="col-md-6 right-box">
                <div class="row align-items-center">
                    <div class="header-text mt-5">
                        <h1 class="title">Log In</h1>
                    </div>
                    <div class="header-text mb-4">
                        <small class="sub-title fs-7">Log in to your employee account.</small>
                    </div>
                    <form class="g-2" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>
                        <div class="input-group mb-3">
                            <input name="email" type="email" class="form-control input-field <?php echo (!empty($emailAddress_err) || !empty($login_err)) ? 'is-invalid' : ''; ?>" placeholder="Email Address" value="<?php echo $emailAddress; ?>">
                            <div class="invalid-feedback">
                                <?php echo $emailAddress_err; ?>
                            </div>
                        </div>

                        <div class="input-group mb-2">
                            <div class="input-group mb-2" id="show_hide_password">
                                <input name="password" type="password" class="form-control input-field <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" placeholder="Password" value="<?php echo $password; ?>">
                                <div class="input-group-text">
                                    <a href="#" id="togglePassword"><i class="fa-solid fa-eye-slash" style="color: #124F6F;" aria-hidden="true"></i></a>
                                </div>
                                <div class="invalid-feedback">
                                    <?php echo $password_err; ?>
                                </div>
                            </div>
                        </div>

                        <div class="input-group mb-4 d-flex justify-content-end">
                            <div class="forgot">
                                <small class="forgot-password"><a href="./forgot_password_page.php" style="text-decoration: none; color: #124F6F; font-weight: bold;">Forgot
                                        Password?</a></small>
                            </div>
                        </div>
                        <div class="input-group mb-4">
                            <button class="btn btn-lg w-100 fs-6" style="background-color: #124F6F; color: whitesmoke; font-weight: 600;">Log
                                In</button>
                        </div>
                        <!-- Tanawon kung sayon lang ba ang google login -->
                        <!-- <div class="input-group mb-5">
                <button class="btn btn-lg btn-light w-100 fs-6 google"><img src="/assets/images/google.png"
                        alt="google" style="width: 20px;" class="me-2"><small>Sign in with
                        Google</small></button>
                    </div> -->
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- for hiding and showing password -->
    <!-- cy iseparate lang ni nga script sa lain nga file para mareuse patulon kayong pathing sakoa pag mag include ug laing file -->
    <script>
        const passwordInput = document.querySelector("#show_hide_password input[type='password']");
        const eyeIcon = document.querySelector("#show_hide_password i.fa-eye-slash");

        document.querySelector("#togglePassword").addEventListener("click", function() {
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            } else {
                passwordInput.type = "password";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            }
        });
    </script>
</body>

</html>
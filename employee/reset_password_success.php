<?php
session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: dashboard.php");
    exit;
}

?>

<!-- //TODO: Tarungon ang ui -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/login_page_styles.css">
    <script src="https://kit.fontawesome.com/3a742f337b.js" crossorigin="anonymous"></script> <!-- MATA SA PASSWORd -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
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
            <div class="col-lg-6 right-box">
                <div class="row align-items-center">
                    <div class="header-text mt-5">
                        <h1 class="title">Success!</h1>
                    </div>
                    <div class="header-text mb-5">
                        <small class="sub-title fs-6">Password Successfully Changed</small>
                    </div>
                    <div class="row" style="text-align: start;">
                        <small class="signin-now"><a href="./index.php" style="text-decoration: none; color: #124F6F;">
                                Please Login to your account again. </a></small>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>

</html>
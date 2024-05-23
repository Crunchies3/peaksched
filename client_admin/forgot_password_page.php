<?php
session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    echo '<script type="text/javascript"> window.location="dashboard.php";</script>';
    exit;
}

require_once 'php/forgot_password.php';
?>

<!-- //TODO: Butngan ug spinner after pag submit -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/register_page_styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/3a742f337b.js" crossorigin="anonymous"></script> <!-- MATA SA PASSWORd -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>PeakSched</title>
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
                        <h1 class="title">Forgot Password</h1>
                    </div>
                    <div class="header-text mb-4">
                        <small class="sub-title fs-7">Please enter your email address</small>
                    </div>
                    <div class="alert alert-success" role="alert" <?php echo $visibility ?>>
                        Email sent, please check your inbox.
                    </div>
                    <form class="g-2" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate id="emailForm">
                        <div class="input-group mb-4">
                            <input name="email" type="email" class="form-control input-field <?php echo (!empty($emailAddress_err)) ? 'is-invalid' : ''; ?>" placeholder="Email Address" value="<?php echo $emailAddress; ?>">
                            <div class="invalid-feedback">
                                <?php echo $emailAddress_err; ?>
                            </div>
                        </div>
                        <div class="input-group mb-5">
                            <button id="btnSubmit" class="btn btn-lg w-100 fs-6" style="background-color: #124F6F; color: whitesmoke; font-weight: 600;">Send
                            </button>
                        </div>
                        <div class="row" style="text-align: center;">
                            <small class="signin-now"> <a href="index.php" style="text-decoration: underlined; color: #124F6F;">Login with password</a></small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="js/form_loading_spinner.js"></script>

</body>

</html>
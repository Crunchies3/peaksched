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
    <div class="container d-flex justify-content-center align-items-center min-vh-100">

        <div class="row rounded-5 p-3 bg-white box-area">

            <div class="col-md-6 d-flex justify-content-center align-items-center flex-column left-box" style="background: #1B75BB;">
                <div class="feature-image mb-3">
                    <img src="./images/twin-peaks-logo.png" alt="Twin Peaks" style="width: 250px;">
                </div>
            </div>

            <div class="col-md-6 right-box">

                <div class="row align-items-center">
                    <div class="header-text mb-4">
                        <h1>Log In</h1>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control form-control-lg fs-6 input-field" placeholder="Email Adress">
                    </div>
                    <div class="input-group mb-2">
                        <input type="password" class="form-control form-control-lg fs-6 input-field" placeholder="password">
                    </div>
                    <div class="input-group mb-4 d-flex justify-content-between">
                        <div class="form-check">
                            <input type="checkbox" id="formCheck" class="form-check-input chk-box">
                            <label for="formCheck" class="form-check-label">
                                <small>Remember Me</small>
                            </label>
                        </div>
                        <div class="forgot">
                            <small><a href="#" style="text-decoration: none; color: #1B75BB;">Forgot
                                    Password?</a></small>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <button class="btn btn-lg w-100 fs-6" style="background-color: #1B75BB; color: whitesmoke; font-weight: 600;">Sign
                            In</button>
                    </div>

                    <!-- Tanawon kung sayon lang ba ang google login -->

                    <!-- <div class="input-group mb-5">
                        <button class="btn btn-lg btn-light w-100 fs-6 google"><img src="/assets/images/google.png"
                                alt="google" style="width: 20px;" class="me-2"><small>Sign in with
                                Google</small></button>
                    </div> -->
                    <div class="row" style="text-align: center;">
                        <small>Don't have an account? <a href="./register_page.php" style="text-decoration: none; color: #1B75BB;">Sign
                                Up!</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
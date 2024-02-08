<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>Create </title>
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
                        <h1>Create Account</h1>
                    </div>
                    <form class="row g-2" method="post">
                        <div class="col-md-6 mb-2">
                            <input type="text" class="form-control input-field" placeholder="First name" aria-label="First name">
                        </div>
                        <div class="col-md-6 mb-2">
                            <input type="text" class="form-control input-field" placeholder="Last name" aria-label="Last name">
                        </div>
                        <div class="mb-2 col-12">
                            <input type="email" class="form-control fs-6 input-field" placeholder="Email Adress">
                        </div>
                        <div class="mb-2 col-12">
                            <input type="text" class="form-control fs-6 input-field" placeholder="Mobile Number">
                        </div>
                        <div class="mb-2 col-12">
                            <input type="password" class="form-control fs-6 input-field" placeholder="Password">
                        </div>
                        <div class="form-check mb-4">
                            <input type="checkbox" id="formCheck" class="form-check-input chk-box">
                            <label class="lbl-chk">
                                <small>I agree to the <a href="#">terms of services</a> and <a href="#">privacy</a>
                                    policy
                                </small>
                            </label>
                        </div>
                        <div class="input-group mb-3">
                            <button type="submit" name="submit" class="btn btn-lg w-100 fs-6" style="background-color: #1B75BB; color: whitesmoke; font-weight: 600;">Sign
                                In</button>
                        </div>
                        <div style="text-align: center;">
                            <small>Already have an account? <a href="./index.php" style="text-decoration: none; color: #1B75BB;">Sign In!</a></small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
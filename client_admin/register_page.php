<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/register_page_styles.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
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

        <div class="row rounded-5 p-3 bg-white box-area">

            <div class="col-md-6 d-flex justify-content-center align-items-center flex-column left-box" style="background: white;">
            <h1>A <span style="color: #194257;">clean</span> start is a good start</h1>
                <div class="feature-image mb-3">
                    <img src="./images/twin-peaks-logo.png" alt="Twin Peaks" style="width: 250px;">
                </div>
            </div>

            <div class="col-md-6 right-box">
                <div class="row align-items-center">
                    <div class="header-text mb-4" style="text-align: center; font-weight: bold;">
                        <h1>Join Us</h1>
                        <p style="margin: 0;">Be part of <span style="color: #194257;">TWIN PEAKS</span> community</p>
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
                        <div class="mb-2 col-12">
                            <input type="confirm password" class="form-control fs-6 input-field" placeholder=" Confirm Password">
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
                            <button type="submit" name="submit" class="btn btn-lg w-100 fs-6" style="background-color: #194257; color: whitesmoke; font-weight: 600;">Sign
                                In</button>
                        </div>
                        <div style="text-align: center;">
                            <small>Already have an account? <a href="./index.php" style="text-decoration: none; color: #343A40;"><strong style="font-weight: bold;">Sign In!</strong></a></small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
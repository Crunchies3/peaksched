<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PeakSched</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/vanilla-calendar-pro/styles/index.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/vanilla-calendar-pro/index.js" defer></script>

    <script src="https://cdn.jsdelivr.net/npm/echarts@5.6.0/dist/echarts.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs"></script>



    <link rel="stylesheet" href="../css/dashboard_styles.css" />
    <link rel="stylesheet" href="../../components/_components.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="app-bar d-lg-none d-flex">
        <a href="#">
            <button id="burger-menu" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
                <i class="bi bi-list"></i>
            </button>
        </a>
        <span class="mx-3 sidebar-logo"><a href="#">TwinPeaks</a></span>
    </div>
    <div class="wrapper">
        <aside id="sidebar" tabindex="-1" class="shadow-lg offcanvas-lg offcanvas-start" data-bs-backdrop="true">
            <div class="d-flex mb-2">
                <button id="toggle-btn" type="button">
                    <i class="bi bi-calendar-week"></i>
                </button>
                <div class="sidebar-logo">
                    <a href="#">PeakSched</a>
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="../dashboard.php" class="sidebar-link ">
                        <i class="bi bi-house-fill"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="" class="sidebar-link selected">
                        <i class="bi bi-clipboard2-data-fill"></i>
                        <span>Data Analytics</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../appointments/index.php" class="sidebar-link">
                        <i class="bi bi-calendar2"></i>
                        <span>Appointments</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../employee_page.php" class="sidebar-link">
                        <i class="bi bi-person"></i>
                        <span>Employee</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../customer_page.php" class="sidebar-link">
                        <i class="bi bi-emoji-smile"></i>
                        <span>Customer</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../payroll/" class="sidebar-link ">
                        <i class="bi bi-wallet"></i>
                        <span>Payroll</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../services_page.php" class="sidebar-link">
                        <i class="bi bi-file-post-fill"></i>
                        <span>Services</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../reports/" class="sidebar-link">
                        <i class="bi bi-flag"></i>
                        <span>Reports</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../notifcation/" class="sidebar-link">
                        <i class="bi bi-bell"></i>
                        <span>Notifications</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../setting_account_page.php" class="sidebar-link ">
                        <i class="bi bi-gear"></i>
                        <span>Settings</span>
                    </a>
                </li>
            </ul>
            <div class="sidebar-footer">
                <a href="../php/logout.php" class="sidebar-link">
                    <i class="bi bi-box-arrow-left"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>
        <section class="main p-2" id="main">
            <div class="container-fluid" id="mainArea">
                <div class="mb-4">
                    <h1>Data Analytics</h1>
                    <p style="font-size: 14px;">Here's your analytic data</p>
                </div>
                <div class="row g-0 mb-3">
                    <div class="col-xl-5" style="padding-right: 15px;">
                        <div class="container-fluid" id="subArea-single">
                            <div class="row mb-4">
                                <p class="col fw-bold">Total Availed Services</p>
                                <div class="col-6">
                                    <div class="row g-2">
                                        <div class="col">
                                            <select class="form-select" id="mySelect">
                                                <option value="month" selected>Monthly</option>
                                                <option value="year">Yearly</option>
                                            </select>
                                        </div>
                                        <div class="col-7">
                                            <input type="text" id="input-calendar" class="form-control input-field"
                                                readonly>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-0 mb-3">
                                <div class="container-fluid col" style="margin-right: 15px;" id="service-card">
                                    <div class="col mb-2">Cleaning</div>
                                    <h1 id="clean-card" style="font-size: 30px;">
                                        <span style="color: grey;">...</span>
                                    </h1>
                                </div>
                                <div class="container-fluid col" id="service-card">
                                    <div class="col mb-2">Maintenance</div>
                                    <h1 id="maintain-card" style="font-size: 30px;">
                                        <span style="color: grey;">...</span>
                                    </h1>
                                </div>
                            </div>
                            <div class="container-fluid col" style="margin-right: 15px;" id="demand-card">
                                <p class="col" style="margin-bottom: 22px;">Demand per Service</p>
                                <div class="row ">
                                    <div class="mb-3 col-xxl-4">
                                        <div onclick="d_cleaning_service()" id="d-cleaning-service"
                                            class="btn btn-sm my-button-selected w-100">
                                            Cleaning Service</div>
                                    </div>
                                    <div class="mb-4 col-xxl-5">
                                        <div onclick="d_maintenance_service()" id="d-maintenance service"
                                            class="btn btn-sm my-button-unselected w-100">
                                            Maintenance Service</div>
                                    </div>
                                </div>
                                <div id="demand-per-service" class="container-fluid mb-2" style="height: 340px;">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="loading" style="height: 300px;">
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-7">
                        <div class="container-fluid" id="subArea-single">
                            <div class="row mb-4">
                                <p class="col fw-bold">Yearly Stats</p>
                                <div class="col-4">
                                    <div class="row g-2">
                                        <div class="col">
                                        </div>
                                        <div class="col-6">
                                            <input type="text" id="input-calendar-year" class="form-control input-field"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">Total Availed Services</div>
                            <div id="yearly_service" class="container-fluid mb-4" style="height: 254px;">
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="loading" style="height: 250px;">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-4">Demand per Service</div>
                                <div class="row col">
                                    <div class="mb-3 col-xxl">
                                        <div onclick="y_cleaning_service()" id="y-cleaning-service"
                                            class="btn btn-sm my-button-selected w-100">
                                            Cleaning Service</div>
                                    </div>
                                    <div class="mb-4 col-xxl">
                                        <div onclick="y_maintenance_service()" id="y-maintenance service"
                                            class="btn btn-sm my-button-unselected w-100">
                                            Maintenance Service</div>
                                    </div>
                                </div>
                            </div>
                            <div id="yearly_service-2" class="container-fluid" style="height: 254px;">
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="loading" style="height: 300px;">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <section class="container-fluid mb-4" id="subArea-single">
                    <div style="font-weight: bold;" class="mb-4">Demand Forecast</div>
                    <div class="row col">
                        <div class="mb-3 col-xxl">
                            <div onclick="service_check()" id="service_btn" class="btn btn-sm my-button-selected w-100">
                                Services</div>
                        </div>
                        <div class="mb-4 col-xxl">
                            <div onclick="cleaning_check()" id="cleaning_btn"
                                class="btn btn-sm my-button-unselected w-100">Cleaning Service</div>
                        </div>
                        <div class="mb-4 col-xxl">
                            <div onclick="maintain_check()" id="maintain_btn"
                                class="btn btn-sm my-button-unselected w-100">Maintenance Service
                            </div>
                        </div>
                    </div>

                    <div class="mb-2">Select a service <span style="color: red;">*</span></div>
                    <div id="my_form" class="mb-3">
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="row">
                                <div class="col-6">
                                    <input id="forecast_input" placeholder="Select a month and year"
                                        class="mb-4 form-control input-field" readonly></input>
                                </div>
                                <div class="col-6">
                                    <button id="forecast_button" class="btn-primary btn" onclick="forecast()"
                                        disabled>Forecast</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="forecast_chart" class="container-fluid d-flex justify-content-center align-content-center"
                        style="height: 300px;">
                        <div class="mt-5" style="color: grey;">Please select a
                            service or category to forecast demand. Your results
                            will appear once you make a selection!</div>
                    </div>



                </section>
            </div>
        </section>
        <script src="script.js"></script>
        <script src="demand.js"></script>
        <script src="prediction.js"></script>
        <script src="./tfjs_model/data.js"></script>
</body>

</html>
<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}

require_once "../php/run-payroll.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Employee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="../css/dashboard_styles.css" />
    <link rel="stylesheet" href="../css/payroll-styles.css" />
    <link rel="stylesheet" href="../../components/_components.css">
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
                    <a href="../dashboard.php" class="sidebar-link">
                        <i class="bi bi-house"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../appointments/" class="sidebar-link">
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
                    <a href="./" class="sidebar-link selected">
                        <i class="bi bi-wallet-fill"></i>
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
                <div class="mb-5">
                    <h1>Payroll</h1>
                </div>
                <div class="container-fluid" id="subArea-single">
                    <div>
                        <h5><span><a href="./" class="btn my-button-back mx-2"><i class="bi bi-chevron-left"></i></a></span>Run Payroll</h5>
                    </div>

                    <div <?php echo $doesPendingReportExist ? "" : 'hidden'; ?> class="alert alert-danger" role="alert">
                        <?php echo $pendingReportCount ?> pending report<?php echo $pendingReportCount > 1 ? 's' : '';  ?> waiting for approval!
                    </div>
                    <div <?php echo $doesPendingReportExist ? "hidden" : ""; ?> class="alert alert-success" role="alert">
                        No pending reports.
                    </div>

                    <form id="runPayrollForm" class="row" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" novalidate>
                        <div class="col-md-6 mb-4">
                            <label class="form-label mb-1">Start Date</label>
                            <input type="date" class="form-control input-field <?php echo (!empty($startDate_err)) ? 'is-invalid' : ''; ?>" name="startDate" id="startDate" value="<?php echo $startDate ?>">
                            <div class="invalid-feedback">
                                <?php echo $startDate_err; ?>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label mb-1">End Date</label>
                            <input type="date" class="form-control input-field <?php echo (!empty($endDateErr)) ? 'is-invalid' : ''; ?>" name="endDate" id="endDate" value="<?php echo $endDate ?>">
                            <div class="invalid-feedback">
                                <?php echo $endDateErr; ?>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label mb-1">Federal Tax percent</label>
                            <input type="text" class="form-control input-field <?php echo (!empty($fedTax_err)) ? 'is-invalid' : ''; ?>" name="fedTax" id="fedTax" value="<?php echo $federalTax ?>">
                            <div class="invalid-feedback">
                                <?php echo $fedTax_err; ?>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label mb-1">Pay Date</label>
                            <input type="date" class="form-control input-field <?php echo (!empty($paydate_err)) ? 'is-invalid' : ''; ?>" name="payDate" id="payDate" value="<?php echo $payDate ?>">
                            <div class="invalid-feedback">
                                <?php echo $paydate_err; ?>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="mb-3 col-xxl-2">
                            <button data-bs-toggle="modal" data-bs-target="#runPayrollModal" type="submit" class="btn btn-lg fs-6 w-100 my-button-yes">Run Payroll</button>
                        </div>
                        <div class="mb-0 col-xxl-2">
                            <a href="./index.php" name="cancel" class="btn btn-lg fs-6 w-100 my-button-no">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script src="../js/script.js"></script>
</body>

</html>


<div class="modal fade" id="runPayrollModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="runPayrollModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="width: 500px;">
        <div class="modal-content shadow p-3 mb-5 bg-white rounded border">
            <div class="modal-header">
                <h1 class="modal-title" style="font-size: 20px;" id="exampleModalLabel">Confirm run payroll?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Run payroll
            </div>
            <div class="modal-footer">
                <button name="runPayroll" form="runPayrollForm" class="btn my-button-yes">Confirm</button>
                <button type="button" class="btn my-button-no" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    echo '<script type="text/javascript"> window.location="../../index.php";</script>';
    exit;
}

require_once "../../php/view-report-details.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PeakSched</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- DataTables CDN -->

    <link href="https://cdn.datatables.net/v/bs5/dt-2.0.0/b-3.0.0/b-html5-3.0.0/r-3.0.0/sl-2.0.0/sr-1.4.0/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/v/bs5/dt-2.0.0/b-3.0.0/b-html5-3.0.0/r-3.0.0/sl-2.0.0/sr-1.4.0/datatables.min.js"></script>
    <!-- end -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="../../css/dashboard_styles.css" />
    <link rel="stylesheet" href="../../css/create-report-style.css">
    <link rel="stylesheet" href="../../../components/_components.css">
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
                    <a href="../">PeakSched</a>
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="../" class="sidebar-link">
                        <i class="bi bi-house"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="./" class="sidebar-link ">
                        <i class="bi bi-calendar2-fill"></i>
                        <span>Appointments</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../payroll/" class="sidebar-link ">
                        <i class="bi bi-wallet"></i>
                        <span>Payslips</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../reports/" class="sidebar-link selected">
                        <i class="bi bi-flag-fill"></i>
                        <span>Reports</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../notification/" class="sidebar-link">
                        <i class="bi bi-bell"></i>
                        <span>Notifications</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../settings/" class="sidebar-link ">
                        <i class="bi bi-gear"></i>
                        <span>Settings</span>
                    </a>
                </li>
            </ul>
            <div class="sidebar-footer">
                <a href="../../php/logout.php" class="sidebar-link">
                    <i class="bi bi-box-arrow-left"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>
        <section class="main p-2" id="main">
            <form id="reportDetails" class="" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" novalidate>
                <div class="container-fluid" id="mainArea">
                    <div class="mb-5">
                        <h1>Reports</h1>
                    </div>
                    <div class="container-fluid" id="subArea-top">
                        <div>
                            <h5><span><a href="./index.php" class="btn my-button-back"><i class="bi bi-chevron-left"></i></a></span>Report Details</h5>
                        </div>
                        <div class="row">
                            <input type="hidden" name="appointmentId" value="<?= htmlspecialchars($appointmentId) ?>" id="appointmentId">
                            <input type="hidden" name="reportId" value="<?= htmlspecialchars($reportId) ?>" id="reportId">
                            <div class="col-md-6 mb-4">
                                <label class="form-label mb-1">APPOINTMENT ID</label>
                                <input disabled name="firstName" type="text" class="form-control input-field <?php echo (!empty($firstName_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter your first name" aria-label="Current Password" value="<?php echo $appointmentId ?>">
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label mb-1">CUSTOMER NAME</label>
                                <input disabled name="lastName" type="text" class="form-control input-field" placeholder="Enter your last name" aria-label="Last name" value="<?php echo $fullname ?>">
                            </div>
                            <div class="mb-4 col-lg-6 mb-4">
                                <label class="form-label mb-1">SERVICE</label>
                                <input disabled name="email" type="email" class="form-control fs-6 input-field" placeholder="Enter your email address" value="<?php echo $title ?>">
                            </div>
                            <div class="mb-4 col-lg-6 mb-4">
                                <label class="form-label mb-1">DATE REPORTED</label>
                                <input disabled name="position" type="text" class="form-control fs-6 input-field" placeholder="Enter your position" value="<?php echo $dateOnly ?>">
                            </div>
                            <div class="mb-4 col-lg-6 mb-1">
                                <label class="form-label mb-1">TIME REPORTED</label>
                                <input disabled name="position" type="text" class="form-control fs-6 input-field" placeholder="Enter your position" value="<?php echo $timeOnly ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid" id="appointmentArea">
                    <div class="container-fluid" id="subArea-bottom">
                        <div>
                            <h5>Assigned workers</h5>
                        </div>
                        <input hidden class="form-control fs-6 input-field <?php echo (!empty($hourWorked_err)) ? 'is-invalid' : ''; ?>" placeholder="" value="<?php echo $minute ?>">
                        <div class="invalid-feedback mb-3">
                            <?php echo $hourWorked_err; ?>
                        </div>
                        <table id="myTable" class="table table-hover table-striped">
                            <!-- //!TODO: para mailisan ang color sa header -->
                            <thead id="tableHead">
                                <th style="color: grey; ">Fullname</th>
                                <th style="color: grey; width:70%">Hours Worked</th>
                            </thead>
                            <tbody>
                                <?php
                                $rowCount = 0;
                                // LOOP TILL END OF DATA
                                while ($rows = $result->fetch_assoc()) {
                                ?>
                                    <tr>
                                        <td hidden> <input name="id<?php echo $rowCount ?>" type="text" class="input-field form-control" value="<?php echo $rows['employeeid']; ?>"> </td>
                                        <td><?php echo $rows['fullname']; ?></td>
                                        <td>
                                            <div class="row">
                                                <div class="col-lg-3 mb-2">
                                                    <input id="hour<?php echo $rowCount ?>" name="hour<?php echo $rowCount ?>" placeholder="Hours" type="number" class="input-field form-control" value="<?php if (isset($workerHour[$rowCount])) echo $workerHour[$rowCount]; ?>">
                                                </div>
                                                <div class="col-lg-3">
                                                    <input id="minute<?php echo $rowCount ?>" name="minute<?php echo $rowCount ?>" placeholder="Minutes" type="number" class="input-field form-control" value="<?php if (isset($workerMinute[$rowCount])) echo $workerMinute[$rowCount]; ?>">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                    $rowCount++;
                                }
                                ?>
                            </tbody>
                        </table>
                        <label class="form-label mb-2" style="color: #124F6F;">COMMENTS/NOTES</label>
                        <textarea name="note" type="text" rows="3" class="form-control input-field w-100 selecServiceInput " placeholder=""><?php echo $notes ?></textarea>

                        <div class="mt-5">
                            <button type="button" name="submitReport" data-bs-toggle="modal" data-bs-target="#submitReportModal" class="col-xl-2 btn my-button-yes w-100">Update Report</button>
                        </div>
                    </div>
                </div>
            </form>
        </section>
        <!-- <script src="../../js/data-table-create-report.js"></script> -->
        <script src="../../js/script.js"></script>
</body>

</html>


<div class="modal fade" id="submitReportModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="submitReportModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow p-3 mb-5 bg-white rounded border">
            <div class="modal-header">
                <h1 class="modal-title" style="font-size: 20px;" id="exampleModalLabel">Update Report?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Your report will be updated.
            </div>
            <div class="modal-footer">
                <button name="submitReport" form="reportDetails" class="btn my-button-yes">Confirm</button>
                <button type="button" class="btn my-button-no" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
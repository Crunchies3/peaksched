<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}

require_once "../../php/create-report.php";
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

    <!-- DataTables CDN -->

    <link href="https://cdn.datatables.net/v/bs5/dt-2.0.0/b-3.0.0/b-html5-3.0.0/r-3.0.0/sl-2.0.0/sr-1.4.0/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/v/bs5/dt-2.0.0/b-3.0.0/b-html5-3.0.0/r-3.0.0/sl-2.0.0/sr-1.4.0/datatables.min.js"></script>
    <!-- end -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="../../css/dashboard_styles.css" />
    <link rel="stylesheet" href="../../css/assigned-app-view-sup-styles.css">
    <link rel="stylesheet" href="../../../components/_components.css">
</head>

<body>
    <div class="wrapper">
        <aside id="sidebar" class="shadow-lg">
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
                    <a href="../reports/" class="sidebar-link selected">
                        <i class="bi bi-file-earmark-binary-fill"></i>
                        <span>Reports</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="bi bi-bell"></i>
                        <span>Notifications</span>
                    </a>
                </li>
                <li class="sidebar-footer">
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
        <section class="main" id="main">
            <form id="reportDetails" class="" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" novalidate>
                <div class="container-fluid" id="mainArea">
                    <div class="mb-5">
                        <h1>Reports</h1>
                    </div>
                    <div class="container-fluid" id="subArea-top">
                        <div>
                            <h5>Create Report</h5>
                        </div>

                        <div class="row">
                            <input type="hidden" name="appointmentId" value="<?= htmlspecialchars($appointmentId) ?>" id="appointmentId">
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
                                <label class="form-label mb-1">DATE</label>
                                <input disabled name="position" type="text" class="form-control fs-6 input-field" placeholder="Enter your position" value="<?php echo $dateOnly ?>">
                            </div>
                            <div class="mb-4 col-lg-6 mb-1">
                                <label class="form-label mb-1">TIME</label>
                                <input disabled name="position" type="text" class="form-control fs-6 input-field" placeholder="Enter your position" value="<?php echo $timeOnly ?>">
                            </div>
                            <div class="mb-4 col-lg-6 row mb-1">
                                <label class="form-label mb-2">HOURS WORKED <span class="my-form-required">*</span></label>
                                <div class="col-lg-3 mb-3">
                                    <input name="hour" type="number" class="form-control fs-6 input-field <?php echo (!empty($hour_err)) ? 'is-invalid' : ''; ?>" placeholder="Hours" value="<?php echo $hour ?>">
                                    <div class="invalid-feedback">
                                        <?php echo $hour_err; ?>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <input name="minute" type="number" class="form-control fs-6 input-field <?php echo (!empty($minute_err)) ? 'is-invalid' : ''; ?>" placeholder="Minutes" value="<?php echo $minute ?>">
                                    <div class="invalid-feedback">
                                        <?php echo $minute_err; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid" id="appointmentArea">
                    <div class="container-fluid" id="subArea-bottom">
                        <div>
                            <h5>Assigned workers</h5>
                        </div>
                        <table id="myTable" class="table table-hover table-striped">
                            <!-- //!TODO: para mailisan ang color sa header -->
                            <thead id="tableHead">
                                <th style="color: white;">Id</th>
                                <th style="color: white;">Fullname</th>
                                <th style="color: white;">Email</th>
                                <th style="color: white;">Phone</th>
                            </thead>
                            <tbody>
                                <?php
                                // LOOP TILL END OF DATA
                                while ($rows = $result->fetch_assoc()) {
                                ?>
                                    <tr>
                                        <td><?php echo $rows['employeeid']; ?></td>
                                        <td><?php echo $rows['fullname']; ?></td>
                                        <td><?php echo $rows['email']; ?></td>
                                        <td><?php echo $rows['mobilenumber']; ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        <div>
                            <button name="submitReport" form="reportDetails" <?php echo "" ?> class="btn btn-success mt-5 w-100">Submit Report</button>
                        </div>
                    </div>
                </div>
            </form>
        </section>
        <!-- <script src="../../js/data-table-create-report.js"></script> -->
        <script src="../../js/script.js"></script>
</body>

</html>
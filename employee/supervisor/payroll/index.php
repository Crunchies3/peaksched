<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    echo '<script type="text/javascript"> window.location="../../index.php";</script>';
    exit;
}

require_once "../../php/payslip-page.php";

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
    <link rel="stylesheet" href="../../css/payroll-styles.css" />
    <link rel="stylesheet" href="../../../components/_components.css">
</head>

<body>
    <div class="app-bar d-lg-none d-flex">
        <a href="#">
            <button id="burger-menu" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
                <i class="bi bi-list"></i>
            </button>
        </a>
        <span class="mx-3 sidebar-logo"><a href="#">PeakSched</a></span>
    </div>
    <div class="wrapper">
        <aside id="sidebar" tabindex="-1" class="shadow-lg offcanvas-lg offcanvas-start" data-bs-backdrop="true">
            <div class="d-flex mb-2">
                <button id="toggle-btn" type="button">
                    <i class="bi bi-calendar-week"></i>
                </button>
                <div class="sidebar-logo">
                    <a href="../appointment/">PeakSched</a>
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="../appointment/" class="sidebar-link">
                        <i class="bi bi-calendar2"></i>
                        <span>Appointments</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="./" class="sidebar-link selected">
                        <i class="bi bi-wallet-fill"></i>
                        <span>Payslips</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../reports/" class="sidebar-link">
                        <i class="bi bi-flag"></i>
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
            <div class="container-fluid" id="mainArea">
                <div class="mb-5">
                    <h1>Payslips</h1>
                </div>
                <div class="container-fluid" id="subArea-single">
                    <div>
                        <h5>All Payslips</h5>
                    </div>
                    <table id="myTable" class="table table-hover table-striped">
                        <!-- //!TODO: para mailisan ang color sa header -->
                        <thead id="tableHead">
                            <th style="color: white;">Payslip ID</th>
                            <th style="color: white;">Pay Period</th>
                            <th style="color: white;">Pay Rate</th>
                            <th style="color: white;">Hours Worked</th>
                            <th style="color: white;">Gross Pay</th>
                            <th style="color: white;">Deductions</th>
                            <th style="color: white;">Total</th>
                            <th style="color: white;">Actions</th>
                        </thead>
                        <tbody>
                            <?php
                            // LOOP TILL END OF DATA
                            while ($rows = $result->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td><?php echo $rows['payslip_id']; ?></td>
                                    <td><?php echo $rows['start_date'] . ' - '; ?> <?php echo $rows['end_date']; ?></td>
                                    <td><?php echo $rows['pay_rate']; ?></td>
                                    <td><?php echo round($rows['hours_worked'], 2) . ' hours'; ?></td>
                                    <td class="my-text-yes"><?php echo '$' . round($rows['gross_pay'], 2); ?></td>
                                    <td class="my-text-no"><?php echo '$' . round($rows['deductions'], 2); ?></td>
                                    <td class="my-text-yes"><?php echo '$' . round($rows['net_pay'], 2); ?></td>
                                    <td></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <script src="../../js/data-table-worker-payroll.js"></script>
        <script src="../../js/script.js"></script>
</body>

</html>
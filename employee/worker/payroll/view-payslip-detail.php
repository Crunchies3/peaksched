<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    echo '<script type="text/javascript"> window.location="../../index.php";</script>';
    exit;
}
require_once "../../php/payslip_view_detail.php";
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


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="../../css/dashboard_styles.css" />
    <link rel="stylesheet" href="../../css/view-payslip-styles.css" />
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
                    <i class="bi bi-tree-fill"></i>
                </button>
                <div class="sidebar-logo">
                    <a href="#">PeakSched</a>
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="../" class="sidebar-link ">
                        <i class="bi bi-house"></i>
                        <span>Home</span>
                    </a>
                </li>
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
                <div class="col mb-5">
                    <h1>Payroll</h1>
                </div>
                <div class="container-fluid" id="subArea-top">
                    <div class="row justify-content-between">
                        <h5><span><a href="./" class="btn my-button-back"><i class="bi bi-chevron-left"></i></a></span>
                            Payslip Details
                        </h5>
                    </div>
                    <!-- content -->
                    <div class="container-fluid" id="payslipDetails">
                        <div class="row justify-content-between">
                            <div class="col-6" id="adjustableRow">
                                <div class="mb-2 row">
                                    <div class="my-label col-4">
                                        Payslip ID:
                                    </div>
                                    <div class="my-label-emphasize col">
                                        <?php echo $payslipId ?>
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <div class="my-label col-4">
                                        Name:
                                    </div>
                                    <div class="my-label-emphasize col">
                                        <?php echo $firstname . ' ' ?><?php echo $lastname ?>
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <div class="my-label col-4">
                                        Type:
                                    </div>
                                    <div class="my-label-emphasize col">
                                        <?php echo $type ?>
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <div class="my-label col-4">
                                        Pay Period:
                                    </div>
                                    <div class="my-label-emphasize col">
                                        <?php echo $wordedStartDate ?> to <?php echo $wordedendDate ?>
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <div class="my-label col-4">
                                        Pay Date:
                                    </div>
                                    <div class="my-label-emphasize col">
                                        <?php echo $wordedpayDate ?>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div class="my-label col-4">
                                        Rate:
                                    </div>
                                    <div class="my-label-emphasize col">
                                        <?php echo '$' . $payrate . '/hr' ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col d-flex justify-content-center align-items-center">
                                <div class="p-2">
                                    <div class="rectangle">
                                        <div class="d-flex justify-content-between">
                                            <div class="p-3">
                                                <span class="my-label">NET PAY:</span>
                                            </div>
                                            <div class="p-3">
                                                <span class="my-label-emphasize" style="font-weight: bold;"> <?php echo '$' . round($netPay, 2) ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid" id="middle-area">
                <div class="container-fluid" id="tablelistTableArea">
                    <div>
                        <table>
                            <tr>
                                <th>Earnings</th>
                                <th>Hour</th>
                                <th>Rate</th>
                                <th>amount</th>
                            </tr>
                            <tr>
                                <td>Standard pay</td>
                                <td><?php echo round($hoursworked, 2) . ' hours' ?></td>
                                <td><?php echo '$' . $payrate . '/hr' ?></td>
                                <td><?php echo '$' . round($grosspay, 2) ?></td>
                            </tr>
                            <tr>
                                <td colspan="4">Gross pay: <?php echo '$' . round($grosspay, 2) ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="container-fluid" id="middle-area">
                <div class="container-fluid" id="subArea-bottom">
                    <div class="">
                        <table>
                            <tr>
                                <th>Deductions</th>
                                <th>Current</th>
                            </tr>
                            <tr>
                                <td>Federal Tax </td>
                                <td><?php echo $federaltax . '% = ' ?> <?php echo '$' . round($deductions, 2) ?></td>
                            </tr>
                            <tr>
                                <td colspan="2">Total deduction: <?php echo '$' . round($deductions, 2) ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        <script src="../js/payslip_screensize.js"></script>
        <script src="../js/script.js"></script>
</body>

</html>
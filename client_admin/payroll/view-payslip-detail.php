<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}
require_once "../php/payslip_view_detail.php";
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
    <link rel="stylesheet" href="../css/view-payslip-styles.css" />
    <link rel="stylesheet" href="../../components/_components.css">
</head>

<body>
    <div class="wrapper">
        <aside id="sidebar" class="shadow-lg">
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
                <li class="sidebar-footer">
                    <a href="../setting_account_page.php" class="sidebar-link ">
                        <i class="bi bi-gear"></i>
                        <span>Settings</span>
                    </a>
                </li>
            </ul>
            <div class="sidebar-footer">
                <a href="php/logout.php" class="sidebar-link">
                    <i class="bi bi-box-arrow-left"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>
        <section class="main" id="main">
            <div class="container-fluid" id="mainArea">
                <div class="mb-5">
                    <h1>Payslip</h1>
                </div>
                <div class="container-fluid" id="subArea-top">
                    <div class="row justify-content-between">
                        <div class="col-xxl-10 mb-3 ">
                            <h5>Payslip for the week of <?php echo $month ?> </h5>
                        </div>
                        <div class="col xxl-10 mb-3">
                            <h5>Payslip #: <?php echo $payslipId ?></h5>
                        </div>
                    </div>
                    <div>
                        <div class="my-subTitle">Employee pay summary</div>
                    </div>
                    <!-- content -->
                    <div class="container-fluid" id="payslipDetails">
                        <div class="row justify-content-between">
                            <div class="col-3">
                                <div class="mb-1 row">
                                    <div class="my-label col-4">
                                        Name:
                                    </div>
                                    <div class="my-label col">
                                    <?php echo $firstname .' '?><?php echo $lastname?>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="my-label col-4">
                                        Type:
                                    </div>
                                    <div class="my-label col">
                                    <?php echo $type?>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="my-label col-4">
                                        Pay Period:
                                    </div>
                                    <div class="my-label col">
                                        <?php echo $wordedStartDate ?> to <?php echo $wordedendDate ?>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="my-label col-4">
                                        Pay Date:
                                    </div>
                                    <div class="my-label col">
                                        <?php echo $wordedpayDate?>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div class="my-label col-4">
                                        Rate:
                                    </div>
                                    <div class="my-label col">
                                        <?php echo '$'.$payrate. '/hr'?>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="my-label-2 col-4">
                                        Netpay:
                                    </div>
                                    <div class="my-label-2 col">
                                    <?php echo '$'.round($netPay,2)?>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="my-label-2 col-4">
                                        Total hours:
                                    </div>
                                    <div class="my-label-2 col">
                                        <?php echo round($hoursworked,2) . ' hours'?>
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
                                <td><?php echo round($hoursworked,2) . ' hours'?></td>
                                <td><?php echo '$'.$payrate. '/hr'?></td>
                                <td><?php echo '$'.round($grosspay,2)?></td>
                            </tr>
                            <tr>
                                <td colspan="4">Gross pay: <?php echo '$'.round($grosspay,2)?></td>
                            </tr>
                        </table>
                    </div>

                </div>

            </div>
            <div class="container-fluid" id="middle-area">
                <div class="container-fluid" id="subArea-bottom">
                    <div>
                        <table>
                            <tr>
                                <th>Deductions</th>
                                <th>Current</th>
                            </tr>
                            <tr>
                                <td>Federal Tax </td>
                                <td><?php echo $federaltax. '% = '?> <?php echo '$'.round($deductions,2)?></td>
                            </tr>
                            <tr>
                                <td colspan="2">Total deduction: <?php echo '$'.round($deductions,2)?></td>
                            </tr>
                        </table>
                    </div>

                </div>

            </div>

        </section>
        <script src="../js/script.js"></script>
</body>

</html>
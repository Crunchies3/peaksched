<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}

require_once "php/profile_account.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- DataTables CDN -->

    <link href="https://cdn.datatables.net/v/bs5/dt-2.0.0/b-3.0.0/b-html5-3.0.0/r-3.0.0/sl-2.0.0/sr-1.4.0/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/v/bs5/dt-2.0.0/b-3.0.0/b-html5-3.0.0/r-3.0.0/sl-2.0.0/sr-1.4.0/datatables.min.js"></script>
    <!-- end -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="./css/dashboard_styles.css" />
    <link rel="stylesheet" href="./css/service_page_styles.css" />


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
                    <a href="dashboard.php" class="sidebar-link">
                        <i class="bi bi-house"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="bi bi-calendar2"></i>
                        <span>Appointments</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="./services_page.php" class="sidebar-link selected">
                        <i class="bi bi-file-post-fill"></i>
                        <span>Services</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="bi bi-bell"></i>
                        <span>Notifications</span>
                    </a>
                </li>
                <li class="sidebar-footer">
                    <a href="./setting_account_page.php" class="sidebar-link">
                        <i class="bi bi-gear-fill"></i>
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
            <div class="container-fluid" id="serviceArea">
                <div class="mb-4">
                    <h1>Services</h1>
                </div>
                <div class="container-fluid" id="servicesTableArea">
                    <table id="myTable" class="table table-hover table-borderless">
                        <!-- //!TODO: para mailisan ang color sa header -->
                        <thead style="background-color: black !important;">
                            <th style="color: white;">Description</th>
                            <th style="color: white;">Actions</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Regular Cleaning</td>
                                <td>...</td>
                            </tr>
                            <tr>
                                <td>Detailed Cleaning</td>
                                <td>...</td>
                            </tr>
                            <tr>
                                <td>Move-out Cleaning</td>
                                <td>...</td>
                            </tr>
                            <tr>
                                <td>Air Bnb Cleaning</td>
                                <td>...</td>
                            </tr>
                            <tr>
                                <td>Carpet Cleaning</td>
                                <td>...</td>
                            </tr>
                            <tr>
                                <td>Regular Cleaning</td>
                                <td>...</td>
                            </tr>
                            <tr>
                                <td>Detailed Cleaning</td>
                                <td>...</td>
                            </tr>
                            <tr>
                                <td>Move-out Cleaning</td>
                                <td>...</td>
                            </tr>
                            <tr>
                                <td>Air Bnb Cleaning</td>
                                <td>...</td>
                            </tr>
                            <tr>
                                <td>Carpet Cleaning</td>
                                <td>...</td>
                            </tr>
                            <tr>
                                <td>Regular Cleaning</td>
                                <td>...</td>
                            </tr>
                            <tr>
                                <td>Detailed Cleaning</td>
                                <td>...</td>
                            </tr>
                            <tr>
                                <td>Move-out Cleaning</td>
                                <td>...</td>
                            </tr>
                            <tr>
                                <td>Air Bnb Cleaning</td>
                                <td>...</td>
                            </tr>
                            <tr>
                                <td>Carpet Cleaning</td>
                                <td>...</td>
                            </tr>
                            <tr>
                                <td>Regular Cleaning</td>
                                <td>...</td>
                            </tr>
                            <tr>
                                <td>Detailed Cleaning</td>
                                <td>...</td>
                            </tr>
                            <tr>
                                <td>Move-out Cleaning</td>
                                <td>...</td>
                            </tr>
                            <tr>
                                <td>Air Bnb Cleaning</td>
                                <td>...</td>
                            </tr>
                            <tr>
                                <td>Carpet Cleaning</td>
                                <td>...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <script>
            $(document).ready(function() {
                $('#myTable').DataTable();
            });

            $('#myTable').DataTable({
                stateSave: true,
                layout: {
                    topStart: 'search',
                    topEnd: 'buttons'
                },
                buttons: true,
                scrollY: 450,
                responsive: true,
                language: {
                    emptyTable: 'No data available in table'
                },
                buttons: [{
                    text: '<i class="bi bi-plus"></i> add service',
                    action: function(e, dt, node, config) {
                        let counter = 1;
                        dt.button().add(1, {
                            text: 'Button ' + counter++,
                            action: function() {
                                this.remove();
                            }
                        });
                    }
                }]
            });
        </script>
        <script src="./js/script.js"></script>
</body>

</html>
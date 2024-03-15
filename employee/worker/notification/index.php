<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}
//need nalang ipadisplay mga notifs
require_once "../../php/notifs.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Appointment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="../../css/dashboard_styles.css" />
    <link rel="stylesheet" href="../../css/notification-styles.css">
    <link rel="stylesheet" href="../../../components/_components.css" />

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
                    <a href="../" class="sidebar-link ">
                        <i class="bi bi-house"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../appointment/" class="sidebar-link ">
                        <i class="bi bi-calendar2"></i>
                        <span>Appointments</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../notification/" class="sidebar-link selected">
                        <i class="bi bi-bell-fill"></i>
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
            <div class="container" id="mainArea">
                <div class="mb-5">
                    <h1>Notifcations</h1>
                </div>
                <div class="container" id="subArea-single">
                    <div class="row ">
                        <div class="mb-3 col-xxl-2">
                            <a href="" class="btn my-button-unselected w-100">All Notifcations</a>
                        </div>
                        <div class="mb-4 col-xxl-2">
                            <a href="" class="btn my-button-selected w-100">Unread Notifcations</a>
                        </div>
                    </div>
                 
                    <div class="notification-list">
                        <div class="notification-item">
                            <div class="box-title border-bottom p-3">
                                <h6 class="m-0">TODAY</h6>
                            </div>
                            <div class="notification-content">
                                <div class="notification-header">
                                    <span class="notification-title">Kenneth</span>
                                    <span class="notification-time bi bi-dot">2 hours ago</span>
                                    <div class="elipsis-menu">
                                        
                                    </div>
                                </div>
                                <div class="notification-body">
                                    <p>You have a new message!</p>
                                </div>
                            </div>
                        </div>
                        <div class="box-title border-bottom p-3">
                            <h6 class="m-0">EARLIER</h6>
                        </div>
                        <div class="notification-item">
                            <div class="notification-content">
                                <div class="notification-header">
                                    <span class="notification-title">Dennis</span>
                                    <span class="notification-time bi bi-dot">2 hours ago</span>
                                </div>
                                <div class="notification-body">
                                    <p>You have a new message!</p>
                                </div>
                            </div>
                        </div>
                        <div class="notification-item">
                            <div class="notification-content">
                                <div class="notification-header">
                                    <span class="notification-title">Cyril</span>
                                    <span class="notification-time bi bi-dot">2 hours ago</span>
                                </div>
                                <div class="notification-body">
                                    <p>You have a new message!</p>
                                </div>
                            </div>
                        </div>
                        <div class="notification-item">
                            <div class="notification-content">
                                <div class="notification-header">
                                    <span class="notification-title">Jonald</span>
                                    <span class="notification-time bi bi-dot">2 hours ago</span>
                                </div>
                                <div class="notification-body">
                                    <p>You have a new message!</p>
                                </div>
                            </div>
                        </div>
                        <div class="notification-item">
                            <div class="notification-content">
                                <div class="notification-header">
                                    <span class="notification-title">Denketh</span>
                                    <span class="notification-time bi bi-dot">2 hours ago</span>
                                </div>
                                <div class="notification-body">
                                    <p>You have a new message!</p>
                                </div>
                            </div>
                        </div>
                        <div class="notification-item">
                            <div class="notification-content">

                                <div class="notification-header">
                                    <span class="notification-title">Cy</span>
                                    <span class="notification-time bi bi-dot">2 hours ago</span>
                                </div>
                                <div class="notification-body">
                                    <p>You have a new message!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </section>
    <script src="../../js/script.js"></script>

</body>

</html>
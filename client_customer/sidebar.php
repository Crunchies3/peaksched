<html>
<aside id="sidebar" class="shadow-lg">
    <div class="d-flex mb-2">
        <button id="toggle-btn" type="button">
            <i class="bi bi-tree-fill"></i>
        </button>
        <div class="sidebar-logo">
            <a href="<?php echo "/peaksched/client_customer/dashboard.php" ?>">TwinPeaks</a>
        </div>
    </div>
    <ul class="sidebar-nav">
        <li class="sidebar-item">
            <a href="<?php echo "/peaksched/client_customer/dashboard.php" ?>" class="sidebar-link ">
                <i class="bi bi-house"></i>
                <span>Home</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="<?php echo "/peaksched/client_customer/request-appointment-service.php" ?>" class="sidebar-link">
                <i class="bi bi-calendar2"></i>
                <span>Appointments</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="<?php echo "/peaksched/client_customer/address/index.php" ?>" class="sidebar-link">
                <i class="bi bi-geo-alt"></i>
                <span>Address</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="<?php echo "/peaksched/client_customer/notification/index.php" ?>" class="sidebar-link">
                <i class="bi bi-bell"></i>
                <span>Notifications</span>
            </a>
        </li>
        <li class="sidebar-footer">
            <a href="<?php echo "/peaksched/client_customer/setting_account_page.php" ?>" class=" sidebar-link ">
                <i class=" bi bi-gear"></i>
                <span>Settings</span>
            </a>
        </li>
    </ul>
    <div class="sidebar-footer">
        <a href="<?php echo "/peaksched/client_customer/php_backend/logout.php" ?>" class="sidebar-link">
            <i class="bi bi-box-arrow-left"></i>
            <span>Logout</span>
        </a>
    </div>
</aside>

</html>
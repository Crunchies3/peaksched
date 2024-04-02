<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/data_base.php";

$db = new DataBase('localhost', 'tphcmain_peak', 'PeakSched2024', ' tphcmain_peaksched_db');
$conn = $db->connect();

<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/peaksched/class/data_base.php";

$db = new DataBase('localhost', 'root', '', 'peaksched_db');
$conn = $db->connect();

<?php

require_once '../class/data_base.php';

$db = new DataBase('localhost', 'root', '', 'peaksched_db');
$conn = $db->connect();

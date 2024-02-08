<?php
$servername = "localhost";
$username = "root";
$password = "";
$databasename = "peaksched_db";


// Create connection
$conn = new mysqli($servername, $username, $password, $databasename);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

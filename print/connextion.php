<?php
$servername = "localhost";
$username = "pertamin_koneksi";
$password = "mataSerius17001$";
$dbname = "pertamin_survey";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
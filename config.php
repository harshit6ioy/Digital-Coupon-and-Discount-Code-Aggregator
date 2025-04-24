<?php
$host = "localhost";   
$user = "root";        
$pass = "";            
$dbname = "coupon_aggregator"; // Database name

// Create connection
$conn = mysqli_connect($host, $user, $pass, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

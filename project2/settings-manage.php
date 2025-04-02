<?php

// Database connection variables
$host = 'localhost';          
$user = 'root';
$password = '';
$database = 'cos10027_project2_db'; 
// $host = 'feenix-mariadb.swin.edu.au';          
// $user = 's105728093';
// $password = '050906';
// $database = 's105728093_db'; 

// Create connection
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
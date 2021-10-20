<?php
$servername = "localhost";
$username = "admin";
$password = "Admin_2k21";
$database = "db_nx_assessment";

// Create connection
$db = new mysqli($servername, $username, $password, $database);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
} 
?>
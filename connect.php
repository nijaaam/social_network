<?php
$servername = "us-cdbr-azure-southcentral-f.cloudapp.net";
$username = "b9dee02f541f7c";
$password = "70d033d3";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";
?>
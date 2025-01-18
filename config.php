<?php
// Database connection details
$servername = "localhost";  // Database server
$username = "root";         // Database username
$password = "";             // Database password (set as per your setup)
$dbname = "pureveda";       // Database name (make sure the database exists)

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

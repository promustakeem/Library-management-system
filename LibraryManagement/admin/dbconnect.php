<?php
$servername = "localhost:3307";
$username = "root";
$password = "your_password";
$db = "library_mgmt";

// Create connection
$conn = new mysqli($servername, $username, $password, $db);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>

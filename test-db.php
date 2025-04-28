<?php
$servername = "localhost";
$username = "myuser";  // Replace with your MySQL username
$password = "mypassword";  // Replace with your MySQL password
$dbname = "myapp_db";  // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully to the database!";

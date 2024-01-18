<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


// Replace these values with your database connection details
$servername = "localhost";
$username = "root";
$password = "";
$database = "testsurveyq_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
$testQuery = "SELECT 1";
$result = $conn->query($testQuery);
if (!$result) {
    die("Database connection error: " . $conn->error);
}

?>
<?php
// insert_item.php

// Database connection variables
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "INVENTRACK";  // Replace with your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the POST request is valid
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the query sent from JavaScript
    $query = $_POST['query'];

    // Execute the query
    if ($conn->query($query) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}

// Close the connection
$conn->close();
?>

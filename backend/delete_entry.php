<?php
// Database connection parameters
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "INVENTRACK";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the id is passed via URL
if (isset($_GET['id'])) {
    // Include database connection
    include 'database.php';

    // Get the ID from the URL
    $id = $_GET['id'];

    // SQL query to delete the record from the database
    $sql = "DELETE FROM accounting WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        // Redirect back to the main page after deletion
        header("Location: ../accounting.php");
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    echo "No ID provided.";
}
?>

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

// Check if the form is submitted

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'database.php';

    $name = $_POST["name"];
    $category = $_POST["category"];
    $status = $_POST["status"];
    $amount = $_POST["amount"];

    $sql = "INSERT INTO accounting (name, category, status, amount) VALUES ('$name', '$category', '$status', '$amount')";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../accounting.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

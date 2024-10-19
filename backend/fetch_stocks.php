<?php
// fetch_stocks.php
$servername = "localhost";
$username = "root"; // default username for XAMPP
$password = ""; // default password for XAMPP
$dbname = "INVENTRACK";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM itemsdb";
$result = $conn->query($sql);

$stocks = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $stocks[] = $row;
    }
}

$conn->close();

// Return the stock data as JSON
header('Content-Type: application/json');
echo json_encode($stocks);

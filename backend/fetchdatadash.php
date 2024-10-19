<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "INVENTRACK";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

while (true) {
    // Query to fetch the latest data
    $sql = "SELECT * FROM itemsdb"; // Adjusted to select specific fields
    $result = $conn->query($sql);
    $items = [];

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
    }

    echo "data: " . json_encode($items) . "\n\n"; // Send the data
    ob_flush();
    flush();
    sleep(5); // Wait for 5 seconds before sending the next update
}

// Close the connection after exiting the while loop (not reached in normal operation)
$conn->close();
?>

<?php
// Include database connection
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

// Query to fetch transactions, ordered by created_at descending
$sql = "SELECT * FROM accounting ORDER BY created_at DESC"; // Adjust table and column names as per your schema
$result = $conn->query($sql);

$transactions = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Format the created_at timestamp into different formats
        $createdAt = strtotime($row['created_at']);
        
        // Store formatted date, date, and time
        $formattedDateTime = date('F d, Y H:i:s', $createdAt); // Full datetime
        $formattedDate = date('F d, Y', $createdAt); // Just the date
        $formattedTime = date('h:i A', $createdAt); // Just the time in 12-hour format with AM/PM
    
        $transactions[] = [
            'name' => htmlspecialchars($row['name']),
            'created_at' => $formattedDateTime, // Full datetime
            'date' => $formattedDate, // Just the date
            'time' => $formattedTime, // Just the time
            'status' => htmlspecialchars($row['status']),
            'amount' => number_format($row['amount'], 2)
        ];
    }
    
}

// Return data as JSON
echo json_encode($transactions);

// Close the database connection
$conn->close();
?>

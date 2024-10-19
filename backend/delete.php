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

// Check if the delete form is submitted via AJAX
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    // Get the ID of the item to delete
    $id = $_POST['id'];

    // Prepare an SQL query to delete the item from the database
    $stmt = $conn->prepare("DELETE FROM itemsdb WHERE trayNo = ?");
    $stmt->bind_param("s", $id); // Bind the item ID

    // Execute the query and check for success
    if ($stmt->execute()) {
        // After deletion, reset auto-increment
        // First, check if the table is empty or has items
        $result = $conn->query("SELECT MAX(trayNo) AS max_trayNo FROM itemsdb");
        $row = $result->fetch_assoc();
        $max_trayNo = $row['max_trayNo'];

        if ($max_trayNo) {
            // If there are items in the table, set auto-increment to the max trayNo + 1
            $conn->query("ALTER TABLE itemsdb AUTO_INCREMENT = " . ($max_trayNo + 1));
        } else {
            // If the table is empty, reset auto-increment to 1
            $conn->query("ALTER TABLE itemsdb AUTO_INCREMENT = 1");
        }

        echo json_encode(['status' => 'success', 'message' => 'Item deleted and auto-increment reset successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete the item from the database.']);
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>

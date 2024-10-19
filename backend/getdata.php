<?php
    // Connect to the database
    $conn = new mysqli("localhost", "root", "", "INVENTRACK");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL Query
    $sql = "SELECT * FROM itemsdb LIMIT 1"; 
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Return data in JSON format
        echo json_encode($row);
    } else {
        echo json_encode(["error" => "No data found"]);
    }

    $conn->close();
?>

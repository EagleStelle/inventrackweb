<?php
// database.php

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

$sql = "SELECT id, name, category, status, amount FROM accounting";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data for each row
    while($row = $result->fetch_assoc()) {
        echo "<div class='account-row'>";
        echo "<div class='profile'>";
        echo "<div class='profile-icon'>" . substr($row["name"], 0, 2) . "</div>";
        echo "<div class='profile-details'>";
        echo "<span class='name'>" . $row["name"] . "</span>";
        echo "<span class='category'>" . $row["category"] . "</span>";
        echo "</div></div>";
        
        // Status
        $status_class = strtolower($row["status"]);
        echo "<div class='status'><span class='$status_class'>" . $row["status"] . "</span></div>";
        
        // Amount
        echo "<div class='amount'><span>₱" . number_format($row["amount"], 2) . "</span></div>";

        
        // Actions
        echo "<div class='actions'>";
        echo "<button class='edit-btn' onclick=\"populateEditModal('" . $row['id'] . "', '" . $row['name'] . "', '" . $row['category'] . "', '" . $row['status'] . "', '" . $row['amount'] . "')\">&#x270E;</button>";
        echo "<button class='delete-btn' onclick='deleteEntry(" . $row['id'] . ")'>&#x2716;</button>";
        echo "</div></div>";
    }
} else {
    echo "0 results";
}

$conn->close();
?>
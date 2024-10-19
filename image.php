<?php
// Assuming you are using mysqli to connect
$host = "localhost";
$user = "root"; 
$pass = ""; 
$db = "INVENTRACK";

// Create connection

$conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

// Get the tray number from the query string
$trayNo = $_GET['trayNo'];

// Prepare and execute the query to fetch the image blob
$stmt = $conn->prepare("SELECT ItemImg FROM itemsdb WHERE trayNo = ?");
$stmt->execute([$trayNo]);

// Fetch the image data
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row && $row['ItemImg']) {
    // Get the image data (BLOB) and encode it to base64
    $imageData = base64_encode($row['ItemImg']);
    
    // Get the image MIME type (assuming it's a jpeg, you can adjust based on your image types)
    $mimeType = 'image/jpeg'; // Change if needed to png or other formats

    // Output the base64-encoded image
    echo 'data:' . $mimeType . ';base64,' . $imageData;
} else {
    // Handle case where no image is found
    echo 'data:image/jpeg;base64,'; // Blank image placeholder
}
?>

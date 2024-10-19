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
    // Get form data
    $id = $_POST['id'];
    $name = $_POST['name'];
    $sku = $_POST['sku'];
    $price = $_POST['price'];
    $warning = $_POST['warning'];
    $supplier = $_POST['supplier'];
    $supplierLink = $_POST['supplierLink'];

    // Handle file upload
    $targetDir = "stockimg/"; // Directory where images will be saved
    $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
    $targetFile = $targetDir . uniqid() . '.' . $imageFileType; // Unique file name

    // Check if the uploads directory exists, if not create it
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            // Prepare an SQL query to update the data including the image path
            $stmt = $conn->prepare("UPDATE itemsdb SET itemName=?, SKU=?, price=?, warningquant=?, supplier=?, supplierlink=?, ItemImg=? WHERE trayNo=?");
            $stmt->bind_param("ssssssss", $name, $sku, $price, $warning, $supplier, $supplierLink, $targetFile, $id); // Binding parameters

            if ($stmt->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'File uploaded and data updated successfully!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to update data in database.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Sorry, there was an error uploading your file.']);
        }
    } else {
        // If no image is uploaded, just update the other fields
        $stmt = $conn->prepare("UPDATE itemsdb SET itemName=?, SKU=?, price=?, warningquant=?, supplier=?, supplierlink=? WHERE trayNo=?");
        $stmt->bind_param("sssssss", $name, $sku, $price, $warning, $supplier, $supplierLink, $id); // Binding parameters

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Data updated successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update data in database.']);
        }
    }
}

// Close the database connection
$conn->close();
?>

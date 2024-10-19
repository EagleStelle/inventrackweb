<?php
session_start(); // Start session for logged-in users

// Database connection
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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = $_POST['username'];
    $business_name = $_POST['business-name'];
    $user_password = $_POST['password'];

    // Prepare the SQL query to check for user credentials
    $sql = "SELECT * FROM users WHERE username = ? AND business_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user_name, $business_name);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a user is found
    if ($result->num_rows > 0) {
        // Fetch the user data
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($user_password, $user['password'])) {
            // Password is correct, start a session and store user data
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['business-name'] = $_POST['business-name'];

            // Redirect to dashboard or home page
            header("Location: /inventrackweb/dashboard.php");
            echo "asdasd";
            exit;
        } else {
            header("Location: /inventrackweb/login.html?Invalid");
            echo "Invalid password!";
        }
    } else {
        header("Location: /inventrackweb/login.html?Invalid");
        echo "No account found with that username and business name!";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>

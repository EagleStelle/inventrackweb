<?php

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "INVENTRACK";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $user_name = $_POST['username'];
    $business_name = $_POST['business-name'];
    $user_password = $_POST['password'];

    
    $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);

    
    $sql = "INSERT INTO users (username, business_name, password) VALUES (?, ?, ?)";

    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $user_name, $business_name, $hashed_password);

    
    if ($stmt->execute()) {
        header("Location: /inventrackweb/index.html?Success");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    
    $stmt->close();
    $conn->close();
}
?>

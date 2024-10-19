<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit;
}

// Database connection (replace with your actual database connection code)
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "INVENTRACK";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the image for the logged-in user's business
$business_name = $_SESSION['business-name'];
$sql = "SELECT img FROM businessimg WHERE business_name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $business_name);
$stmt->execute();
$result = $stmt->get_result();

$img_src = "assets/background.png"; // Variable to hold the image source
if ($row = $result->fetch_assoc()) {
    // Get the BLOB data
    $blob = $row['img'];
    
    // Convert BLOB to Base64
    $img_src = 'data:image/jpeg;base64,' . base64_encode($blob); // Adjust the mime type if necessary
}

// Close the database connection
$stmt->close();
$conn->close();
?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Inventrack</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="stylesheet" href="dashboard.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Lexend Deca Regular -->
    <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@400&display=swap" rel="stylesheet">    
    <!-- Montserrat -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400&display=swap" rel="stylesheet">
</head>
<body>
    <div class="white-cover"></div>
    <div class="dashboard">
        <?php include 'header.php'; ?>
    
            <section class="top-section">
                <div class="shop-info">
                    <img src="<?php echo $img_src; ?>" alt="Portrait" class="portrait">
                    <div class="shop-details">
                        <h2 class="shop-title"><?php echo $_SESSION['business-name']; ?></h2>
                        <p class="owner-name"><?php echo $_SESSION['username']; ?></p>
                    </div>
                </div>
            <!-- Middle -->
            <div class="inventory-status">
                <div class="status-text good">
                    <img src="assets/icon-status.png" alt="Icon" class="status-icon">
                    <h1>Bad</h1>
                    <p>Overall Inventory</p>
                </div>
            </div>
            <!-- Right -->
            <div class="wallet">
                <p>Your Wallet</p>
                <p class="wallet-amount">200.5K</p>
            </div>
        </section>

        <section class="main-section">
            <!-- Top Left -->
            <div class="assets">
                <h3>Inventory Value</h3>
                <div class="spider-chart"></div>
                <!-- Legends -->
                <div class="legends">
                    <div class="legend">
                        <div class="legend-rectangle" style="background-color: #F3CC6C;"></div>
                        <p>Legend 1</p>
                    </div>
                    <div class="legend">
                        <div class="legend-rectangle" style="background-color: #E6B34D;"></div>
                        <p>Legend 2</p>
                    </div>
                    <div class="legend">
                        <div class="legend-rectangle" style="background-color: #C2983F;"></div>
                        <p>Legend 3</p>
                    </div>
                    <div class="legend">
                        <div class="legend-rectangle" style="background-color: #AA832E;"></div>
                        <p>Legend 4</p>
                    </div>
                </div>
            </div>
            
            <!-- Top Middle -->
            <div class="transactions">
                <h3>Transactions</h3>
                <div class="transaction-items-container">
                    <div class="transaction-item">
                        <div class="icon">
                            <img src="assets/icon-coin.png" alt="transaction icon">
                        </div>
                        <div class="transaction-details">
                            <p class="transaction-date">Date</p>
                            <p class="transaction-name">Transaction Name</p>
                        </div>
                        <div class="transaction-values">
                            <p>AMOUNT</p>
                        </div>
                    </div>
                    <div class="transaction-item">
                        <div class="icon">
                            <img src="assets/icon-coin.png" alt="transaction icon">
                        </div>
                        <div class="transaction-details">
                            <p class="transaction-date">Date</p>
                            <p class="transaction-name">Transaction Name</p>
                        </div>
                        <div class="transaction-values">
                            <p>AMOUNT</p>
                        </div>
                    </div>
                    <div class="transaction-item">
                        <div class="icon">
                            <img src="assets/icon-coin.png" alt="transaction icon">
                        </div>
                        <div class="transaction-details">
                            <p class="transaction-date">Date</p>
                            <p class="transaction-name">Transaction Name</p>
                        </div>
                        <div class="transaction-values">
                            <p>AMOUNT</p>
                        </div>
                    </div>
                    <div class="transaction-item">
                        <div class="icon">
                            <img src="assets/icon-coin.png" alt="transaction icon">
                        </div>
                        <div class="transaction-details">
                            <p class="transaction-date">Date</p>
                            <p class="transaction-name">Transaction Name</p>
                        </div>
                        <div class="transaction-values">
                            <p>AMOUNT</p>
                        </div>
                    </div>
                </div>
            </div>     
            <!-- Top Right -->
            <div class="invested-value">
                <h3>Invested Value</h3>
                <div class="line-graph"></div>
                <!-- Legends -->
                <div class="legends">
                    <div class="legend">
                        <div class="legend-rectangle" style="background-color: #F3CC6C;"></div>
                        <p>Legend 1</p>
                    </div>
                    <div class="legend">
                        <div class="legend-rectangle" style="background-color: #E6B34D;"></div>
                        <p>Legend 2</p>
                    </div>
                </div>
            </div>
            
            <!-- Bottom Left -->
            <div class="in-demand-items">
                <h3>In Demand Items</h3>
                <ul class="item-list">
                    <li><span class="demand-circle">I.L.</span><div class="item-info"><p>NAME</p><p>category</p></div><div class="item-value"><p>###</p></div></li>
                    <li><span class="demand-circle">I.L.</span><div class="item-info"><p>NAME</p><p>category</p></div><div class="item-value"><p>###</p></div></li>
                    <li><span class="demand-circle">I.L.</span><div class="item-info"><p>NAME</p><p>category</p></div><div class="item-value"><p>###</p></div></li>
                    <li><span class="demand-circle">I.L.</span><div class="item-info"><p>NAME</p><p>category</p></div><div class="item-value"><p>###</p></div></li>
                    <li><span class="demand-circle">I.L.</span><div class="item-info"><p>NAME</p><p>category</p></div><div class="item-value"><p>###</p></div></li>
                    <li><span class="demand-circle">I.L.</span><div class="item-info"><p>NAME</p><p>category</p></div><div class="item-value"><p>###</p></div></li>
                    <li><span class="demand-circle">I.L.</span><div class="item-info"><p>NAME</p><p>category</p></div><div class="item-value"><p>###</p></div></li>
                    <li><span class="demand-circle">I.L.</span><div class="item-info"><p>NAME</p><p>category</p></div><div class="item-value"><p>###</p></div></li>
                    <li><span class="demand-circle">I.L.</span><div class="item-info"><p>NAME</p><p>category</p></div><div class="item-value"><p>###</p></div></li>
                    <li><span class="demand-circle">I.L.</span><div class="item-info"><p>NAME</p><p>category</p></div><div class="item-value"><p>###</p></div></li>
                    <li><span class="demand-circle">I.L.</span><div class="item-info"><p>NAME</p><p>category</p></div><div class="item-value"><p>###</p></div></li>
                </ul>
            </div>

            <!-- Bottom Middle -->
            <div class="stock-overview">
                <h3>Stock Overview</h3>
                <div class="stock-items-container">
                    <div class="stock-item">
                        <div class="icon">
                            <img src="assets/icon-stock-yes.png" alt="Total Products Icon">
                        </div>
                        <div class="stock-details">
                            <p class="stock-value">VALUE</p>
                            <p class="stock-name">Total Products</p>
                        </div>
                    </div>
            
                    <div class="stock-item">
                        <div class="icon">
                            <img src="assets/icon-stocks.png" alt="Total Stocks Icon">
                        </div>
                        <div class="stock-details">
                            <p class="stock-value">VALUE</p>
                            <p class="stock-name">Total Stocks</p>
                        </div>
                    </div>
            
                    <div class="stock-item">
                        <div class="icon">
                            <img src="assets/icon-stock-no.png" alt="Out of Stock Icon">
                        </div>
                        <div class="stock-details">
                            <p class="stock-value">VALUE</p>
                            <p class="stock-name">Out of Stock</p>
                        </div>
                    </div>
                    <div class="stock-item">
                        <div class="icon">
                            <img src="assets/icon-stocks.png" alt="Out of Stock Icon">
                        </div>
                        <div class="stock-details">
                            <p class="stock-value">VALUE</p>
                            <p class="stock-name">Total Stocks</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Bottom Right -->
            <div class="stock-level">
                <h3>Stock Level</h3>
                <div class="bar-graph"></div>
                <div class="legends">
                    <div class="legend">
                        <div class="legend-rectangle" style="background-color: #F3CC6C;"></div>
                        <p>Legend 1</p>
                    </div>
                    <div class="legend">
                        <div class="legend-rectangle" style="background-color: #E6B34D;"></div>
                        <p>Legend 2</p>
                    </div>
                    <div class="legend">
                        <div class="legend-rectangle" style="background-color: #C2983F;"></div>
                        <p>Legend 3</p>
                    </div>
                    <div class="legend">
                        <div class="legend-rectangle" style="background-color: #cda348;"></div>
                        <p>Legend 4</p>
                    </div>
                    <div class="legend">
                        <div class="legend-rectangle" style="background-color: #6e5421;"></div>
                        <p>Legend 5</p>
                    </div>
                    <div class="legend">
                        <div class="legend-rectangle" style="background-color: #3b3014;"></div>
                        <p>Legend 6</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Bottom Yellow Bar -->
        <div class="bottom-bar"></div>
    </div>
    <script src="dashboard.js"></script>
</body>
</html>

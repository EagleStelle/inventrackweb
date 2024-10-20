<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit;
}







































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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="white-cover"></div>
    <div class="dashboard">
        <?php include 'header.php'; ?>

        <section class="top-section">
            <!-- Left -->
            <div class="shop-info">
                <img src="assets/background.png" alt="Portrait" class="portrait">
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
                <p class="wallet-amount" id="walletAmount">₱0.00</p> <!-- Add an ID for easy targeting -->
            </div>

        </section>

        <section class="main-section">
            <!-- Top Left -->
            <div class="stock-overview">
                <h3>Stock Overview</h3>
                <div class="stock-items-container" id="stockItemsContainer">
                    <!-- Stock items will be populated here -->
                </div>
            </div>

            <!-- Top Middle -->
            <div class="transactions">
                <h3>Transactions</h3>
                <div class="transaction-items-container" id="transaction-items-container">






                </div>
            </div>

            <!-- Top Right -->
            <div class="stock-level">
                <h3>Stock Level</h3>
                <div class="bar-graph">



                    <canvas id="myChart" width="400" height="350"></canvas>










                </div>

            </div>
    </div>
    </section>
    <!-- Bottom Yellow Bar -->
    <div class="bottom-bar"></div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            let chart; // Reference to the Chart instance
            let totalpriceperitem = 0; // Initialize the total price variable

            const source = new EventSource('backend/fetchdatadash.php'); // Replace with your PHP file path

            source.onmessage = function (event) {
                console.log("Received data:", event.data); // Debugging line
                const items = JSON.parse(event.data);
                $('#stockItemsContainer').empty(); // Clear existing items
                totalpriceperitem = 0; // Reset total price before recalculating

                // Update the DOM with stock data
                items.forEach(item => {
                    const icon = item.computedQuantity > 0 ? 'assets/icon-stock-yes.png' : 'assets/icon-stock-no.png';
                    const stockValue = item.computedQuantity > 0 ? 'Stock: ' + item.computedQuantity : 'Out of Stock';

                    const stockItemHtml = `
                <div class="stock-item">
                    <div class="icon">
                        <img src="${icon}" alt="${stockValue === 'Out of Stock' ? 'Out of Stock Icon' : 'Total Products Icon'}">
                    </div>
                    <div class="stock-details">
                        <p class="stock-value">${item.itemName}</p>
                        <p class="stock-name">${stockValue}</p>
                    </div>
                </div>
            `;
                    $('#stockItemsContainer').append(stockItemHtml); // Append new stock item

                    // Calculate total price for items in stock
                    if (item.computedQuantity > 0) {
                        totalpriceperitem += (item.computedQuantity * item.price); // Ensure item.price exists
                    }
                });

                // Extract chart labels and data from the items
                const labels = items.map(item => item.itemName); // Use item names as labels
                const quantities = items.map(item => item.computedQuantity); // Use quantities for chart data

                // If the chart already exists, update its data
                if (chart) {
                    chart.data.labels = labels; // Update labels
                    chart.data.datasets[0].data = quantities; // Update dataset
                    chart.update(); // Re-render the chart with new data
                } else {
                    // If the chart doesn't exist, create it
                    const ctx = document.getElementById('myChart');
                    chart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels, // Dynamically set labels from items
                            datasets: [{
                                label: 'Stock Levels',
                                data: quantities,

                                // Dynamically set data from quantities

                                backgroundColor: [
                                    'rgba(245, 182, 7, 1)'  // Color for first bar
                                ],




                                borderWidth: 1,
                                minBarThickness: 50, // Set the thickness of the bars
                                maxBarThickness: 60 // Optional: set a maximum bar thickness
                            }]
                        },
                        options: {
                            scales: {
                                x: {
                                    // Increase spacing between bars using categoryPercentage and barPercentage
                                    ticks: {
                                        maxRotation: 90, // Rotate labels if needed
                                        minRotation: 45, // Minimal rotation
                                    }// Controls the percentage of the available width used by each bar
                                },
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                }

                // Log total price
                console.log("Total price per item:", totalpriceperitem);
                $('#walletAmount').text('₱' + totalpriceperitem.toFixed(2)); // Update wallet amount display
                totalpriceperitem = 0; // Reset total price after updating wallet amount
            };

            source.onerror = function (event) {
                console.error("EventSource failed:", event); // Debugging line
            };
        });



        function fetchTransactions() {

            $.ajax({
                url: 'backend/get_accounting.php',
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    let transactionsHtml = '';
                    data.forEach(function (transaction) {
                        // Determine the status class
                        let statusClass = '';
                        switch (transaction.status.toLowerCase()) {
                            case 'paid':
                                statusClass = 'status-paid';
                                break;
                            case 'unpaid':
                                statusClass = 'status-unpaid';
                                break;
                            case 'pending':
                                statusClass = 'status-pending';
                                break;
                            default:
                                statusClass = 'status-default';
                        }

                        // Generate the HTML for each transaction
                        transactionsHtml += `
                        <div class='transaction-item'>
                            <div class='icon'><img src='assets/icon-coin.png' alt='transaction icon'></div>
                            <div class='transaction-details'>
                                <p class='transaction-name'>${transaction.name}</p>
                                <p class='transaction-date'>${transaction.date}</p>
                                <p class='transaction-time'>${transaction.time}</p>
                                <p class='status ${statusClass}'>${transaction.status}</p>
                            </div>
                            <div class='transaction-values'>
                                <p>₱${transaction.amount}</p>
                            </div>
                        </div>
                    `;
                    });
                    console.log(' transactions:');
                    // Update the transactions container with new data
                    $('#transaction-items-container').html(transactionsHtml);
                },
                error: function (error) {
                    console.error('Error fetching transactions:', error);
                }
            });

        }

        // Fetch transactions every 5 seconds (5000 ms)
        setInterval(fetchTransactions, 5000);

        // Fetch transactions when the page loads
        $(document).ready(fetchTransactions);











    </script>


</body>

</html>
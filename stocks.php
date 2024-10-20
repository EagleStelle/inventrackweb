<?php
// stocks.php
$servername = "localhost";
$username = "root"; // default username for XAMPP
$password = ""; // default password for XAMPP
$dbname = "INVENTRACK";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM itemsdb";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Inventrack</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="stylesheet" href="stocks.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@400&display=swap" rel="stylesheet">    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="stocks">
    <?php include 'header.php'; ?>
        <section class="filter-section">
            <button>Item Name</button>
            <button>Shelf Number</button>
            <button>Supplier</button>
            <button>Status</button>
            <div class="search-bar">
                <span class="search-icon">
                    <img src="assets/icon-search.png" alt="Search Icon" width="16" height="16">
                </span>
                <input type="text" id="search-input" placeholder="Search" onkeydown="handleSearch(event)">
            </div>
        </section>

        <section class="card-container">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="card" data-id="' . $row['trayNo'] . '">';
                    echo '<div class="card-img">';
                    echo '<img src="assets/background.png" alt="assets/background.png">';
                    echo '<button class="edit-btn" value="' . (!empty($row['supplierlink']) ? $row['supplierlink'] : 'N/A') . '">&#x270E;</button>';
                    echo '</div>';
                    echo '<div class="card-details">';
                    echo '<div class="card-header">';
                    echo '<div class="item-name-quantity">';
                    $itemName = !empty($row["itemName"]) ? $row["itemName"] : 'Shelf Number: ' . $row["trayNo"];
                    echo '<h3 class="item-name">' . $itemName . '</h3>';
                    echo '<div class="quantity">' . $row["computedQuantity"] . '</div>';
                    echo '</div>'; // item-name-quantity
                    echo '</div>'; // card-header
                    echo '<div class="quantity-text">qty.</div>';
                    $sku = !empty($row["SKU"]) ? $row["SKU"] : 'N/A';
                    echo '<p>SKU: ' . $sku . '</p>';
                    echo '<p>Shelf Number: ' . $row["trayNo"] . '</p>';
                    $price = !empty($row["price"]) ? $row["price"] : 'N/A';
                    echo '<p>Price: ' . $price . '</p>';
                    echo '<p>Supplier: ' . (!empty($row['supplier']) ? $row['supplier'] : 'N/A') . '</p>';
                    echo '<p>Quantity Warning: ' . (!empty($row['warningquant']) ? $row['warningquant'] : 'N/A') . '</p>';
                    echo '<p class="status">Status: </p>'; // Assuming you will fill this data later
                    echo '<button class="order-now" value="' . (!empty($row['supplierlink']) ? $row['supplierlink'] : 'N/A') . '">ORDER NOW</button>';
                    echo '</div>'; // card-details
                    echo '</div>'; // card
                }
            } else {
                echo "0 results";
            }
            $conn->close();
            ?>
        </section>

        <button class="add-btn" onclick ="addItem()">+</button>
    </div>
    <div id="edit-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit Item</h2>
                <span class="close-button">&times;</span>
            </div>

            <form id="edit-form" action="" method="POST" enctype="multipart/form-data">
                <input type="input" id="edit-item-id" name="id" hidden>
                <label for="edit-item-name">Item Name:</label>
                <input type="text" id="edit-item-name" name="name" required>

                <label for="edit-sku">SKU:</label>
                <input type="text" id="edit-sku" name="sku">

                <label for="edit-price">Price:</label>
                <input type="text" id="edit-price" name="price">

                <label for="edit-warning">Quantity Warning:</label>
                <input type="text" id="edit-warning" name="warning">

                <label for="edit-supplier">Supplier:</label>
                <input type="text" id="edit-supplier" name="supplier">

                <label for="edit-supplierlink">Supplier Link:</label>
                <input type="text" id="edit-supplierlink" name="supplierLink">

                <label for="imageUpload">Upload an image:</label>
                <input type="file" id="imageUpload" name="image" accept="image/*">

                <button type="submit" class="modal-button">Save Changes</button>
            </form>
            <button id="delete-btn" type="button" class="modal-button">Delete</button>
        </div>
    </div>
</div>

    
<script>
      $(document).ready(function() {
        // AJAX call for Delete action
        $('#delete-btn').on('click', function() {
            var itemId = $('#edit-item-id').val(); // Get the ID of the item
            console.log(itemId);
            if (confirm("Are you sure you want to delete this item?")) {
                $.ajax({
                    url: 'backend/delete.php', // Your PHP script to handle deletion
                    type: 'POST',
                    data: { id: itemId, delete: true }, // Send the item ID and delete flag
                    success: function(response) {
                        var jsonResponse = JSON.parse(response);
                        $('#response-message').html('<p>' + jsonResponse.message + '</p>');

                        if (jsonResponse.status === 'success') {
                            
                            $('#edit-form')[0].reset();
                            closeModal();
                            location.reload()
                        }
                    },
                    error: function() {
                        $('#response-message').html('<p>An error occurred while deleting the item.</p>');
                    }
                });
            }
        });
    });
    
    function fetchStocks() {
    $.getJSON('backend/fetch_stocks.php', function(data) {
        const $cardContainer = $('.card-container');
        $cardContainer.empty(); // Clear existing cards

        $.each(data, function(index, item) {
            const imgSrc = item.ItemImg && item.ItemImg.trim() !== '' ? `./backend/${item.ItemImg}` : 'assets/background.png';
            
            // Determine stock status based on computedQuantity and warningQuant
            let stockStatus = 'In stock'; // Default status
            let statusClass = 'iin-stock'; // Default class

            if (item.computedQuantity <= 0) {
                stockStatus = 'Out of stock';
                statusClass = 'out-of-stock'; // Class for blinking red
            } else if (item.computedQuantity <= item.warningquant) {
                stockStatus = 'Low stocks';
                statusClass = 'low-stock'; // Class for orange
            }

            const card = `
                <div class="card" data-id="${item.trayNo}">
                    <div class="card-img">
                        <img src="${imgSrc}" alt="Item Image" onerror="this.onerror=null; this.src='assets/background.png';">
                        <button class="edit-btn" value="${item.supplierlink || 'N/A'}">&#x270E;</button>
                    </div>
                    <div class="card-details">
                        <div class="card-header">
                            <div class="item-name-quantity">
                                <h3 class="item-name">${item.itemName || `Shelf Number: ${item.trayNo}`}</h3>
                                <div class="quantity">${item.computedQuantity}</div>
                            </div>
                        </div>
                        <div class="quantity-text">qty.</div>
                        <p>SKU: ${item.SKU || 'N/A'}</p>
                        <p>Shelf Number: ${item.trayNo}</p>
                        <p>Price: ${item.price || 'N/A'}</p>
                        <p>Supplier: ${item.supplier || 'N/A'}</p>
                        <p>Quantity Warning: ${item.warningquant || 'N/A'}</p>
                        <p>Status:<span class="status ${statusClass}"> ${stockStatus}</span></p> <!-- Status with dynamic class -->
                        <button class="order-now" value="${item.supplierlink || 'N/A'}">ORDER NOW</button>
                    </div>
                </div>
            `;
            $cardContainer.append(card);
        });

        // Reattach event listeners after rendering new cards
        attachEditButtonListeners();
    }).fail(function() {
        console.error('Error fetching stocks');
    });
}


    // Fetch stocks initially
    fetchStocks();

    // Set interval to fetch stocks every 5 seconds
    setInterval(fetchStocks, 5000);

    // Function to open the modal and populate with data
    function openEditModal(item) {
    // Populate the form with the item data
    $('#delete-item-id').val(item.shelfno); // Set the trayNo as the ID
    $('#edit-item-id').val(item.shelfno); // Set the trayNo as the ID
    $('#edit-item-name').val(item.itemName || ''); // Set the item name
    $('#edit-sku').val(item.SKU || ''); // Set the SKU
    $('#edit-price').val(item.price || ''); // Set the price
    $('#edit-warning').val(item.warning || ''); // Set the quantity warning
    $('#edit-supplier').val(item.supplier || ''); // Set the supplier name
    $('#edit-supplierlink').val(item.supplierLink || ''); // Set the supplier link (if available)

    // Clear the file input for image upload
    $('#imageUpload').val(''); // Clear the image file input

    // Show the modal
    $('#edit-modal').show();
}

fetchStocks();
    // Function to close the modal
    function closeModal() {
        $('#edit-modal').hide();
    }

    // Event listener for the close button
    $('.close-button').on('click', closeModal);

    // Close modal when user clicks outside of it
    $(window).on('click', function(event) {
        const modal = $('#edit-modal');
        if ($(event.target).is(modal)) {
            closeModal();
        }
    });

    // Event listener for the edit form submission
    $('#edit-form').on('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission

    // Create a FormData object to capture the form data
    const formData = new FormData(this);

    // Debugging output to log the form data
    for (const [key, value] of formData.entries()) {
        console.log(`${key}: ${value}`);
    }

    // Send the updated data to the server
    $.ajax({
        url: 'backend/update_stock.php', // Update the URL to your PHP script
        method: 'POST',
        data: formData,
        contentType: false, // Let jQuery set the content type
        processData: false, // Prevent jQuery from processing the data
        success: function(data) {
            if (data.success) {
                closeModal(); // Close the modal on success
                fetchStocks(); // Refresh the stock list
            } else {
                
                closeModal();
                location.reload()
            }
        },
        error: function(xhr, status, error) {
                        $('#response').html("An error occurred: " + error); // Show error message
                    }
    });
});


    // Attach event listener to the Edit buttons
    function attachEditButtonListeners() {
    $('.edit-btn').off('click').on('click', function() {
        const $itemCard = $(this).closest('.card');
        const supplierLink = $('.edit-btn').val();
        // Extracting item details from the card
        const item = {
            trayNo: $itemCard.find('p:nth-child(3)').text().replace('Shelf Number: ', ''), // Use trayNo as ID
            itemName: $itemCard.find('.item-name').text(), // Extract item name
            SKU: $itemCard.find('p:nth-child(3)').text().replace('SKU: ', ''), // Extract SKU
            price: $itemCard.find('p:nth-child(5)').text().replace('Price: ', ''), // Extract price
            supplier: $itemCard.find('p:nth-child(6)').text().replace('Supplier: ', ''), // Extract supplier name
            shelfno: $itemCard.find('p:nth-child(4)').text().replace('Shelf Number: ', ''), // Assuming shelfno is the same as trayNo
            supplierLink: supplierLink, // Supplier link (optional, to be filled later if available)
            warning:$itemCard.find('p:nth-child(7)').text().replace('Quantity Warning: ', ''),
            image: '', // Image will be handled separately
        };

        // Call the function to open the modal and populate it with the extracted item data
        openEditModal(item);
    });

    $('.order-now').off('click').on('click', function() {
        const supplierLink = $(this).val(); // Get the supplier link
        redirectToLink(supplierLink); // Redirect
    });
}

// Function to handle redirection
function redirectToLink(link) {
    if (link && link !== 'N/A') {
        // Check if the link starts with http:// or https://
        const fullLink = link.startsWith('http://') || link.startsWith('https://') ? link : `http://${link}`;
        window.open(fullLink, '_blank'); // Open in a new tab
    } else {
        alert('No supplier link available.'); // Optional: alert if link is not available
    }
}

// Function triggered when the "Add" button is clicked
function addItem() {
    // Prompt the user to input a quantity
    let quantity = prompt("Enter the quantity to add:");
    
    // Check if the input is valid
    if (quantity !== null && !isNaN(quantity) && quantity > 0) {
        console.log("Adding " + quantity + " items to the database.");
        
        // Loop to send multiple INSERT queries
        for (let i = 0; i < quantity; i++) {
            // Use jQuery's AJAX function to send the request
            $.ajax({
                url: 'backend/newitem.php',  // PHP script handling the database insertion
                type: 'POST',
                data: {
                    query: "INSERT INTO itemsdb (offset) VALUES (0)"
                },
                success: function(response) {
                    console.log("Item " + (i + 1) + " inserted successfully: " + response);
                },
                error: function(xhr, status, error) {
                    console.error("Error inserting item " + (i + 1) + ": " + error);
                }
            });
        }
    } else {
        alert("Invalid quantity. Please enter a number greater than 0.");
    }
}


// Assuming the button has an id "add-button"
document.getElementById("add-button").addEventListener("click", addItem);


    // Initial attachment of event listeners
    attachEditButtonListeners();
</script>



</body>
</html>

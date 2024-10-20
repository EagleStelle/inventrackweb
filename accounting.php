<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title>Inventrack</title>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link rel="stylesheet" href="accounting.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <!-- Lexend Deca Regular -->
        <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@400&display=swap" rel="stylesheet">    
        <!-- Montserrat -->
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
    </head>
<body>
    <div class="stocks">
    <?php include 'header.php'; ?>
        <section class="filter-section">
            <button>Date</button>
            <button>Type</button>
            <button>Supplier</button>
            <button>Status</button>
            <div class="search-bar">
                <span class="search-icon">
                    <img src="assets/icon-search.png" alt="Search Icon" width="16" height="16">
                </span>
                <input type="text" id="search-input" placeholder="Search" onkeydown="handleSearch(event)">
            </div>
        </section>
        <section class="accounting-section">
            <?php include 'backend/populateaccounting.php';?>
        </section>
        <button class="add-btn">+</button>
    </div>

<!-- Add Modal -->
<div id="addModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
        <h2>Add Entry</h2>
        <span class="close" onclick="closeModal('addModal')">&times;</span>
    </div>
    <form id="addForm" method="post" action="backend/add_entry.php">
      <label for="name">Name:</label>
      <input type="text" id="name" name="name" required>

      <label for="category">Category:</label>
      <input type="text" id="category" name="category" required>

      <label for="status">Status:</label>
      <select id="status" name="status">
        <option value="PAID">Paid</option>
        <option value="PENDING">Pending</option>
        <option value="UNPAID">Unpaid</option>
      </select>

      <label for="amount">Amount:</label>
      <input type="number" id="amount" name="amount" required>
      <button type="submit" class="modal-button">Add</button>
    </form>
  </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
        <h2>Edit Item</h2>
        <span class="close" onclick="closeModal('editModal')">&times;</span>
    </div>
    <form id="editForm" method="post" action="backend/edit_entry.php">
      <input type="hidden" id="editId" name="id">
      
      <label for="editName">Name:</label>
      <input type="text" id="editName" name="name" required>

      <label for="editCategory">Category:</label>
      <input type="text" id="editCategory" name="category" required>

      <label for="editStatus">Status:</label>
      <select id="editStatus" name="status">
        <option value="PAID">Paid</option>
        <option value="PENDING">Pending</option>
        <option value="UNPAID">Unpaid</option>
      </select>

      <label for="editAmount">Amount:</label>
      <input type="number" id="editAmount" name="amount" required>
      <button type="submit" class="modal-button">Save Changes</button>
    </form>
  </div>
</div>

<!-- Add button trigger modal -->
<button class="add-btn" onclick="openModal('addModal')">+</button>

    <script>
        function openModal(modalId) {
            document.getElementById(modalId).style.display = "block";
        }
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = "none";
        }
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                closeModal('addModal');
                closeModal('editModal');
            }
        }
        function populateEditModal(id, name, category, status, amount) {
            document.getElementById('editId').value = id;
            document.getElementById('editName').value = name;
            document.getElementById('editCategory').value = category;
            document.getElementById('editStatus').value = status;
            document.getElementById('editAmount').value = amount;
            openModal('editModal');
        }
        function deleteEntry(id) {
            if (confirm("Are you sure you want to delete this entry?")) {
                window.location.href = "backend/delete_entry.php?id=" + id;
            }
        }
    </script>

</body>
</html>
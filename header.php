<?php
// Get the current page name
$current_page = basename($_SERVER['PHP_SELF']);
?>
<link rel="stylesheet" href="header.css">
<header class="header">
    <div class="nav">
        <div class="nav-left">
            <img src="assets/logo-gold.png" alt="Logo" class="logo">
            <img src="assets/icon-bell.png" alt="Bell" class="bell-icon">
        </div>
        <ul class="nav-right">
            <li class="<?= $current_page == 'dashboard.php' ? 'active' : '' ?>">
                <a href="dashboard.php" class="no-style">Dashboard</a>
            </li>
            <li class="<?= $current_page == 'stocks.php' ? 'active' : '' ?>">
                <a href="stocks.php" class="no-style">Stocks</a>
            </li>
            <li class="<?= $current_page == 'accounting.php' ? 'active' : '' ?>">
                <a href="accounting.php" class="no-style">Accounting</a>
            </li>
            <li class="<?= $current_page == 'settings.php' ? 'active' : '' ?>">
                <a href="settings.php" class="no-style">Settings</a>
            </li>
        </ul>
    </div>
</header>

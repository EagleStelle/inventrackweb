<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title>Inventrack</title>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link rel="stylesheet" href="settings.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <!-- Lexend Deca Regular -->
        <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@400&display=swap" rel="stylesheet">    
        <!-- Montserrat -->
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
    </head>
<body>
    <div class="settings">
    <?php include 'header.php'; ?>
        <!-- Profile Section -->
        <div class="profile-section">
            <div class="profile-img">
                <img src="assets/background.png" alt="Profile Image">
            </div>
            <div class="profile-details">
                <h2>Shop Name</h2>
                <p>Owner Name</p>
            </div>
        </div>
        <!-- Settings List -->
        <div class="settings-list">
            <a href="#" class="setting-item">
                <div class="icon-text">
                    <img src="assets/icon-settings-account.png" alt="Account Icon">
                    <span>Account Settings</span>
                </div>
                <span class="arrow">&#8250;</span>
            </a>

            <a href="#" class="setting-item">
                <div class="icon-text">
                    <img src="assets/icon-settings-security.png" alt="Security Icon">
                    <span>Log In and Security</span>
                </div>
                <span class="arrow">&#8250;</span>
            </a>

            <a href="#" class="setting-item">
                <div class="icon-text">
                    <img src="assets/icon-settings-notifications.png" alt="Notification Icon">
                    <span>Notification Settings</span>
                </div>
                <span class="arrow">&#8250;</span>
            </a>

            <a href="backend/logout.php" class="setting-item">
                <div class="icon-text">
                    <img src="assets/icon-settings-signout.png" alt="Sign Out Icon">
                    <span>Sign Out</span>
                </div>
                <span class="arrow">&#8250;</span>
            </a>
        </div>
    </div>
</body>
</html>

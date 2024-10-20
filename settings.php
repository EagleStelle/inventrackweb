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
            <div class="setting-item" id="account-settings">
                <div class="icon-text">
                    <img src="assets/icon-settings-account.png" alt="Account Icon">
                    <span>Account Settings</span>
                </div>
                <span class="arrow">&#8250;</span>
            </div>
            <!-- Dropdown Menu for Account Settings -->
            <div class="dropdown-content" id="account-dropdown">
                <div class="dropdown-item">Change Username</div>
                <div class="dropdown-item">Change Shop Name</div>
            </div>

            <div class="setting-item" id="login-security">
                <div class="icon-text">
                    <img src="assets/icon-settings-security.png" alt="Security Icon">
                    <span>Log In and Security</span>
                </div>
                <span class="arrow">&#8250;</span>
            </div>
            <!-- Dropdown Menu for Log In and Security -->
            <div class="dropdown-content" id="security-dropdown">
                <div class="dropdown-item">Change Password</div>
            </div>

            <a href="backend/logout.php" class="setting-item">
                <div class="icon-text">
                    <img src="assets/icon-settings-signout.png" alt="Sign Out Icon">
                    <span>Sign Out</span>
                </div>
            </a>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                // Dropdowns and arrows
                const accountSettings = document.getElementById('account-settings');
                const accountDropdown = document.getElementById('account-dropdown');
                const accountArrow = accountSettings.querySelector('.arrow');
                const accountItems = accountDropdown.querySelectorAll('.dropdown-item');

                const loginSecurity = document.getElementById('login-security');
                const securityDropdown = document.getElementById('security-dropdown');
                const securityArrow = loginSecurity.querySelector('.arrow');
                const securityItems = securityDropdown.querySelectorAll('.dropdown-item');

                // Helper function to apply the falling animation
                function toggleDropdown(dropdown, items, arrow, isOpen) {
                    let delay = 0;
                    if (isOpen) {
                        items.forEach((item, index) => {
                            item.style.animation = `fallDown 0.3s ease forwards`;
                            item.style.animationDelay = `${delay}s`;
                            delay += 0.1; // Stagger the animation
                        });
                        dropdown.style.display = 'block';
                    } else {
                        delay = 0; // Reset the delay for falling up
                        items.forEach((item, index) => {
                            item.style.animation = `fallUp 0.3s ease forwards`;
                            item.style.animationDelay = `${delay}s`;
                            delay += 0.1;
                        });
                        setTimeout(() => {
                            dropdown.style.display = 'none'; // Hide after the animation finishes
                        }, 300 + (items.length * 100)); // Wait until the animation is done
                    }
                    arrow.classList.toggle('rotate');
                }

                // Toggle dropdown for Account Settings
                accountSettings.addEventListener('click', function () {
                    const isVisible = accountDropdown.style.display === 'block';
                    toggleDropdown(accountDropdown, accountItems, accountArrow, !isVisible);
                });

                // Toggle dropdown for Log In and Security
                loginSecurity.addEventListener('click', function () {
                    const isVisible = securityDropdown.style.display === 'block';
                    toggleDropdown(securityDropdown, securityItems, securityArrow, !isVisible);
                });
            });
        </script>
</body>
</html>

<?php
session_start();

$dsn = "mysql:host=127.0.0.1:3307;dbname=splitx";
$dbus = "root";
$dbpass = "";
$pdo = new PDO($dsn, $dbus, $dbpass);

$user_id = $_SESSION['user_id'];  

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Fetch the current password of the user from the database
    $query = "SELECT * FROM users WHERE id = :user_id";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':user_id' => $user_id]);
    $user = $stmt->fetch();

    if ($user) {
            // Check if the new password and confirm password match
            if ($new_password === $confirm_password) {
                // Hash the new password
                
                // Update the password in the database
                $updateQuery = "UPDATE users SET pass = :password WHERE id = :user_id";
                $stmt = $pdo->prepare($updateQuery);
                $stmt->execute([':password' => $new_password, ':user_id' => $user_id]);

                echo "Password updated successfully.";
            } else {
                echo "New password and confirm password do not match.";
            }
    } 
    else {
        echo "User not found.";
    }
}
?>
<html>
    <head>
    <title>Settings</title>
    </head>
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
<script>
function toggleWidth() {
    const container = document.getElementById('sidebar');
    const checkbox = document.getElementById('check-icon');
    const body = document.getElementById('body1');
    const hiddenTexts = document.querySelectorAll('#text');
    if (checkbox.checked) {
        container.style.width = '14vw';
        body.classList.add('blur-background');
        hiddenTexts.forEach(hiddenText => {
            hiddenText.classList.remove('hidden-text');
            hiddenText.classList.add('visible-text');
        }); // Show hidden text
    } else {
        container.style.width = '5vw';
        body.classList.remove('blur-background');
        hiddenTexts.forEach(hiddenText => {
            hiddenText.classList.add('hidden-text');
            hiddenText.classList.remove('visible-text');
        });
    }
}
</script>
 
<body> 
    <div class="container"> 
        <div id="sidebar" class="sidebar">
            <div class="nav">
                <div class="logo1">
                    <button class="navlogo"><input hidden="" class="check-icon" id="check-icon" name="check-icon"
                            type="checkbox" onchange="toggleWidth()">
                        <label class="icon-menu" for="check-icon">
                            <div class="bar bar--1"></div>
                            <div class="bar bar--2"></div>
                            <div class="bar bar--3"></div>
                        </label>
                        <h3 id="text" class=" x1 hidden-text">SplitX</h3>
                    </button>
                </div>
            </div>
            <br>
            <div class="logos">
                <div class="logo passive"><span class="material-symbols-outlined">dashboard</span><a href="dashboard.php"
                        id="text" class="hidden-text ">Dashboard</a></div>
                <div class="hbar"></div>
                <div class="logo passive"><span class="material-symbols-outlined">groups</span><a href="group.php"
                        id="text" class="hidden-text">Group</a></div>
                <div class="hbar"></div>
                <div class="logo passive"><span class="material-symbols-outlined">vital_signs</span><a
                        href="activity.php" id="text" class="hidden-text">Activity</a></div>
                <div class="hbar"></div>
                <div class="logo active_logo"><span class="material-symbols-outlined">settings</span><a href="#"
                        id="text" class="hidden-text active">Settings</a></div>
                <div class="hbar"></div>
            </div>
        </div>
        <div class="body" id="body1">
          <div class="heading-container">
            <h1 class="heading">Settings</h1>
            </div>
          <div> 
            <form method="POST" action="settings.php">
            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="new_password" required><br><br>

            <label for="confirm_password">Confirm New Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required><br><br>
            <button type="submit">Update Password</button>
            </form>
            <br>
            <button class="expense_button" onclick="window.location.href='logout.php'">Logout</button>
        </div>
    </div>
</body>
</html>

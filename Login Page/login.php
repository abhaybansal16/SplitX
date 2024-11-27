<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    // Check if fields are empty
    if (empty($username) || empty($password)) {
        echo "Please fill in all fields.";
    } else {
        try {
            // Database connection
            $dsn = "mysql:host=127.0.0.1:3307;dbname=splitx";
            $dbus = "root";
            $dbpass = "";
            $pdo = new PDO($dsn, $dbus, $dbpass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Check if username and password match
            $query = "SELECT * FROM users WHERE username = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            if ($user && ($password===$user['pass'])) {
                $_SESSION['user_id'] = $user['id']; // Store user ID in session
                $_SESSION['username'] = $user['username'];
                // Successful login
                echo "<script>window.location.href='dashboard.php';</script>";
                exit(); // Always call exit after header redirect
            } else {
                // Invalid credentials
                echo "Invalid username or password.";
            }
        } catch (PDOException $e) {
            // Handle database connection error
            echo "Error: " . $e->getMessage();
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SplitX Login</title>
    <link rel="stylesheet" href="signup.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body>
    <div class="container">
        <nav>
            <h1 id="logo">SplitX</h1>
        </nav>
        <div class="login_design">
            <h3>Log In</h3>
            <p class="description">Access your account and manage your finances.</p>
                <form id="loginForm" method="POST" action="login.php">
                    <!-- Username Field -->
                    <div class="signup_page" id="username">
                        <input type="text" name="username" placeholder="Username" id="usernameInput" required>
                    </div>

                    <!-- Password Field -->
                    <div class="signup_page" id="password">
                        <div class="password-container">
                            <input type="password" name="password" placeholder="Password" id="passInput" required>
                            <button type="button" class="toggle-password" id="togglePassword">
                                <span class="material-symbols-outlined">visibility</span>
                            </button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="signup_page" id="login">
                        <input type="submit" value="Log In" id="signup_Btn">
                    </div>
                </form>
                <!-- Redirect to Signup -->
                <p class="redirect">
                    Don’t have an account? <a href="signup.php">Sign Up</a>.
                </p>
        </div>
    </div>
    <script>
        // Toggle visibility for Password field
        document.getElementById("togglePassword").addEventListener("click", function() {
            const passInput = document.getElementById("passInput");
            const icon = this.querySelector(".material-symbols-outlined");
            if (passInput.type === "password") {
                passInput.type = "text";
                icon.textContent = "visibility_off";
            } else {
                passInput.type = "password";
                icon.textContent = "visibility";
            }
        });
    </script>
</body>
</html>

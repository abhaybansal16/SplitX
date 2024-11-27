<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["name"];
    $password = $_POST["password"];
    $phone = $_POST["phone"];
    $confirmPassword = $_POST["confirm_password"];

    // Validate input fields
    if (empty($username) || empty($password) || empty($phone) || empty($confirmPassword)) {
        echo "<script>alert('All fields are required!'); window.location.href='signup.php';</script>";
        exit();
    }

    if ($password !== $confirmPassword) {
        echo "<script>alert('Passwords do not match!'); window.location.href='signup.php';</script>";
        exit();
    }

    try {
        // Database connection
        $dsn = "mysql:host=127.0.0.1:3307;dbname=splitx";
        $dbus = "root";
        $dbpass = "";
        $pdo = new PDO($dsn, $dbus, $dbpass);

        // Insert user data into the database
        $query = "INSERT INTO users (username, pass, phone) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$username, $password, $phone]);

        // Redirect to the login page with an alert
        echo "<script>alert('Signup successful! Redirecting to login.'); window.location.href='login.php';</script>";
        exit();
    } catch (PDOException $e) {
        echo "<script>alert('Database error: " . $e->getMessage() . "'); window.location.href='signup.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SplitX Sign Up</title>
    <link rel="stylesheet" href="signup.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body>
    <div class="container">
        <nav>
            <h1 id="logo">SplitX</h1>
        </nav>
        <div class="signup_design">
            <h3>Sign Up</h3>
            <p class="description">Join SplitX and manage your finances easily.</p>
            
            <section class="part1">
                <form id="signupForm" method="POST" action="signup.php">
                    <!-- Username Field -->
                    <div class="signup_page" id="username">
                        <input type="text" name="name" placeholder="Username" id="usernameInput" required>
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

                    <!-- Confirm Password Field -->
                    <div class="signup_page" id="confirm_password">
                        <div class="password-container">
                            <input type="password" name="confirm_password" placeholder="Confirm Password" id="confirmPassInput" required>
                            <button type="button" class="toggle-password" id="toggleConfirmPassword">
                                <span class="material-symbols-outlined">visibility</span>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Phone Number Field -->
                    <div class="signup_page" id="phone">
                        <input type="tel" name="phone" placeholder="Phone Number" id="phoneInput" pattern="[0-9]{10}" required>
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="signup_page" id="signup">
                        <input type="submit" value="Sign Up" id="signup_Btn">
                    </div>
                </form>
                <!-- Redirect to Login -->
                <p class="redirect">
                    Already signed up? <a href="login.php">Log in</a>.
                </p>
            </section>
        </div>
    </div>
    <script>
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

        document.getElementById("toggleConfirmPassword").addEventListener("click", function() {
            const confirmPassInput = document.getElementById("confirmPassInput");
            const icon = this.querySelector(".material-symbols-outlined");
            if (confirmPassInput.type === "password") {
                confirmPassInput.type = "text";
                icon.textContent = "visibility_off";
            } else {
                confirmPassInput.type = "password";
                icon.textContent = "visibility";
            }
        });
    </script>
</body>
</html>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity</title>
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
                <div class="logo passive"><span class="material-symbols-outlined">dashboard</span><a
                        href="dashboard.php" id="text" class="hidden-text ">Dashboard</a></div>
                <div class="hbar"></div>
                <div class="logo passive"><span class="material-symbols-outlined">groups</span><a href="group.php"
                        id="text" class="hidden-text">Group</a></div>
                <div class="hbar"></div>
                <div class="logo active_logo"><span class="material-symbols-outlined">vital_signs</span><a href="#"
                        id="text" class="hidden-text active">Activity</a></div>
                <div class="hbar"></div>
                <div class="logo passive"><span class="material-symbols-outlined">settings</span><a href="settings.php"
                        id="text" class="hidden-text">Settings</a></div>
                <div class="hbar"></div>
            </div>
        </div>
        <div class="body" id="body1">
            <div class="heading-container">
                <h1 class="heading">Activity</h1>
            </div>
            <?php
                    $dsn = "mysql:host=127.0.0.1:3307;dbname=splitx";
                    $dbus = "root"; 
                    $dbpass = "";
                    $pdo = new PDO($dsn, $dbus, $dbpass);
        
                    // Query to select data from the expense1 table
                    $q2 = "SELECT * FROM expense1;";
                    $stmt2 = $pdo->prepare($q2);
                    $stmt2->execute();
        
                    // Fetch all the results
                    $result = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        
                    // Check if there are results
                    if (empty($result)) {
                        echo "No expenses found";
                    } else {
                        // Create the HTML table structure
                        echo "<table border='1'>";
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>Group ID (gid)</th>";
                        echo "<th>Amount</th>";
                        echo "<th>User ID (payer)</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
            
                        // Loop through the results and display them in table rows
                        foreach ($result as $r) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($r["gid"]) . "</td>";
                            echo "<td>" . htmlspecialchars($r["amount"]) . "</td>";
                            echo "<td>" . htmlspecialchars($r["user_id"]) . "</td>";
                            echo "</tr>";
                        }
            
                        echo "</tbody>";
                        echo "</table>";
                    }
                ?>
        </div>
</body>

</html>

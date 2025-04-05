<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
                <div class="logo active_logo"><span class="material-symbols-outlined">dashboard</span><a href="#"
                        id="text" class="hidden-text active">Dashboard</a></div>
                <div class="hbar"></div>
                <div class="logo passive"><span class="material-symbols-outlined">groups</span><a href="group.php"
                        id="text" class="hidden-text">Group</a></div>
                <div class="hbar"></div>
                <div class="logo passive"><span class="material-symbols-outlined">vital_signs</span><a
                        href="activity.php" id="text" class="hidden-text">Activity</a></div>
                <div class="hbar"></div>
                <div class="logo passive"><span class="material-symbols-outlined">settings</span><a href="settings.php"
                        id="text" class="hidden-text">Settings</a></div>
                <div class="hbar"></div>
            </div>
        </div>
        <div class="body" id="body1">
            <div class="heading-container">
                <h1 class="heading">Dashboard</h1>
                <button class="expense_button" onclick="window.location.href='expense.php'">Add Expense</button>
                <button class="expense_button" onclick="window.location.href='addgc.php'">Add Group</button>
            </div>
            <div>
                <?php
                session_start();
                $dsn = "mysql:host=127.0.0.1:3307;dbname=splitx";
                $dbus = "root"; 
                $dbpass = "";
                $pdo = new PDO($dsn, $dbus, $dbpass);
            if (isset($_SESSION['user_id'])) {
            echo "<h2>"."Hello, " . htmlspecialchars($_SESSION['username']) . "!"."</h2>";
            $loggedInUserId = $_SESSION['user_id'];
            }
            ?>
            </div>
            <?php
                  $qOwed = "
                  SELECT SUM(e.amount / (gm.member_count)) AS total_owed
                  FROM expense1 e
                  JOIN (
                      SELECT gid, COUNT(user_id) AS member_count
                      FROM group_mem
                      GROUP BY gid
                  ) gm ON e.gid = gm.gid
                  WHERE e.user_id != :user_id
                    AND EXISTS (
                        SELECT 1
                        FROM group_mem
                        WHERE gid = e.gid AND user_id = :user_id
                    )
              ";
              $qPaid = "
                    SELECT SUM(e.amount / (gm.member_count - 1)) AS total_paid
                    FROM expense1 e
                    JOIN (
                        SELECT gid, COUNT(user_id) AS member_count
                        FROM group_mem
                        GROUP BY gid
                        ) gm ON e.gid = gm.gid
                    WHERE e.user_id = :user_id
                    ";

            $stmtOwed = $pdo->prepare($qOwed);
            $stmtOwed->execute([':user_id' => $loggedInUserId]);

            $stmtPaid = $pdo->prepare($qPaid);
            $stmtPaid->execute([':user_id' => $loggedInUserId]);
            
            $paidResult = $stmtPaid->fetch(PDO::FETCH_ASSOC);
            $owedResult = $stmtOwed->fetch(PDO::FETCH_ASSOC);
            
            $totalOwed = $owedResult['total_owed'] ?? 0;
            $totalPaid = $paidResult['total_paid'] ?? 0;
            
            $netOwed = $totalOwed - $totalPaid;    
              // Check if the user owes anything
              if ($netOwed==0) {
                  echo "You don't owe anything at the moment.";
              } else if($netOwed>0){
                  // Display the total amount owed
                    echo "<table border='1' id='group-table'>";
                    echo "<thead>";
                    echo "<tr>";
                    //echo "<th>User ID</th>";
                    echo "<th>Total Owed</th>";
                    echo "<th>Total Paid</th>";
                    echo "<th>Net Amount Owed</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";

                    echo "<tr>";
                    //echo "<td>" . htmlspecialchars($loggedInUserId) . "</td>";
                    echo "<td>" . htmlspecialchars(number_format($totalOwed, 2)) . "</td>";
                    echo "<td>" . htmlspecialchars(number_format($totalPaid, 2)) . "</td>";
                    echo "<td>" . htmlspecialchars(number_format($netOwed, 2)) . "</td>";
                    echo "</tr>";

                    echo "</tbody>";
                    echo "</table>";
              }
              else{
                    $netOwed=$totalPaid-$totalOwed;
                     // Display the total amount owed
                     echo "<table border='1' id='group-table'>";
                     echo "<thead>";
                     echo "<tr>";
                     echo "<th>Total Owed</th>";
                     echo "<th>Total Paid</th>";
                     echo "<th>Net Amount Owed to you</th>";
                     echo "</tr>";
                     echo "</thead>";
                     echo "<tbody>";
 
                     echo "<tr>";
                     echo "<td>" . htmlspecialchars(number_format($totalOwed, 2)) . "</td>";
                     echo "<td>" . htmlspecialchars(number_format($totalPaid, 2)) . "</td>";
                     echo "<td>" . htmlspecialchars(number_format($netOwed, 2)) . "</td>";
                     echo "</tr>";
                     echo "</tbody>";
                     echo "</table>";
            }
            echo "<h2>Groups You are in</h2>"."<br>";
            $query = "
            SELECT g.group_id, g.gname
            FROM group_mem gm
            JOIN groups g ON gm.gid = g.group_id
            WHERE gm.user_id = :user_id
            ";

            $stmt = $pdo->prepare($query);
            $stmt->execute([':user_id' => $loggedInUserId]);
            $groups = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Display the groups in a table
            if (empty($groups)) {
                echo "<p>You are not a member of any groups.</p>";
            } 
            else {
                echo "<table border='1' id='group-table'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>Group ID</th>";
                echo "<th>Group Name</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
            
                foreach ($groups as $group) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($group['group_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($group['gname']) . "</td>";
                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";
            }
          ?>
        </div>
    </div>
</body>

</html>

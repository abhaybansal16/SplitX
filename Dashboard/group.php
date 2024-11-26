<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Groups</title>
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
                        id="text" class="hidden-text active">Dashboard</a></div>
                <div class="hbar"></div>
                <div class="logo active_logo"><span class="material-symbols-outlined">groups</span><a href="group.php"
                        id="text" class="hidden-text active">Group</a></div>
                <div class="hbar"></div>
                <div class="logo passive"><span class="material-symbols-outlined">vital_signs</span><a
                        href="activity.php" id="text" class="hidden-text">Activity</a></div>
                <div class="hbar"></div>
                <div class="logo passive"><span class="material-symbols-outlined">settings</span><a href="settings.html"
                        id="text" class="hidden-text">Settings</a></div>
                <div class="hbar"></div>
            </div>
        </div>
        <div class="body" id="body1">
          <div class="heading-container">
            <h1 class="heading">Groups</h1>
            <button class="expense_button" onclick="window.location.href='addgc.php'">Add Group</button>
          </div>
          <?php
                $dsn="mysql:host=127.0.0.1:3307;dbname=splitx";
                $dbus="root"; 
                $dbpass="";
                $pdo=new PDO($dsn,$dbus,$dbpass);
                $q2="SELECT * FROM groups;";
                $stmt2=$pdo->prepare($q2);
                $stmt2->execute();
                $result=$stmt2->fetchAll(PDO::FETCH_ASSOC);
                if(empty($result)){
                    echo "No groups found";
                }
                else{
                    foreach($result as $r){
                        echo "<div class='group'><h2>"." ID: ".$r["group_id"]." Name: ".$r["gname"]."<br>"."</h2>";
                        $group_id=$r["group_id"];
                        $q1="SELECT * FROM group_mem WHERE gid=$group_id";
                        $stmt3=$pdo->prepare($q1);
                        $stmt3->execute();
                        $re=$stmt3->fetchAll(PDO::FETCH_ASSOC);
                        if(empty($re)){
                            echo "No group member found";
                        }
                        else{
                          foreach($re as $mem){
                            $userid=$mem["user_id"];
                            $q3="SELECT * FROM users WHERE id=$userid";
                            $stmt4=$pdo->prepare($q3);
                            $stmt4->execute();
                            $user=$stmt4->fetch(PDO::FETCH_ASSOC);
                            if($user){
                              echo $user["username"]."<br>";
                            }
                          }
                        }
                      echo "</div>";
                    }
                }
            ?>
</body>
</html>


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
                <div class="logo passive"><span class="material-symbols-outlined">group</span><a href="friend.html"
                        id="text" class="hidden-text">Friend</a></div>
                <div class="hbar"></div>
                <div class="logo passive"><span class="material-symbols-outlined">groups</span><a href="group.html"
                        id="text" class="hidden-text">Group</a></div>
                <div class="hbar"></div>
                <div class="logo passive"><span class="material-symbols-outlined">vital_signs</span><a
                        href="activity.html" id="text" class="hidden-text">Activity</a></div>
                <div class="hbar"></div>
                <div class="logo passive"><span class="material-symbols-outlined">settings</span><a href="settings.html"
                        id="text" class="hidden-text">Settings</a></div>
                <div class="hbar"></div>
            </div>
        </div>
        <div class="body" id="body1">
          <div class="heading-container">
            <h1 class="heading">Dashboard</h1>
            <button class="expense_button"><a href="expense.php">Add Expense</a></button>
            <button class="expense_button"><a href="addgc.php">Add Group</a></button>
          </div>
            <div class="Groups">
                <h3>Group List</h3>
                <?php
      $dsn="mysql:host=127.0.0.1:3307;dbname=splitx";
      $dbus="root";
      $dbpass="";
      $pdo=new PDO($dsn,$dbus,$dbpass);
      $q2="Select * from groups;";
      $stmt2=$pdo->prepare($q2);
      $stmt2->execute();
      $result=$stmt2->fetchAll(PDO::FETCH_ASSOC);
      if(empty($result)){
        echo "No groups found";
      }
      else{
        foreach($result as $r){
            echo $r["group_id"]." ".$r["gname"]."<br>";
        }
      }
      ?>
            </div>
            
          </div>
    </div>
</body>

</html>

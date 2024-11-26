<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Tutorial</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
   <form action="expense.php" method="post" class="form1">
   <label for="user">User Name:</label>
    <input id="user" name="user" type="text" placeholder="User Name...">
    <label for="gpname">Group Name:</label>
    <input id="gpname" name="gpname" type="text" placeholder="Group Name...">
    <label for="amount">Amount:</label>
    <input id="amount" name="amount" type="number" placeholder="Amount...">
    <button type="submit">Submit</button>   
</form>
<?php
session_start();
   if($_SERVER["REQUEST_METHOD"]=="POST"){
    $User = $_POST['user'];
    $groupName = $_POST['gpname'];
    $amount=$_POST["amount"];
    if(empty($groupName)||empty($amount) ||empty($User)){
        header("Location: ../splitX/dashboard.php");
    }
    $dsn="mysql:host=127.0.0.1:3307;dbname=splitx";
    $dbus="root";
    $dbpass="";
    $pdo=new PDO($dsn,$dbus,$dbpass);
    $query = "SELECT group_id FROM groups WHERE gname = '$groupName'";
    $stmt=$pdo->prepare($query);
    $stmt->execute();
    $result=$stmt->fetch(PDO::FETCH_ASSOC);
    if($result){
        $groupid=$result['group_id'];
    $query1 = "SELECT id FROM users WHERE username = '$User'";
    $stmt1=$pdo->prepare($query1);
    $stmt1->execute();
    $result1=$stmt1->fetch(PDO::FETCH_ASSOC);
    if($result1){
        $userId=$result1['id'];
        $q = "INSERT INTO expense1 (user_id,gid, amount) VALUES (:user_id,:gid, :amount)";

    // Prepare the statement
    $s = $pdo->prepare($q);

    // Bind the parameters
    $s->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $s->bindParam(':gid', $groupid, PDO::PARAM_INT);
    $s->bindParam(':amount', $amount, PDO::PARAM_STR); // Use PARAM_STR for monetary values

    
    // Execute the query
    $s->execute();
    include 'split_expense.php';
    echo "expense added successfully";
    // header("Location: ../splitX/dashboard.php");
    }
}
}
?>
<a href="dashboard.php">Head to Dashboard</a>
</body>
</html>

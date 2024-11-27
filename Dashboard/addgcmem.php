<?php
session_start();

$dsn = "mysql:host=127.0.0.1:3307;dbname=splitx";
$dbus = "root";
$dbpass = "";
$pdo = new PDO($dsn, $dbus, $dbpass);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $group_id = $_POST['group_id'];
    $user_id = $_POST['user_id'];

    $checkQuery = "SELECT * FROM group_mem WHERE gid = :group_id AND user_id = :user_id";
    $stmt = $pdo->prepare($checkQuery);
    $stmt->execute([':group_id' => $group_id, ':user_id' => $user_id]);
    $existingMember = $stmt->fetch();

    if ($existingMember) {
        echo "User is already a member of this group.";
    } else {
        $addQuery = "INSERT INTO group_mem (gid, user_id) VALUES (:group_id, :user_id)";
        $stmt = $pdo->prepare($addQuery);
        $stmt->execute([':group_id' => $group_id, ':user_id' => $user_id]);

        echo "User added to the group successfully.";
    }
}
?>

<html>
<head>
<title>Add Group Member</title>
<link rel="stylesheet" href="dashboard.css">
</head>    
<body>    
<form method="POST" action="addgcmem.php">
    <label for="group_id">Group ID:</label>
    <input type="text" id="group_id" name="group_id" required><br><br>

    <label for="user_id">User ID:</label>
    <input type="text" id="user_id" name="user_id" required><br><br>

    <button type="submit">Add Member</button>
</form>
</body>
</html>

<?php
function addGroup($gname, $user_ids,$gid) {
    $dsn = "mysql:host=127.0.0.1:3307;dbname=splitx";
    $dbus = "root";
    $dbpass = "";

    try {
        $pdo = new PDO($dsn, $dbus, $dbpass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query1 = "INSERT INTO `groups` (group_id,gname) VALUES (:gid,:gname)";
        $stmt1 = $pdo->prepare($query1);
        $stmt1->bindParam(':gname', $gname, PDO::PARAM_STR);
        $stmt1->bindParam(':gid', $gid, PDO::PARAM_STR);
        $stmt1->execute();

        $query2 = "INSERT INTO `group_mem` (gid, user_id) VALUES (:gid, :user_id)";
        $stmt2 = $pdo->prepare($query2);

        foreach ($user_ids as $user_id) {
            $stmt2->bindParam(':gid', $gid, PDO::PARAM_INT);
            $stmt2->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt2->execute();
        }

        echo "Group added successfully with ID: $gid and users added.";

    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Group</title>
</head>
<link rel="stylesheet" href="add.css">

<body>
    <form action="addgc.php" method="POST">
        <label for="gname">Group Name:</label>
        <input type="text" id="gname" name="gname" required>
        <br><br>
        <label for="gid">Group ID:</label>
        <input type="number" id="gid" name="gid" required>
        <br><br>
        <label for="user_ids">User IDs (comma separated):</label>
        <input type="text" id="user_ids" name="user_ids" placeholder="1, 2, 3" required>
        <br><br>
        <button type="submit">Add Group</button>
    </form>
    <?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gname = $_POST['gname'];
    $gid = $_POST['gid'];
    $user_ids = explode(',', $_POST['user_ids']); // Split the user IDs by commas

    addGroup($gname, $user_ids,$gid);
}
?>
    <a href="dashboard.php">Head to Dashboard</a>
</body>

</html>

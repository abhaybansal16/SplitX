<?php
   if($_SERVER["REQUEST_METHOD"]=="POST"){
    $name=$_POST["name"];
    $password=$_POST["password"];
    $phone=$_POST["phone"];
    if(empty($name)||empty($password)||empty($phone)){
        header("Location: ../signup.php");
    }
    $dsn="mysql:host=127.0.0.1:3307;dbname=users";
    $dbus="root";
    $dbpass="";
    $pdo=new PDO($dsn,$dbus,$dbpass);
    $query="Insert into users(name,pass,phone) values (?,?,?);";
    $stmt=$pdo->prepare($query);
    $stmt->execute([$name,$password,$phone]);
}
?>

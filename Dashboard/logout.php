<?php
session_start();
session_unset();
session_destroy();
header("Location: ../splitX/index.html");
exit();
?>

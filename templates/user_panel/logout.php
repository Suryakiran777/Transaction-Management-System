<?php   
session_start(); //to ensure you are using same session
session_destroy();
header("location:../index.php"); //to redirect back to "index.php" after logging out
exit();
?>
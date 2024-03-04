<?php
session_start();
require '../conn.php';
require '../auser.php';

$dueval = $_POST['due_val'];
$cust_name1 = $_POST['due_name'];
$due_upquery = "UPDATE `cstmrdb` SET `due` = $dueval WHERE `cust_name` = '$cust_name1'";
mysqli_query($conn, $due_upquery);
header('location:index.php')

?>
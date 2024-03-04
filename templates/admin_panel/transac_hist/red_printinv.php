<?php
session_start();
require '../conn.php';
require '../auser.php';
 $prt_inv = $_POST['prt_inv'];
 $_SESSION['inv_no'] = $prt_inv;
 header('location:../invoicesys/print_inv.php');
?>
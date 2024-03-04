<?php
session_start();
require '../conn.php';
require '../auser.php';
$inv_no =  $_SESSION['inv_no'];
 $delbtn1 = $_POST['delbtn1'];
 $rqty = $_POST['r_qty'];
 $inrecdbq = "SELECT `qty` from `inrec` WHERE `item_name` = '$delbtn1'";
 $inrecdbq_ex = mysqli_query($conn,$inrecdbq);
 $inrecdbq_fetch = mysqli_fetch_array($inrecdbq_ex);
 $upd_qty1 = $inrecdbq_fetch['qty'] + $rqty;
 $updquery = "UPDATE `inrec` SET `qty` = '$upd_qty1' WHERE `item_name` = '$delbtn1'";
 $updexquery = mysqli_query($conn,$updquery);
 $invdb_delquery = "DELETE FROM `invdb` WHERE `invoice_id` = '$inv_no' AND `item_name` = '$delbtn1'";
 $invdb_delexquery = mysqli_query($conn,$invdb_delquery);
 if($invdb_delexquery){
     echo "success";
     header('location:invoctable.php');
 }else{
      echo "failed";
  }
?>
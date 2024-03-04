<?php
require 'conn.php';
require 'auser.php';
$trnxs_query ="SELECT * FROM `invdb1` WHERE `due`>0  LIMIT 10";
$trnxs_exquery = mysqli_query($conn,$trnxs_query);
$trnxs_fetch_query = mysqli_fetch_array($trnxs_exquery);

$trnxs_query1 ="SELECT sum(`due`) as total_due FROM `invdb1` WHERE `due` > 0";
$trnxs_exquery1 = mysqli_query($conn,$trnxs_query1);
$trnxs_fetch_query1 = mysqli_fetch_array($trnxs_exquery1);

$trnxs_query2 ="SELECT DISTINCT(COUNT(`cust_name`)) as total_cust FROM `invdb1`";
$trnxs_exquery2 = mysqli_query($conn,$trnxs_query2);
$trnxs_fetch_query2 = mysqli_fetch_array($trnxs_exquery2);


$trnxs_query3 ="SELECT SUM(`total`) as total_transac FROM `invdb1`";
$trnxs_exquery3 = mysqli_query($conn,$trnxs_query3);
$trnxs_fetch_query3 = mysqli_fetch_array($trnxs_exquery3);
?>

<?php
session_start();
require '../conn.php';
require '../auser.php';
$inv_no =  $_SESSION['inv_no'];
    $tax = $_POST('t_tax');
    $t_disc = $_POST('t_disc');
    $t_deposit = $_POST('t_deposit');
    $t_amount = $_POST('t_amount');
    $t_due = $_POST('t_due');
    $issue_date = $_POST('issue_date');
    $due_date = date('y-m-d', strtotime($_POST['duedate']));
    $invdb1_updquery = "UPDATE `invdb1` SET `tax`='$tax',`discount`='$t_disc',`total`='$t_amount',`deposit`='$t_deposit',`due`='$t_due ',`issue_date`='$issue_date',`due_date`='$due_date' WHERE `invoice_id` = '$inv_no'";
    $invdb1_updexquery = mysqli_query($conn, $invdb1_updquery);
    if ($invdb1_updexquery) {
        echo "successful";
        
    } else {
        echo "Unsuccessful";
    }
    ?>
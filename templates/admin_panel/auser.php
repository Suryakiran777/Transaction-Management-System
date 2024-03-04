<?php
    $a_name = $_SESSION['aLoginName'];
    $a_query = "SELECT `username` FROM `admctrl` WHERE  `name` = '$a_name'";
    $a_exquery = mysqli_query($conn,$a_query);
    $a_fetch = mysqli_fetch_array($a_exquery);
    $a_uname = $a_fetch['username'];
?>
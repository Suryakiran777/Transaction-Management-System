
<?php
    require 'conn.php';
    $nusers_query = "SELECT * from `usrctrl` where `a_name`= '$a_uname'";
    $nusers_exquery = mysqli_query($conn,$nusers_query);
    $nusers_fetch = mysqli_fetch_array($nusers_exquery);
?>
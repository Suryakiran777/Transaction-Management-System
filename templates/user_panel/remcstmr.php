<?php
session_start();
require 'conn.php';
require 'auser.php';
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/apanel.css">
    <script src="js/ad_p.js" type="text/javascript"></script>
    <style>
        body{
            background-image: none;
            background-color: white;
        }
        .adduserdiv{
            width: 100%;
            background-color: white;
            border: 0px solid red;
            height:540px;

        }   
        .rdiv6-pagediv1-ldiv h2{
            margin: 0px;
            margin-top: 10px;
            margin-left: 10px;
            margin-bottom: 20px;
        }
        .ctypetext{
            margin-top: 5px;
            margin-bottom: 5px;
            border-color: lavender;
        }
        input[type='text']::placeholder, input[type='select']::placeholder{
            font-family: 'segoe ui';
            font-weight: 600;
        }
        .cbutton{
            margin-left: 30%;

        }
        iframe{
            height: 100%;
            width: 100%;
        }
    </style>
</head>
<?php 
    $sshopquery = "SELECT `cust_name` FROM `cstmrdb` WHERE `a_name` = '$a_uname'";
    $shopexquery = mysqli_query($conn,$sshopquery);
    
?>
<body>
    <div class="adduserdiv">
        <!-- Add User Div starts Here -->
    <div class="rdiv6-pagediv1-ldiv">
        <h2>Remove Customer</h2>
        <form method="POST">
           <input class="ctypeselect" type="text" name="u_sname" list="custremlist">
           <datalist id="custremlist">  
               <?php 
               while($shopexfetch = mysqli_fetch_array($shopexquery)){
                echo "<option>" .$shopexfetch['cust_name']. "</option>";
               }
               ?>
           </datalist>
            </select>
            <input class="cbutton" type="submit" value="Remove" name='submit'>
            <?php
            if(isset($_POST['submit'])){
            $u_sname = $_POST['u_sname'];
            $u_delquery = "DELETE FROM `cstmrdb` WHERE `cust_name`='$u_sname'";
            $u_exaddquery= mysqli_query($conn,$u_delquery);
            echo "Removed Successfully";
            }
            ?>
        </form>
</div>
 <!-- Add User Div ends Here -->
<div class="rdiv6-pagediv1-rdiv">
<iframe src="cstmrdb.php" id="inventorytable" frameborder="0"></iframe>
</div>
    </div>
</body>
</html>
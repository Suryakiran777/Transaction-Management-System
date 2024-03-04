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
        body {
            background-image: none;
            background-color: white;
        }

        .adduserdiv {
            width: 100%;
            background-color: white;
            border: 0px solid red;
            height: 540px;

        }

        .rdiv6-pagediv1-ldiv h2 {
            margin: 0px;
            margin-top: 10px;
            margin-left: 10px;
            margin-bottom: 20px;
        }

        .ctypetext {
            margin-top: 5px;
            margin-bottom: 5px;
            border-color: lavender;
        }

        input[type='text']::placeholder,
        input[type='select']::placeholder {
            font-family: 'segoe ui';
            font-weight: 600;
        }

        .cbutton {
            margin-left: 30%;

        }

        iframe {
            height: 100%;
            width: 100%;
        }
        .addinvenform input[type='text']{
            margin-top: 2px;
            margin-bottom: 2px;
        }
        .ctypetext{
            border-color: red;
            margin-bottom: 10px;
        }
        .custdatal{
            background-color: red;
        }
    </style>
</head>
<?php
$sshopquery = "SELECT * FROM `cstmrdb` WHERE `a_name` = '$a_uname'";
$shopexquery = mysqli_query($conn, $sshopquery);
$fcust_fetchname = "Select Customer";
$fcust_email = "example@gmail.com";
$cust_no = "Enter Number";
$cust_wallet = "Enter Wallet ";

?>

<body>
    <div class="adduserdiv">
        <!-- Add User Div starts Here -->
        <div class="rdiv6-pagediv1-ldiv">
            <h2>Update Customer</h2>
            <form method="post">
                <input class="ctypetext" type="text" name="u_sname" list="custdata" placeholder="Select Customer Name"> 
                <datalist class="custdatal" id="custdata">
                    <option value="">Select</option>   
                    <?php
                    while ($shopexfetch = mysqli_fetch_array($shopexquery)) {
                        echo "<option>" . $shopexfetch['cust_name'] . "</option>";
                    }
                    ?>
                    </datalist>
                </select>
                <input class="cbutton" type="submit" onclick="loadiframe()" value="Fetch" name='submit'>
                <script>
                    function loadiframe() {
                        var cframe = document.getElementById('cstmrdbiframe');
                        cframe.src = "updcstmrfetch.php";
                    }
                </script>
                <?php

                if (isset($_POST['submit'])) {
                    $cust_name = $_POST['u_sname'];
                    $fcust_query = "SELECT * from `cstmrdb` WHERE `cust_name` = '$cust_name'";
                    $fcust_exquery = mysqli_query($conn, $fcust_query);
                    $fcust_fetch = mysqli_fetch_array($fcust_exquery);
                    $fcust_fetchname = $fcust_fetch['cust_name'];
                    $cust_no = $fcust_fetch['cust_no'];
                    $fcust_email = $fcust_fetch['cust_email'];
                    $cust_wallet = $fcust_fetch['wallet'];

                }
                ?>
            </form>
            <form id="formID" method="POST">
                <div class="addinvenform">
                    <input type="text" name="def_name" style="display: none;" placeholder="Customer Name" value="<?php echo $fcust_fetchname ?>" required><br>
                    <input type="text" name="cust_name" placeholder="Customer Name" value="<?php echo $fcust_fetchname ?>" required><br>
                    <input type="text" name="cust_no" id="" placeholder="Mobile Number" id="t_qty" value="<?php echo $cust_no ?>" required><br>
                    <input type="text" name="cust_email" placeholder="Email" id="i_cost" value="<?php echo $fcust_email  ?>"><br>
                    <input type="text" name="wallet" placeholder="Wallet" id="i_cost" value="<?php echo $cust_wallet ?>" required><br>
                    <input type="submit" class="cbutton aitembtn" value="Update Item" name="submit1">
                </div>
                <?php
                if (isset($_POST['submit1'])) {
                    $cust_defname = $_POST['def_name'];
                    $ccust_name = $_POST['cust_name'];
                    $cust_no = $_POST['cust_no'];
                    $cust_email = $_POST['cust_email'];
                    $cust_wallet = $_POST['wallet'];
                    $cstupd_query = "UPDATE `cstmrdb` SET  `cust_name`='$ccust_name', `cust_no` =' $cust_no',`cust_email`= '$cust_email',`wallet`='$cust_wallet' WHERE `cust_name` = '$cust_defname'";

                    $cupd_exquery = mysqli_query($conn, $cstupd_query);
                    echo "Successfully Updated";
                }

                ?>

            </form>
            <iframe id="cstmrdbiframe" frameborder="0"></iframe>
        </div>
        <!-- Add User Div ends Here -->
        <div class="rdiv6-pagediv1-rdiv">
            <iframe src="cstmrdb.php" id="inventorytable" frameborder="0"></iframe>
        </div>
    </div>
</body>

</html>
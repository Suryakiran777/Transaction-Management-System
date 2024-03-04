<?php
session_start();
require '../conn.php';
require '../auser.php';
$inv_no =  $_SESSION['inv_no'];
$invdb_query = "SELECT * FROM `invdb` WHERE `invoice_id` = '$inv_no'";
$invdb_exquery = mysqli_query($conn,$invdb_query);
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/apanel.css">
    <script src="../js/ad_p.js" type="text/javascript"></script>
    <style>
        body{
            background-image: none;
        }
        .tablediv{
            width: auto;
            border: 0px solid red;
        }
        .tablediv table tr th{
            height: 30px ;
            background-color: #27374D;
            color: white;
            font-size: 13px;
        }
        .tablediv table tr td{
            height: 30px ;
            text-align: center;
            font-size: 13px;
            background-color: whitesmoke;
            
        }
        .del_btn{
            border: 0px solid red;
            background-color: lightcoral;
            height: 20px;
            width: 20px;
            cursor: pointer;
        }
        .del_btn:hover{
            box-shadow: 0px 0px 10px 1px black;
        }
        .cust_qty{
            width: 10%;
            background-color: transparent;
            border:0px solid ;
        }
    </style>
</head>
<body>
    <div class="tablediv">
        <table width="100%" border="0" >
            <tr>
                <th>No</th>
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Tax</th>
                <th>Price</th>
                <th>Remove</th>
            </tr>
            <?php
            $i = 1;
            while($invdb_fetch = mysqli_fetch_array($invdb_exquery)){
                ?>
            
            <tr>
                <form  action="deldata.php" method="POST">
                <td><?php echo $i ?></td>
                <td><?php echo $invdb_fetch['item_name'] ?></td>
                <td><input readonly class="cust_qty" type="text" name="r_qty" id="" value="<?php echo $invdb_fetch['i_qty'] ?>"></td>
                <td><?php echo $invdb_fetch['i_tax'] ?></td>
                <td><?php echo $invdb_fetch['i_price'] ?></td>
                <td><button class="del_btn" name="delbtn1" value="<?php echo $invdb_fetch['item_name']?>"></button><td>
            </form>
            </tr>
            <?php
            $i++;
            }
            ?>
        </table>
    </div>
</body>
</html>
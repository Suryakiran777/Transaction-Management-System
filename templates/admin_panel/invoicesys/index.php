<?php
session_start();
require '../conn.php';
require '../auser.php';
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/apanel.css">
    <script src="../js/ad_p.js" type="text/javascript"></script>
    <title>Document</title>
    <style>
        .invoice-cstmr-dts{
            background-color: #27374D;
            color: white;
        }
        .invoice-cstmr-dts h4{
            padding: 10px 10px 10px 10px;
        }
        .ctypetext{
            margin: 10px 0px 10px 10px;
            color: white;
            border-color: white;
            width: 20%;
            
        }
        .ctypetext2{
            margin: 5px 5px 5px 5px;    
        }
        .ctypebutton2{
            margin:10px 10px 10px 10px;
        }
        .invoice-cstmr-dts-form{
            
        }
        .ctypeselect{
            color: white;
            background-color: black;
        }
    </style>
</head>
<body onload="random_no()">
    <div class="crdiv">
        <div class="invoice-heading-div">
            <h1>Invoice</h1><hr>
        </div>

        <div class="invoice-cstmr-dts">
            <form action="" method="POST">
            <script>
            function random_no(){
                var rno = Math.floor(1000000000 + Math.random() * 9000000000);
                document.getElementById('invno').value = rno;
            }
            </script>
            <p>Invoice No : <input  class="ctypetext2" type="text" name="invno" id="invno"></p>
            <div class="invoice-cstmr-dts-form">
            <h4>Customer Details</h4>
            <?php 
            $invocquery = "SELECT `cust_name` FROM `cstmrdb` WHERE `a_name` = '$a_uname'";
            $invocquery_ex = mysqli_query($conn,$invocquery);
            ?>
            <select class="ctypeselect" name="invcust_name" id="">
                <option value="" >Select</option>
                <?php while($invocquery_fetch = mysqli_fetch_array($invocquery_ex)){
                    echo '<option>' .$invocquery_fetch['cust_name']. '</option>';
                } ?>
            </select>
            <label for="">Or</label>
            <button class="ctypebutton2"><a href="../addcstmr.php"> New Customer</a> </button><br>
            <input class="ctypetext2" type="text" name="cust_accntno" id="" placeholder="Enter Account Number"><br>
            <input class="ctypebutton2" type="submit" name="submit1" value="Fetch">
            <?php
                if(isset($_POST['submit1'])){
                    $invoc_no = $_POST['invno'];
                    $cust_select = $_POST['invcust_name'];
                    $cust_accntno = $_POST['cust_accntno'];
                    $_SESSION['inv_no'] = $invoc_no;
                    $inv_csquery = "INSERT INTO `invdb1`(`invoice_id`, `cust_name`,`account_no`) VALUES ('$invoc_no','$cust_select' ,'$cust_accntno')";
                    $invcs_ex = mysqli_query($conn,$inv_csquery);
                    if($invcs_ex){
                        header('location:invadd.php');
                    }else {
                        echo "Not Successful";
                        
                    }

                }
            ?>  
        </div>
    </div></form>
    </div>
</body>
</html>
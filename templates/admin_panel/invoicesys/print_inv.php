<?php
session_start();
require '../conn.php';
require '../auser.php';
$inv_no =  $_SESSION['inv_no'];
$invdetf_query = "SELECT * FROM `invdb1` WHERE `invoice_id` = '$inv_no'";
$invdetf_exquery = mysqli_query($conn, $invdetf_query);
$invdetf_fetch = mysqli_fetch_array($invdetf_exquery);
$in_cust_name = $invdetf_fetch['cust_name'];
$invo_cust_det_query = "SELECT * FROM `cstmrdb` WHERE `cust_name` = '$in_cust_name'";
$invo_cust_det_exquery = mysqli_query($conn, $invo_cust_det_query);
$invo_cust_det_fetch = mysqli_fetch_array($invo_cust_det_exquery);
$fitem_query = "SELECT * FROM `inrec`";
$fitem_exquery = mysqli_query($conn, $fitem_query);
$inv_no =  $_SESSION['inv_no'];
$invdb_query = "SELECT * FROM `invdb` WHERE `invoice_id` = '$inv_no'";
$invdb_exquery = mysqli_query($conn, $invdb_query);
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
        .crdiv {
            margin: auto;
            box-shadow: none;
        }

        .invoice-cstmr-dts-l {
            color: black;
            float: left;
            margin-left: 20px;
            margin-bottom: 30px;

        }

        .invoice-cstmr-dts-l p {
            margin: 3px 3px 3px 3px;
            font-size: 12px;
        }

        .invoice-cstmr-dts-r {
            color: black;
            float: right;
            width: 30%;
        }

        .invoice-cstmr-dts-r p {
            margin: 3px 3px 3px 3px;
            font-size: 12px;
        }

        .invoice-cstmr-dts h4 {
            padding: 10px 10px 10px 10px;
        }

        .ctypetext {
            margin: 10px 0px 10px 10px;
            color: white;
            border-color: white;
            width: 20%;

        }

        .invoice-cstmr-dts-div-2 {
            clear: both;
            padding-bottom: 10 px;
        }

        .invoice-cstmr-dts-div-1 {
            clear: both;
            background-color: whitesmoke;
            color: black;
            margin-top: 20px;
        }

        .ctypetext {
            color: black;
            border-color: red;
        }

        .ctypebutton2 {
            background-color: #27374D;
            color: white;
        }

        .invoice-cstmr-dts-div-3 {
            height: 400px;
            background-color: white;
        }

        .invoice-div-f-r {
            float: right;
            margin-right: 30px;
        }

        .invoice-div-f-l {
            float: left;
            margin-right: 30px;
            background-color: whitesmoke;
        }

        .invoice-div-f-r p {
            margin: 3px 3px 3px 3px;
            font-size: 15px;
        }

        body {
            background-image: none;
        }

        .tablediv {
            width: auto;
            border: 0px solid red;
        }

        .tablediv table tr th {
            height: 30px;
            color: black;
            font-size: 13px;
            border: 1px solid black;
        }

        .tablediv table tr td {
            height: 30px;
            text-align: center;
            font-size: 13px;
            background-color: whitesmoke;

        }

        .del_btn {
            border: 0px solid red;
            background-color: lightcoral;
            height: 20px;
            width: 20px;
            cursor: pointer;
        }

        .del_btn:hover {
            box-shadow: 0px 0px 10px 1px black;
        }

        .cust_qty {
            width: 10%;
            background-color: transparent;
            border: 0px solid;
        }

        .invoice-div-f-r table td {
            font-weight: bold;
            font-size: 14px;
        }

        .invoice-div-f-r p {
            font-size: 13px;
        }

        .td1 {
            background-color: lavender;
        }

        .tablediv table {
            border: 1px black solid;
            border-top: 1px;
            border-left: 1px;
            border-right: 1px;
        }
    </style>
</head>

<body onload="date1()">
    <div class="crdiv">
        <div class="invoice-heading-div">
            <h1 style="text-align: center;">Organization Name</h1>
            <hr>
        </div>
        <div class="invoice-cstmr-dts-div">
            <div class="invoice-cstmr-dts-l">
                <h2>Invoice To:</h2>
                <?php
                echo "<p>" . $in_cust_name . "</p>";
                echo "<p>" . $invo_cust_det_fetch['comp_name'];
                "</p>";
                echo "<p>" . $invo_cust_det_fetch['cust_address'];
                "</p>";
                echo "<p>" . $invo_cust_det_fetch['cust_no'];
                "</p>";
                echo "<p>" . $invo_cust_det_fetch['cust_email'];
                "</p>";
                ?>
            </div>
            <div class="invoice-cstmr-dts-r">
                <p>Invoice no : <?php echo $inv_no ?></p>
                <p>Account No : <?php echo $invdetf_fetch['account_no'] ?></p>
                <p>Due Date : <?php echo $invdetf_fetch['due_date'] ?></p>
                <p>Issue Date : <?php echo $invdetf_fetch['issue_date'] ?></p>
            </div>
        </div>
        <div class="invoice-cstmr-dts-div-2">   
            <div class="tablediv">
                <table width="100%">
                    <tr>
                        <th>No</th>
                        <th>Item Name</th>
                        <th style="width:50px">Quantity</th>
                        <th>Tax</th>
                        <th>Price</th>
                    </tr>
                    <?php
                    $i = 1;
                    while ($invdb_fetch = mysqli_fetch_array($invdb_exquery)) {
                    ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo $invdb_fetch['item_name'] ?></td>
                            <td><?php echo $invdb_fetch['i_qty'] ?></td>
                            <td><?php echo $invdb_fetch['i_tax'] ?></td>
                            <td><?php echo $invdb_fetch['i_price'] ?></td>
                        </tr>
                    <?php
                        $i++;
                    }
                    ?>
                </table>
            </div>
        </div>
        <div class="invoice-cstmr-dts-div-3">
            <?php
            $total_pquery = "SELECT sum(`i_price`) as total_price FROM `invdb` WHERE `invoice_id` = '$inv_no'";
            $total_expquery = mysqli_query($conn, $total_pquery);
            $total_pfetch = mysqli_fetch_array($total_expquery);

            ?>
            <form action="" method="POST">
                <div class="invoice-div-f-r">
                    <table id="table1">
                        <tr>
                            <td>
                                <p> Sub Total : </p>
                            </td>
                            <td><?php echo $total_pfetch['total_price'] ?> Rupees</td>
                        </tr>
                        <tr>
                            <td>
                                <p>Tax : </p>
                            </td>
                            <td><?php echo $invdetf_fetch['tax'] ?> %</td>
                        </tr>
                        <tr>
                            <td>
                                <p>Discount : </p>
                                <hr>
                            </td>
                            <td><?php echo $invdetf_fetch['discount'] ?>
                                <hr>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Total : </p>
                                <hr>
                            </td>
                            <td><?php echo $invdetf_fetch['total'] ?> Rupees
                                <hr>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Deposit : </p>
                            </td>
                            <td><?php echo $invdetf_fetch['deposit'] ?> Rupees</td>
                        </tr>
                        <tr>
                            <td class="td1">
                                <p>Due : </p>
                            </td>
                            <td class="td1"><?php echo $invdetf_fetch['due'] ?> Rupees</td>
                        </tr>
                        <tr>
                            <td >
                                <form action="" method="POST">
                                    <input type="submit" class="cbutton" id="prtbtn" onclick="printbtn();" name="prt_btn" value="Print">
                                    <script>
                                        var prtbtn = document.getElementById('prtbtn');
                                        function printbtn() {
                                            document.getElementById('prtbtn').style.display = 'none';
                                            document.getElementById('backbtn').style.display = 'none';
                                            window.print();
                                        }
                                    </script>
                                    <?php
                                    if(isset($_POST['prt_btn'])){
                                        unset($_SESSION['inv_no']);
                                    }
                                    ?>
                                </form>
                            </td>
                            <form action="print_inv1.php" method="POST">
                            <td> <input type="submit" class="cbutton" id="backbtn"  name="" value="Back"></td>
                            </form>
                        </tr>
                    </table>

                </div>
            </form>
        </div>
    </div>
    </div>


</body>

</html
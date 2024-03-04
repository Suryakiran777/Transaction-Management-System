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
        .invoice-cstmr-dts-l {
            background-color: #27374D;
            color: white;
            float: left;
            width: 40%;

        }

        .invoice-cstmr-dts-r {
            background-color: #8696FE;
            color: white;
            float: right;
            width: 30%;
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
            height: 300px;
            background-color: #27374D;
            clear: both;
            padding-bottom: 10px;
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
    </style>
</head>
<script>
    function date1() {
        var date1 = new Date();
        var year = date1.getFullYear();
        var day = date1.getDay();
        var month = date1.getMonth();
        // const full_date = (day + '-' +month + "-" + year);
        const date = new Date()
        const result = date.toISOString().split('T')[0]
        document.getElementById('current_date').value = result;
    }
</script>

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
                
                <p>Due Date : <input class="ctypetext2" type="date" id="due_date"></p>
            </div>
        </div>
        <form action="" method="POST">
            <div class="invoice-cstmr-dts-div-1">
                <h2>ADD ITEMS</h2>
                <input style="width:40px" class="ctypetext" type="text" name="by_item_id" id="" placeholder="ID">
                <label for=""> OR </label>
                <select style="width: 350px;" class="ctypeselect" name="by_item_name" id="">
                    <option>Select Item Name</option>
                    <?php while ($fitem_fetch = mysqli_fetch_array($fitem_exquery)) {
                        echo "<option>" . $fitem_fetch['item_name'] . "</option>";
                    } ?>
                </select>
                <input class="ctypetext2" style="width: 50px; margin-left:0px" type="number" name="item_qty" id="" placeholder="QTY" required>
                <input class="ctypebutton2" type="submit" name="submit2" value="Add">
                <?php
                if (isset($_POST['submit2'])) {
                    $by_item_id = $_POST['by_item_id'];
                    $by_item_name = $_POST['by_item_name'];
                    $item_qty = $_POST['item_qty'];
                    if ($by_item_name == 'Select Item Name' and $by_item_id == '') {
                        echo "both are empty";
                    } else if ($by_item_name != 'Select Item Name') {
                        $fitem_query1 = "SELECT * FROM `inrec`WHERE `item_name` = '$by_item_name'";
                        $fitem_exquery1 = mysqli_query($conn, $fitem_query1);
                        $fitem_fetch1 = mysqli_fetch_array($fitem_exquery1);
                        $fitem_name = $fitem_fetch1['item_name'];
                        $fitem_price = $fitem_fetch1['cost'];
                        $fitem_qty = $fitem_fetch1['qty'];
                        $upd_qty = $fitem_qty - $item_qty;
                        $titem_price = $item_qty * $fitem_price;
                        if ($upd_qty <= -1) {
                        } else {
                            $invoc_add_query = "INSERT INTO `invdb`(`invoice_id`, `item_name`, `i_qty`, `i_price`) VALUES ('$inv_no','$fitem_name','$item_qty','$titem_price')";
                            $invoc_add_exquery = mysqli_query($conn, $invoc_add_query);
                            if ($invoc_add_exquery) {
                                $qty_update_query = "UPDATE `inrec` SET `qty`='$upd_qty' WHERE `item_name` = '$fitem_name'";
                                mysqli_query($conn, $qty_update_query);
                            } else {
                            }
                        }
                    } else {
                        echo "Insufficient Quantity";
                    }
                }
                ?>
            </div>
        </form>
        <div class="invoice-cstmr-dts-div-2">
            <iframe src="invoctable.php" frameborder="0" width="100%" height="100%"></iframe>
        </div>
        <div class="invoice-cstmr-dts-div-3">
            <?php
            $total_pquery = "SELECT sum(`i_price`) as total_price FROM `invdb` WHERE `invoice_id` = '$inv_no'";
            $total_expquery = mysqli_query($conn, $total_pquery);
            $total_pfetch = mysqli_fetch_array($total_expquery);

            ?>
            <script>
                function t_pricecal() {
                    const disc = Number(document.getElementById('disc_price').value);
                    const stotal = Number(document.getElementById('s_total').value);
                    const in_tax = Number(document.getElementById('in_tax').value);
                    const deposit_amount = Number(document.getElementById('deposit_amount').value);
                    
                    const stotal_1 = stotal;
                    const x = (stotal_1 * in_tax) / 100;
                    const y = x + (stotal);
                    const t_price = y - disc;
                    document.getElementById('t_price').value = t_price;
                    const due= parseFloat(t_price - deposit_amount);
                    document.getElementById('due').value = due;

                }
            </script>
            <form action="invaddm.php" method="POST">
            <div class="invoice-div-f-l">
            <p>Issue Date : <input readonly class="ctypetext2" name="issue_date" type="text" id="current_date"></p>
            <p>Due Date : <input class="ctypetext2" name="duedate" type="date" id="due_date" required></p>
            </div>
            <div class="invoice-div-f-r">
                <p> Sub Total : <input style="width:80px;margin-left:0px;" class="ctypetext2" type="text" disabled id="s_total" value="<?php echo doubleval($total_pfetch['total_price']); ?>"> Rupees</p>
                <p>Tax : <input id="in_tax" name="t_tax" style="background-color: whitesmoke;width:50px" class="ctypetext2" type="text" placeholder="In %"><label>%</label></p>
                <p>Discount : <input id="disc_price" onkeyup="t_pricecal()" style="background-color: whitesmoke;width:70px" class="ctypetext2" type="text" name="t_disc" id="" placeholder="in Rs"><label>Rs</label></p>
                <p>Total : <input readonly  name="t_amount" class="ctypetext2" id="t_price" type="text"> </p>
                <p>Deposit : <input id="deposit_amount" onkeyup="t_pricecal()" style="background-color: whitesmoke;width:70px" class="ctypetext2" type="text" name="t_deposit" id="" placeholder="in Rs"><label>Rs</label></p>
                <p>Due : <input readonly  class="ctypetext2" id="due" name="t_due" type="text" > 
                <input class="ctypebutton2" type="submit" name="submitval" value="Done">
                <?php
                ?>
            </div>
            </form>
        </div>
    </div>
    </div>
</body>

</html
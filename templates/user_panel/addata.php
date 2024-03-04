<!DOCTYPE html>
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
            background-color: #FEF9F9;
        }
        .addatadiv{
            border:0px solid red;
            width: 40%;
            float: left;
        }
        .data-table-div{
            border:0px solid red;
            width: 58%;
            float: right;
            height: 500px;
        }
    </style>
</head>
<?php
$conn = mysqli_connect("localhost","root","","addb");
$shopquery = "SELECT * FROM `shoprec`";
$shopres = mysqli_query($conn,$shopquery);

?>
<body>
    <div class="crdiv">
        <div class="addatadiv">
        <h1>Add Items</h1>
                 <form id="formID" method="post">
                    <div class="addinvenform">
                        <input type="text" name="item_name" placeholder="Enter Item Name" required><br>
                        <select name="shop_name" id="">
                            <?php
                            while($shopfetch = mysqli_fetch_array($shopres)){
                                echo "<option>" .$shopfetch['shop_name']."</option>";
                            }
                            ?>
                        </select>
                        <input type="number" name="qty" id="" placeholder="Enter Quantity" id="t_qty" required><br>
                        <input type="number" name="cost" placeholder="Enter Cost" id="i_cost" required><br>
                        <input type="submit" class="cbutton aitembtn" value="Add Item"  name="submit">
                    </div>
                 </form>
                 <?php
                 if(isset($_POST['submit'])){
                    $i_name = $_POST['item_name'];
                    $shop_name = $_POST['shop_name'];
                    $qty = $_POST['qty'];
                    $cost = $_POST['cost'];
                    $t_cost = $qty * $cost;
                    $conn = mysqli_connect("localhost","root","","addb");
                    $addquery = "INSERT INTO `inrec`(`s_name`, `item_name`, `qty`, `cost`, `total_cost`) VALUES ('$shop_name','$i_name','$qty','$cost','$t_cost')";
                    $addres = mysqli_query($conn,$addquery);
                 }
                 ?>
                 </div>
                <div class="data-table-div">
                 <iframe src="inventable.php" height="100%" width="100%" frameborder="0"></iframe>
                </div>
                </div>

</body>
</html>
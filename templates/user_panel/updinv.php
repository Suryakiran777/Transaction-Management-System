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
        body {
            background-image: none;
        }

        .addatadiv {
            border: 0px solid red;
        }
    </style>
</head>
<?php
$conn = mysqli_connect("localhost", "root", "", "addb");
$shopquery = "SELECT * FROM `inrec`";
$shopres = mysqli_query($conn, $shopquery);
?>

<body>
    <div class="addatadiv">
        <div class="rweldiv" style="float: none;" onclick="swiremnvback()">
            <div class="rweldivl">
                <img src="images/gback.png" width="50px">
            </div>
            <div class="rweldivr">
                <p style="font-size:12px;">Inventory</p>
            </div>
        </div>
        <h1>Remove Items</h1>
        <form id="formID" method="post">
            <div class="addinvenform">
                <select name="ritem_name" id="">
                    <option>Select</option>
                    <?php
                    while ($fetchshopres = mysqli_fetch_array($shopres)) {
                        echo "<option>" . $fetchshopres['item_name'] . "</option>";
                    }
                    ?>
                </select>
                <input type="submit" class="cbutton aitembtn" value="Fetch Item" name="submit">
        </form>
        <form method="POST">
            <?php
            if (isset($_POST['submit'])) {
                $conn = mysqli_connect("localhost", "root", "", "addb");
                $ritem_name = $_POST['ritem_name'];
                $itemquery = "SELECT * FROM `inrec` WHERE `item_name` = '$ritem_name'";
                $iresult = mysqli_query($conn, $itemquery);
                $ifetchquery = mysqli_fetch_array($iresult);
            }
            ?>
    </div>

    </div>
</body>

</html>
<?php
session_start();
require  '../conn.php';
require '../auser.php';
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/apanel.css">
    <link rel="stylesheet" href="../css/main.css">
    <script src="../js/ad_p.js" type="text/javascript"></script>
    <style>
        body {
            background-image: none;
            background-color: white;
        }

        .edit-ldiv {
            border: 1px solid red;
            height: 100%;
            width: 40%;
            float: left;
            clear: both;

        }

        .edit-ldiv h1 {
            margin-left: 10px;
        }

        .edit-ldiv p {
            margin: 10px 10px 10px 20px;
            word-wrap: break-word;
        }

        .edit-rdiv {
            border: 1px solid red;
            height: 100%;
            width: 58%;
            float: right;
        }

        .update-div {
            background-color: #27374D;
            color: white;
            height: 120px;
        }

        .ctypebutton2 {
            float: right;
            margin: 10px 10px 10px 10px;
        }
    </style>
</head>

<body>
    <div class="crdiv">
        <div class="edit-ldiv">
            <form method="POST" action="update.php">
                <?php
                $cname = $_POST['editbtn'];
                $edit_query = "SELECT * FROM `cstmrdb` WHERE `a_name` = '$a_uname' AND `cust_name`='$cname'";
                $edit_exquery = mysqli_query($conn, $edit_query);
                $edit_fetchq = mysqli_fetch_array($edit_exquery);
                ?>
                <h1>Update Due </h1>
                <p>Customer Name : <?php echo $edit_fetchq['cust_name']; ?> </p>
                <p> Mobile Number : <?php echo $edit_fetchq['cust_no']; ?></p>
                <p>Email Id : <?php echo $edit_fetchq['cust_email']; ?></p>
                <p>Due : <?php echo $edit_fetchq['due']; ?></p>

                <div class="update-div">

                    <p>Enter Due Value :-</p>
                    <input type="text" class="ctypetext2" name="due_name" hidden value="<?php echo $edit_fetchq['cust_name']; ?>">
                    <input class="ctypetext2" type="text" name="due_val" id="" placeholder="Enter Value Here"><br>
                    <input class="ctypebutton2" name="updsbt" type="submit" value="Update">
                </div>
            </form>
        </div>
        <div class="edit-rdiv">
            <iframe src="mduedb.php" frameborder="0" scrolling="no" height="100%" width="100%"></iframe>
        </div>
    </div>
</body>

</html>
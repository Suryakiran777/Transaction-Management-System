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
    <!-- For Sorting Select -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
    <!-- For Sorting Select  -->
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
    </style>
</head>
<script>
    $(document).ready(function() {
        $('select').selectize({  
            sortField: 'text'
        });
    });
</script>
<?php

$sshopquery = "SELECT `name` FROM `usrctrl` WHERE `a_name` = '$a_uname'";
$shopexquery = mysqli_query($conn, $sshopquery);

?>

<body>
    <div class="adduserdiv">
        <!-- Add User Div starts Here -->
        <div class="rdiv6-pagediv1-ldiv">
            <h2>Remove Employee</h2>
            <form method="POST">
                <select class="ctypeselect" name="u_sname">
                    <?php
                    while ($shopexfetch = mysqli_fetch_array($shopexquery)) {
                        echo "<option>" . $shopexfetch['name'] . "</option>";
                    }
                    ?>
                </select>
                <input class="cbutton" type="submit" value="Remove" name='submit'>
                <?php
                if (isset($_POST['submit'])) {
                    $u_sname = $_POST['u_sname'];
                    $u_addquery = "DELETE FROM `usrctrl` WHERE name='$u_sname'";
                    $u_exaddquery = mysqli_query($conn, $u_addquery);
                    echo 'Successfully Deleted';
                }
                ?>
            </form>
        </div>
        <!-- Add User Div ends Here -->
        <div class="rdiv6-pagediv1-rdiv">
            <iframe src="tusers1.php" id="inventorytable" frameborder="0"></iframe>
        </div>
    </div>
</body>

</html>
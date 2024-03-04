<?php
require 'conn.php';
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
        }

        .fdbdiv {
            height: auto;
            overflow: scroll;
        }

        .custfdbdiv {
            border: 0px red solid;
            height: auto;
            overflow: hidden;
            width: 100%;

        }

        .cardfdbdiv {
            float: left;
            border: 0px red solid;
            height: 200px;
            width: 290px;
            margin: 10px 20px 10px 10px;
            background-color: white;
            box-shadow: 0px 0px 20px 2px lavender;
        }

        .cardfdbdiv h2 {
            margin: 0px;
            padding: 10px 0px 5px 10px;
            background-color: aliceblue;
        }

        .cardfdbdiv h4 {
            margin: 5px 0px 5px 10px;
        }

        .cardfdbdiv p {
            margin: 0px 5px 0px 0px;
            font-size: 10px;
            margin: 10px 0px 5px 10px;
            font-weight: 600;
            color: darkred;
        }

        .disdiv {
            width: 94%;
            height: 100px;
            border: 0px solid red;
            margin-left: 5%;
            margin-top: 5px;
        }

        .disdiv p {
            word-wrap: break-word;
            font-size: 10px;
            margin: 0px;
            padding-right: 5px;
            font-weight: 600;
            color: black;
        }

        #timestamp-p {
            margin: 5px 0px 5px 10px;
            color: darkred;

        }
    </style>
</head>
<?php

?>

<body>

    <div style="height:500px" class="fdbdiv crdiv">
        <div class="custfdbdiv">
            <?php
            $fdb_query = "SELECT * FROM `fdbdb` ORDER BY `fid` desc";
            $fdb_exquery = mysqli_query($conn, $fdb_query);
             while ($fdb_fetch = mysqli_fetch_array($fdb_exquery)) {
                echo ' <div class="cardfdbdiv">';
                echo ' <h2>Rating : ' . $fdb_fetch['ex_rating'] . ' </h2>';
                echo '    <h4>Suggest : ' . $fdb_fetch['r_rating'] . ' </h4>';
                echo '   <p>Description : </p>';
                echo '    <div class="disdiv">';
                echo '       <p>' . $fdb_fetch['f_message'] . ' </p><p id="timestamp-p">Time Stamp : ' . $fdb_fetch['r_date'] . '</p></div>
                  </div>';
            }
            ?>
        </div>
    </div>
</body>

</html>
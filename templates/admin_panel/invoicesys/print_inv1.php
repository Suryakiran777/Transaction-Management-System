<?php
session_start();
require '../conn.php';
require '../auser.php';
?>
<head>
<link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/apanel.css">
    <script src="../js/ad_p.js" type="text/javascript"></script>
    <style>
        body{
            background-image: none;
            background-color: white;
        }
        .cbutton{
            margin: 10px 10px 10px 10px ;
            cursor:pointer;
        }
    </style>
</head>
<body>
    <h1>Redirect To :-</h1><hr>
    <a href="../invoicesys/index.php"><button  class="cbutton">Invoice Page</button></a><a href="../transac_hist/index.php"><button class="cbutton">Transaction History</button></a><hr>
</body>
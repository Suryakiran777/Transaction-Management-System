<?php
session_start();
require '../conn.php';
require '../auser.php';
require '../invoicesys/invque.php';
$u_name = $_SESSION['aLoginName'];
$query = "SELECT `name` as cname from `admctrl` where `name` = '$u_name'";
$res = mysqli_query($conn, $query);
$fetchres = mysqli_fetch_array($res);
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/apanel.css">
    <script src="js/ad_p.js" type="text/javascript"></script>
    <!-- Links for bootstrap and tables -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="js/ad_p.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css">
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
    <!-- Links for bootstrap and tables ends -->
    <style>
        body {
            background-image: none;
            background-color: #FEF9F9;
        }

        .table td {
            font-size: 10px;
            font-weight: 600;
        }

        .paginate_button {
            height: 30px;
            width: 55px;
            background-color: lavender;
            border-radius: 5px;
            color: white;
            border: 0;
            border-color: #D31027;
            transition-duration: 0.3s;
            font-family: 'Segoe Ui';
            font-size: 10px;
            box-shadow: 0px 0px 15px 1px grey;
        }

        .dataTables_length {
            display: none;
        }

        .datatables_filter input[TYPE="search"] {
            height: 30px;
            width: 230px;
            border: 0px solid darkred;
            margin: 20px;
            padding-left: 10px;
            font-family: 'segoe ui';
            background-color: transparent;
            border-top: 1px;
            border-left: 1px;
            border-right: 1px;
            margin: 0px;
            margin-bottom: 10px;
            margin-left: 10px;
            box-shadow: 0px 0px 15px 3px lavender;
        }
        #table-headings{
            background-color: #27374D;
            color: white;
            font-size: 10px;
        }
    </style>
</head>
<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>

<body>
    <div class="table_back">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr id="table-height">
                    <th id="table-headings">Customer Name</th>
                    <th id="table-headings">Mobile Number</th>
                    <th id="table-headings">Email</th>
                    <th id="table-headings">Due</th>
                </tr>
            </thead>
            <tbody>
                <?php

                $cust_query = "SELECT * from `cstmrdb` WHERE `a_name` = '$a_uname' AND `due` >0 " ;
                $cust_result = mysqli_query($conn, $cust_query);

                ?>
                <?php
                if (mysqli_num_rows($res) == 1) {
                    while ($custfetch = mysqli_fetch_array($cust_result)) {
                        echo "<tr>
                <td> " . $custfetch['cust_name'] . "</td><td>"
                            . $custfetch['cust_no'] . "</td><td>"
                            . $custfetch['cust_email'] . "</td><td>"
                            . $custfetch['due'] . "</td></tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>
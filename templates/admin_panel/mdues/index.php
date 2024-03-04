<?php
session_start();
require '../conn.php';
require '../auser.php';
$u_name = $_SESSION['aLoginName'];
$query = "SELECT `name` as cname from `admctrl` where `name` = '$u_name' ";
$res = mysqli_query($conn, $query);
$fetchres = mysqli_fetch_array($res);
$cust_query = "SELECT * from `cstmrdb` WHERE `a_name` = '$a_uname' and `due` >0  ";
$cust_result = mysqli_query($conn, $cust_query);
$cust_maxquery ="SELECT max(`due`) as max_due from `cstmrdb` WHERE  `a_name` = '$a_uname'" ;
$cust_maxresult = mysqli_query($conn, $cust_maxquery);
$cust_maxfetch = mysqli_fetch_array($cust_maxresult);
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/apanel.css">
    <link rel="stylesheet" href="../css/main.css">
    <script src="../js/ad_p.js" type="text/javascript"></script>
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
        body{
            background-image: none;
            background-color: white;
        }
        .ctypebutton2{
            background-color: lavender;
        }
        .mdue-sdiv {
            border: 0px solid red;
            height: 100px;
            width: 100%;
            background-color: #27374D;
            border-radius: 5px;
            box-shadow: 0px 0px 15px 1px #27374D ;
        }

        .mdue-sdiv h4 {
            color: white;
            padding-top: 5px;
            padding-bottom: 15px;
            margin-left: 10px;
        }

        label {
            color: white;
            margin-left: 20px;
        }

        .tablediv {
            height: 400px;
            border: 0px solid red;

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
        .datatables_filter input[TYPE='search']::placeholder{
            color: black;
        }
        .datatables_filter label{
            color: black;
        }
        .ctypetext2::placeholder{
            font-size: 10px;
        }
        #table-headings{
            background-color: #27374D;
        }
        .delbtn{
            height: 15px;
            margin: 0px 10px 0px 10px;
            border-radius: 50px;
            border-style: solid;
            border:0px;
            cursor: pointer;
            box-shadow: 0px 0px 7px 1px orangered;
            background-size: cover;
        }
    </style>
</head>
<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>

<body>
    <div style="width: 100%; height:500px" class="crdiv">
        <form action="" method="POST">
            <div class="mdue-sdiv">
                <h4>Customers Dues :</h4>
                <input class="ctypetext2" name="mdue_name" type="text" placeholder="Enter Name">
                <label for="mdue_from">From</label>
                <input style="width:13%;margin-left: 0px;" class="ctypetext2" name="mdue_from" type="text" placeholder="From Range">
                <label for="mdue_to">To</label>
                <input style="width:13%;margin-left: 0px;" value="<?php echo $cust_maxfetch['max_due'] ?>" class="ctypetext2" name="mdue_to" type="text" placeholder="To Range">
                <input class="ctypebutton2" type="submit" name="submit">
            </div>
            <?php
            if (isset($_POST['submit'])) {
                $mdue_name = $_POST['mdue_name'];
                $mdue_from = $_POST['mdue_from'];
                $mdue_to = $_POST['mdue_to'];
                if ($mdue_name != '') {

                    $cust_query = "SELECT * from `cstmrdb` WHERE `a_name` = '$a_uname' AND `cust_name` = '$mdue_name' ORDER BY `due`";
                    $cust_result = mysqli_query($conn, $cust_query);
                } else if ($mdue_from != '' and $mdue_to != '') {
                    $cust_query = "SELECT * from `cstmrdb` WHERE `a_name` = '$a_uname' and `due` BETWEEN '$mdue_from' AND '$mdue_to' ORDER BY `due` ";
                    $cust_result = mysqli_query($conn, $cust_query);
                } else if(($mdue_name !='' and $mdue_from != '' and $mdue_to != '')){
                    $cust_query = "SELECT * from `cstmrdb` WHERE `a_name` = '$a_uname' and `cust_name` = '$mdue_name' and `due` BETWEEN '$mdue_from' AND '$mdue_to' ORDER BY `due` ";
                    $cust_result = mysqli_query($conn, $cust_query); 
                } else {
                    $cust_query = "SELECT * from `cstmrdb` WHERE `a_name` = '$a_uname' and `due` >0  ";
                    $cust_result = mysqli_query($conn, $cust_query); 
                }
            }
            ?>
        </form>
        <!-- Table -->
        <div class="tablediv">
            <div class="table_back">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr id="table-height">
                            <th>id</th>
                            <th id="table-headings">Customer Name</th>
                            <th id="table-headings">Mobile Number</th>
                            <th id="table-headings">Email</th>
                            <th id="table-headings">Due</th>
                            <th id="table-headings"> Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($res) == 1) {
                            $i = 1;
                            while ($custfetch = mysqli_fetch_array($cust_result)) {
                                ?>
                                <tr>
                            <td><?php echo $i; ?></td>
                    <td> <?php echo  $custfetch['cust_name']; ?></td><td>
                    <?php echo $custfetch['cust_no']; ?></td><td>
                                    <?php echo $custfetch['cust_email'];?> </td><td>
                                    <?php echo $custfetch['due'];?> </td><td>
                                        <form action="edit.php" method="POST">
                                    <button class='delbtn' name="editbtn" value="<?php echo $custfetch['cust_name']; ?>">Edit</button></form></td></tr>
                                <?php
                                $i++;
                            } 
                        }
                        ?>
                        <?php
                        if(isset($_POST['editbtn'])){
                            $del_btn = $_POST['editbtn'];
                        }
                        ?>
                        </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
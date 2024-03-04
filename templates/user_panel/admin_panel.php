<?php
session_start();
require 'conn.php';
require 'auser.php';
require './invoicesys/invque.php';
$loginname = $_SESSION['aUserName'];
$query = "SELECT COUNT(`name`) AS total FROM `usrctrl` WHERE a_name = '$loginname'";
$result = mysqli_query($conn, $query);
$fetch = mysqli_fetch_array($result);
$nusers = $fetch['total'];
//---------------------------------------
// for total Customers
$custquery = "SELECT COUNT('cust_name') AS total_cust FROM `cstmrdb`";
$custres = mysqli_query($conn, $custquery);
$custfetch = mysqli_fetch_array($custres);
$ncust = $custfetch['total_cust'];

// for total Inventory
$inquery = "SELECT  *,sum(`qty`) AS total_inv, sum(`cost`*`qty`) as total_worth FROM `inrec`";
$inres = mysqli_query($conn, $inquery);
$invfetch = mysqli_fetch_array($inres);
$ninv = $invfetch['total_inv'];
$tw_items = $invfetch['total_worth'];
$invenpname = 'inventable.php';
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/apanel.css">
    <script src="js/ad_p.js" type="text/javascript"></script>
    <style>
        body {
            background-color: white;
            background-image: none;
        }
    </style>
</head>

<body>
    <div class="mbox">
        <!-- Left Div -->
        <div class="ldiv ">
            <h2 style="text-align: center;">Admin Panel</h2>
            <div class="prodiv">
                <img src="images/profilepic1.png" height="150px" width="150px">
            </div>
            <p id="admin_name"><?php echo $_SESSION['aLoginName'];  ?></p>
            <div class="cbtndiv">
                <p>Quick Services</p>
                <!--  Custom buttons-->
                <div class="cbutton1">
                    <button onclick="manageuserback();">Manage Users</button>
                </div>
                <div class="cbutton1">
                    <button>Manage Dues</button>
                </div>
                <div class="cbutton1">
                    <button>Transactions</button>
                </div>
                <div class="cbutton1">
                    <button>Feedbacks</button>
                </div>
                <div class="cbutton1">
                    <button onclick="logout()">LogOut</button>
                </div>

            </div>
        </div>
        <!-- Script For Logout -->

        <!-- Empty Div -->
        <div class="vrdiv">
            <!-- Leave it Empty -->
        </div>
        <!-- Main Right Div -->
        <div class="mrdiv">
            <div class="hbox ">
                <h1 class="anfadein" style="color:white;text-align: center; margin:0px 0px 0px 0px">Ease Transact </h1><br>
            </div>
            <!-- Stats Div -->
            <div style="width: 70%;" class="rdiv1 crdiv " id="rdivstats">
                <div class="weldiv">
                    <div class="lweldiv">
                        <h1>Welcome</h1>
                    </div>
                    <div class="rweldiv" onclick="swser()">
                        <div class="rweldivl">
                            <img src="images/go front.png" width="50px">
                        </div>
                        <div class="rweldivr">
                            <p>Services</p>
                        </div>
                    </div>
                </div>
                <div class="welrow1">
                    <div class="trackbox  tbox1">
                        <h2 style="color:darkred">Total Transaction Done :</h2>
                        <p><?php echo $trnxs_fetch_query3['total_transac'] ?> R/s</p>
                    </div>
                    <div class="trackbox tbox2" onclick="">
                        <h2 style="color:darkolivegreen">Total Inventory :</h2>
                        <p style="margin:5px 5px 5px 5px;"><?php echo $ninv ?> Items</p>
                        <p style="color:darkred;margin:5px 5px 5px 5px; font-size:10px">Worth of <?php echo $tw_items ?> R/s</p>
                    </div>
                </div>
                <div class="welrow1 tboxr2">
                    <div class="welrow1-col1">
                        <div class="trackbox  tbox3">
                            <h2>Active Employees : <?php echo $nusers; ?></h2>
                        </div>
                        <div class="trackbox  tbox3">
                            <h2>Active Customers : <?php echo $ncust; ?></h2>
                        </div>
                    </div>
                    <?php
                    $due_tquery = "SELECT sum(`due`) as total_due ,COUNT(`cust_name`) as total_cust FROM `cstmrdb` WHERE `a_name`= '$a_uname' AND `due` >0 ";
                    $due_texquery = mysqli_query($conn, $due_tquery);
                    $due_tfquery = mysqli_fetch_array($due_texquery);
                    ?>
                    <div class="trackbox tbox4">
                        <h2 style="color:brown">Total Dues in Rupees :</h2>
                        <p style="margin:5px 5px 5px 5px"><?php echo $trnxs_fetch_query1['total_due'] ?> R/s</p>
                        <h2 style="color:darkslategray">Active Due's</h2>
                        <p><?php echo $trnxs_fetch_query2['total_cust'] ?> Dues </p>
                    </div>
                </div>
            </div>
            <!-- Services Div -->
            <div style="width: 70%;"  class="rdiv crdiv" id="rdivservices">
                <div class="weldiv">
                    <div class="lweldiv">
                        <h1>Services</h1>
                    </div>
                    <div class="rweldiv" onclick="swint()">
                        <div class="rweldivl">
                            <img src="images/goback.png" width="40px" style="margin-top: 5px;margin-left: 5px;">
                        </div>
                        <div class="rweldivr">
                            <p>Intro</p>
                        </div>
                    </div>
                </div>
                <div class="serdiv">
                    <!-- Services Row1 starts Here -->
                    <div class="serdivr1">
                        <!-- Services Row1 starts Here -->
                        <!-- custom service button starts here -->
                        <div class="cserbtn" onclick="swinvfor()">
                            <div class="cserimg">
                                <img src="images/inven.png" alt="" height="100%" width="100%">
                            </div>
                            <h4>Inventory</h4>
                            <p>view and manage your Inventory Here</p>
                        </div>
                        <!-- custom service button ends here -->
                        <!-- custom service button starts here -->
                        <div class="cserbtn" onclick="manageuserfor()">
                            <div class="cserimg">
                                <img src="images/users.png" alt="" height="80%" width="100%">
                            </div>
                            <h4>Manage Employee </h4>
                            <p>view and manage your Users Here</p>
                        </div>
                        <!-- custom service button ends here -->
                        <!-- custom service button starts here -->
                        <div class="cserbtn" onclick="transac_hist_for()">
                            <div class="cserimg">
                                <img src="images/history.png" alt="" height="100%" width="100%">
                            </div>
                            <h4>Transaction History</h4>
                            <p></p>
                        </div>
                        <!-- custom service button ends here -->
                        <!-- custom service button starts here -->
                        <div class="cserbtn" onclick="managecstmrfor()">
                            <div class="cserimg">
                                <img src="images/cdb.png" alt="" height="80%" width="100%">
                            </div>
                            <h4>Customers DB</h4>
                            <p>view and manage Customer's Data</p>
                        </div>
                        <!-- custom service button ends here -->
                    </div>
                    <!-- Services Row1 ends Here -->
                    <!-- Services Row2 starts Here -->
                    <div class="serdivr1">
                        <!-- Services Row1 starts Here -->
                        <!-- custom service button starts here -->
                        <div class="cserbtn" onclick="mduesfor()">
                            <div class="cserimg">
                                <img src="images/dues.png" alt="" height="80%" width="100%">
                            </div>
                            <h4>Manage Dues</h4>
                            <p>view and manage AP here</p>
                        </div>
                        <!-- custom service button ends here -->
                        <!-- custom service button starts here -->
                        <div class="cserbtn" onclick="tddbfor()">
                            <div class="cserimg">
                                <img src="images/todo.png" alt="" height="100%" width="100%">
                            </div>
                            <h4>TODO Lists</h4>
                            <p>Manage Tasks Here</p>
                        </div>
                        <!-- custom service button ends here -->
                        <!-- custom service button starts here -->
                        <div class="cserbtn" onclick="fdbfor()">
                            <div class="cserimg">
                                <img src="images/feedback.png" alt="" height="80%" width="100%">
                            </div>
                            <h4>Feedback's</h4>
                            <p>view and manage Feedbacks</p>
                        </div>
                        <!-- custom service button ends here -->
                        <!-- custom service button starts here -->
                        <div class="cserbtn">
                            <div class="cserimg">
                                <img src="images/alert.png" alt="" height="70%" width="100%">
                            </div>
                            <h4>Alerts</h4>
                            <p>view and manage Alerts</p>
                        </div>
                        <!-- custom service button ends here -->
                    </div>
                    <!-- Services Row2 ends Here -->
                </div>

            </div>
            <!-- Services Div Ends Here -->
            <div class="rdiv3 crdiv" id="rdivinven">

                <div class="invoptns ">
                    <div class="invtextdiv">
                        <p>Inventory Options</p>
                    </div>
                    <div class="invbtnsdiv">
                        <button class="cbutton invenbspace mleft10" onclick="swiaddnvfor();mintransx();">Add Items</button>
                        <button class="cbutton invenbspace" onclick="swiremnvfor()">Remove Items</button>
                        <button class="cbutton invenbspace">Update Items</button>
                    </div>
                </div>
                <div class="rweldiv" onclick="swinvback();mintransx();">
                    <div class="rweldivl">
                        <img src="images/gback.png" width="50px">
                    </div>
                    <div class="rweldivr">
                        <p>Services</p>
                    </div>
                </div>

                <div class="invtable">
                    <h1>Inventory</h1>
                    <hr>
                    <iframe height="100%" frameborder="0" width="100%" src="inventable.php"></iframe>
                </div>
            </div>
            <div class="rdiv4 crdiv" id="rdivaddinven">
                <div class="rldiv4">
                    <div class="rweldiv" style="float: none;height:30px;margin:0px 0px 0px 0px;" onclick="swiaddnvback()">
                        <div class="rweldivl">
                            <img src="images/gback.png" width="30px">
                        </div>
                        <div class="rweldivr">
                            <p style="font-size:12px;">Inventory</p>
                        </div>
                    </div>
                    <iframe src="addata.php" width="500px" frameborder="0" scrolling="no"></iframe>
                </div>
            </div>
            <div class="rdiv5 crdiv" id="rdivreminven">
                <div class="rldiv4">
                    <div class="rweldiv" style="float: none;" onclick="swiremnvback()">
                        <div class="rweldivl">
                            <img src="images/gback.png" width="50px">
                        </div>
                        <div class="rweldivr">
                            <p style="font-size:12px;">Inventory</p>
                        </div>
                    </div>
                    <iframe src="reminvdata.php" frameborder="0" scrolling="yes"></iframe>
                </div>
            </div>
            <div class="rdiv6 crdiv" id="rdivusers">
                <div class="rdiv6-hdiv">
                    <div class="rdiv6-hdiv-ldiv">
                        <div class="rweldiv" onclick="manageuserback()">
                            <div class="rweldivl">
                                <img src="images/gback.png" width="50px">
                            </div>
                            <div class="rweldivr">
                                <p>Services</p>
                            </div>
                        </div>
                    </div>
                    <div class="rdiv6-hdiv-rdiv">
                        <script>
                            function radioprogress() {
                                var radio1 = document.getElementById('auserbtn');
                                var radio2 = document.getElementById('ruserbtn');
                                var radio3 = document.getElementById('muserbtn');
                                var adddiviframe = document.getElementById('usrframe');
                                if (radio1.checked) {
                                    adddiviframe.src = "addusr.php"
                                }
                                if (radio2.checked) {
                                    adddiviframe.src = "remuser.php";
                                }
                                if (radio3.checked) {
                                    adddiviframe.src = "index.php";
                                }
                            }
                        </script>

                        <form>
                            <input type="radio" onclick="radioprogress()" checked name="adduser_radio" id="auserbtn">Add User
                            <input type="radio" onclick="radioprogress()" name="adduser_radio" id="ruserbtn">Remove User
                            <input type="radio" onclick="radioprogress()" name="adduser_radio" id="muserbtn">Manage User
                        </form>

                    </div>
                </div>
                <div class="rdiv6-pagediv1" id="add_usrdiv">
                    <iframe id="usrframe" src="addusr.php" style="height:100%;width:100%" id="inventorytable" scrolling="no" frameborder="0"></iframe>
                </div>
            </div>
            <div class="rdiv7 crdiv" id="cstmr_db">
                <div class="rdiv7-hdiv">
                    <div class="ridv7-hdiv-ldiv">
                        <div class="rweldiv" onclick="managecstmrback()">
                            <div class="rweldivl">
                                <img src="images/gback.png" width="50px">
                            </div>
                            <div class="rweldivr">
                                <p>Services</p>
                            </div>
                        </div>
                        <div class="rdiv7-hdiv-rdiv">
                            <script>
                                function radioprogress1() {
                                    var addcstmr = document.getElementById('acstmrbtn');
                                    var remcstmr = document.getElementById('rcstmrbtn');
                                    var updcstmr = document.getElementById('mcstmrbtn');
                                    var cstmrframe = document.getElementById('cstmrframe');
                                    if (addcstmr.checked) {
                                        cstmrframe.src = "addcstmr.php";
                                    }
                                    if (remcstmr.checked) {
                                        cstmrframe.src = "remcstmr.php";
                                    }
                                    if (updcstmr.checked) {
                                        cstmrframe.src = "updcstmr.php";
                                    };
                                }
                            </script>
                            <form>
                                <input type="radio" onclick="radioprogress1()" checked name="addcstmr_radio" id="acstmrbtn">Add Customer
                                <input type="radio" onclick="radioprogress1()" name="addcstmr_radio" id="rcstmrbtn">Remove Customer
                                <input type="radio" onclick="radioprogress1()" name="addcstmr_radio" id="mcstmrbtn">Manage Customer
                            </form>
                        </div>

                    </div>

                </div>
                <div class="rdiv-framediv">
                    <iframe id="cstmrframe" src="addcstmr.php" height="100%" width="100%" frameborder="0" scrolling="no"></iframe>
                </div>
            </div>
            <div class="rdiv8 crdiv" id="fdb">
                <div class="rdiv8-hdiv">
                    <div class="rdiv8-hdiv-ldiv">
                    </div>
                    <div class="rdiv8-hdiv-rdiv">
                        <div class="rweldiv" onclick="fdbback()">
                            <div class="rweldivl">
                                <img src="images/gback.png" width="50px">
                            </div>
                            <div class="rweldivr">
                                <p>Services</p>
                            </div>
                        </div>
                    </div>
                </div>

                <iframe src="fdbviewform.php" scrolling="no" height="100%" width="100%" frameborder="0"></iframe>
            </div>
            <div class="rdiv9 crdiv" id="todo_db">
                <div class="rweldiv" style="height: 30px;" onclick="tddbback()">
                    <div class="rweldivl">
                        <img src="images/gback.png" width="30px">
                    </div>
                    <div class="rweldivr">
                        <p style="margin:1px 5px 1px 5px">Services</p>
                    </div>
                </div>
                <iframe src="todo" height="100%" width="100%" frameborder="0" scrolling="no"></iframe>
            </div>
            <div class="rdiv10 crdiv" id="mdues">
                <div class="rweldiv" style="height: 30px;margin:0px 0px 0px 0px" onclick="mduesback()">
                    <div class="rweldivl">
                        <img src="images/gback.png" width="30px">
                    </div>
                    <div class="rweldivr">
                        <p style="margin:1px 5px 1px 5px">Services</p>
                    </div>
                </div>
                <iframe src="transac_hist/index1.php" height="100%" width="100%" frameborder="0" scrolling="no"></iframe>
            </div>
        <div class="rdiv11 crdiv" id="transac_hist">
        <div class="rweldiv" style="height: 30px;margin:0px 0px 0px 0px" onclick=" transac_hist_back()">
                    <div class="rweldivl">
                        <img src="images/gback.png" width="30px">
                    </div>
                    <div class="rweldivr">
                        <p style="margin:1px 5px 1px 5px">Services</p>
                    </div>
                </div>
                <iframe src="transac_hist/index.php" height="100%" width="100%" frameborder="0" scrolling="yes"></iframe>
        </div>
            <!-- rdiv2 -->
            <div class="rdiv2" id = "min_transacdiv">
                <p class="rdiv2-h-p">Recent Transactions</p>
                <div class="rtnxsdiv">
                        <table>
                            <tr>
                                <th><p>Customer</p></th>
                                <th><p>Amount</p></th>
                            </tr>
                            <?php
                            while ($rec_tnxs = mysqli_fetch_array($trnxs_exquery)){

                                ?>
                                <tr><td><p><?php echo $rec_tnxs['cust_name'];  ?></p></td>
                                <td><p><?php echo $rec_tnxs['due'];  ?></p></td></tr>
                                <?php

                            }
                            ?>
                        </table>
                </div>
            </div>
        </div>
    </div>


    <!-- Bottom DIV -->
    <div class="bdiv">
    </div>
    </div>
</body>

</html>
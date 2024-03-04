<?php
session_start();
    require '../conn.php';
    require '../auser.php';
    require '../nusers.php';
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/apanel.css">
    <script src="../js/ad_p.js" type="text/javascript"></script>
    <style>
        body{
            background-image: none;
            background-color: white;
        }
        .todo-div{
            height: 600px;
            border: 0px solid red;
        }
        .todo-div-sbar{
            height: 80px;
            border: 0px red solid;
            border-radius: 5px;
            background-color: #27374D;
        }
        .todo-div-sbar p {
            margin:7px 10px 10px 20px;
            color: white;
            font-family: 'Segoe ui';
            font-weight: 500;

        }
        .todo-div-sbar-l{
            float: left;
            height: 100%;
            width: 100%;
            border: 0px solid red;
        }
        .todo-div-sbar-r{
            float: right;
            border: 1px;
            width: 20%;
            border: 0px solid red;
            height: 100%;
        }
        .todo-div-page-div{
            clear: both;
            border: 0px solid red;
            overflow: scroll;
            height: 400px;

        }
        .todo-div-page-task{
            border: 0px solid red;
            height: 50px;
            margin:10px 1% 10px 1%;
            background-color: #27374D;
            box-shadow: 0px 0px 15px 1px #526D82 ;
            border-radius: 25px;
            width: 98%;
            color: white;

        }
        .todo-div-page-task-id{
            border: 0px solid red;
            width: 10%;
            float: left;
            height: 100%;
        }
        .todo-div-page-task-name{
            border: 0px red solid;
            float: left;
            width:59% ;
            height: 70%;
            margin-top: 8px;
            margin-bottom: 8px;
            background-color: white;
            border-radius: 20px;
            cursor:default;

        }
        .todo-div-page-task-username{
            border: 0px red solid;
            float: left;
            width:15% ;
            height: 70%;
            margin-top: 8px;
            margin-bottom: 8px;
            background-color: lavender;
            border-radius: 20px;
            margin-left: 5px;
            cursor:default;

        }
        .todo-div-page-task-username p{
            margin: 7px 20px 5px 20px;
            color:black;
            font-size: 10px;
            
        }
        .todo-div-page-task-name p {
            margin: 7px 20px 5px 20px;
            color:black
        }
        .todo-div-page-task-del{
            border: 0px red solid;
            height: 100%;
            float: right;
            width:15% ;
        }
        .todo-div-page-task-del button{
            height: 35px;
            width: 35px;
            margin: 7px 30px 7px 30px;
            border-radius: 50px;
            border-style: solid;
            border:0px;
            cursor: pointer;
            box-shadow: 0px 0px 7px 1px orangered;
            background-image: url("../images/delicon.png");
            background-size: cover;
        }
        p{
            margin-left:20px;
            font-weight: 600;
            font-size: 15px;
            
        }

    </style>
</head>
<body>
 <?php
 ?>
    <form action="" method="POST">
        <div style="width: 100%; height: 400px;" class="crdiv">
            <div class="todo-div">
                <!-- Search bar -->
                <div class="todo-div-sbar">
                    <div class="todo-div-sbar-l">
                        <p>ADD TASK</p>
                        <input style="width:50%" class="ctypetext2" type="text" name="todo_text" placeholder="Enter Your Task Here">
                        <select style="width:20%" name="todo_select" class="ctypetext2">
                        <?php
                            while($nusers_names = mysqli_fetch_array($nusers_exquery)){
                                echo '<option>'.$nusers_names['name'].' </option>';
                            }
                        ?>
                            <option>all</option>
                        </select>
                        <input class="ctypebutton2" type="submit" name="submittask" value="Add Task">
                    </div>
                </div>
                <?php
                if(isset($_POST['submittask'])){
                    $todo_text = $_POST['todo_text'];
                    $todo_select = $_POST['todo_select'];
                    $todo_query = "INSERT INTO `todo_db`(`task`, `u_name`, `a_name`) VALUES ('$todo_text','$todo_select','$a_uname')";
                    $todo_exquery =  mysqli_query($conn,$todo_query);
                }
                ?>
                <h4 style="margin-left: 10px;">Pending Tasks</h4><hr>
                <!-- Sbar Ends Here -->
                <div class="todo-div-page-div">
                    
                    <?php
                    $i = 1;
                    $todo_fquery = "SELECT * FROM `todo_db` where a_name='$a_uname'";
                    $todo_fexquery = mysqli_query($conn,$todo_fquery);
                    while($todo_fetchq = mysqli_fetch_array($todo_fexquery)){ ?>
                       <div class="todo-div-page-task">
                       <div class="todo-div-page-task-id">
                         <p name="id"><?php echo $i;?></p></div>
                        <div class="todo-div-page-task-name">
                        <p><?php echo $todo_fetchq['task'];?></p> </div>
                        <div class="todo-div-page-task-username">
                        <p><?php echo $todo_fetchq['u_name'];?></p> </div>
                        <div class="todo-div-page-task-del">
                        <button class="delbtn" name="del_task" value="<?php echo $todo_fetchq['id']; ?>"></button>
                       </div></div>
                    <?php $i++; }
                                        if(isset($_POST['del_task'])){
                                            $id = $_POST['del_task'];
                                            $todo_dquery = "DELETE FROM `todo_db` WHERE `id` = '$id' ";
                                            $todo_dexquery = mysqli_query($conn,$todo_dquery);
                                        } ?>
                    

                    
                </div>
            </div>
            

        </div>
    </form>
</body>
</html>
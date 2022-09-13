<?php

    session_start();
    require("log_check.php");
    log_chk();
    $_SESSION['page'] = 'p_chat';
    require("connect.php");
    include("navigation_bar.php");

    $_SESSION['cnt'] = 0;
    if(isset($_SESSION['gname']))
    {
        unset($_SESSION['gname']);
        unset($_SESSION['tname']);
    }

    //_______________CONVERT COOKIE VALUES IN SESSION AND DESTROY COOKIES_____________
    @extract($_POST);
    
    if(isset($_COOKIE['id2']) and log_ret())
    {
        $_SESSION['id2'] = $_COOKIE['id2'];    
        @setcookie("id2","",time()-360);
        $_SESSION['q'] = mysqli_query($con,"select u_name,mail from main_table where id=".$_SESSION['id2']);
        $_SESSION['q'] = mysqli_fetch_array($_SESSION['q']);
    }
    else if(!(isset($_SESSION['id2']))) {
        echo "<script> window.location.replace('find.php'); </script>";
    }

    if(isset($send)) {
        if(isset($msg)) {
            trim($msg);
            if($msg!='') {
                mysqli_query($con,"insert into chat (id,rid,msg) values(".$_SESSION['id'].", ".$_SESSION['id2']." , '".$msg."')");
            }
        }
    }
?>
<html>
<head>
    <title> ShareCal &nbsp;|&nbsp; Chat </title>
    <link rel="stylesheet" href="../css/chat_personal.css">
    <style>
        body{
            background-image: url(../img/PSX_20200219_172602.jpg);
        }
    </style>
    
    <script type="text/javascript" src="jquery-3.4.1.min.js"> </script>
    <script type="text/javascript">
        //---------------THIS IS USED TO AVOID PROMPT BOX THAT ASKS FOR RESUBMISSION OF FORM DATA-----------
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }

        //___________________REFRESHING CHAT CONTENT BY LOADING chat_load.php FREQUEMTLY_____________________
        $(document).ready(function() {
            $('#chat').load('chat_load.php');
            refresh();
        });

        function refresh() {
            setTimeout(function() {
                $('#chat').load('chat_load.php');
                refresh();
            }, 1500);

        }
        //________________________SCROLL CHATTING DIV TO THE BOTTOM____________________________
        function updateScroll() {
            var i = document.getElementById("chat");
            i.scrollTop = i.scrollHeight;
        }

        //____________________SENDING MESSAGE AND STORING IN DB______________________
        function msg_sent(msg) {
            if (msg.value != "") {
                document.cookie = "pmsg=" + msg.value;
                msg.value = "";
                $('#snd').load('send_msg.php');
                $('#chat').load('chat_load.php');

            } else {
                alert(" Message is empty ! ");
            }
        }
    </script>
</head>
<body>
    <div class='panel'>
        <span class="s1"><?php echo $_SESSION['q'][0]; ?></span>
        <div style="overflow:auto; max-height:60%;">
            <?php
                echo "<span class='s2' style='opacity:0.9;' > Email address </span>
                        <span class='s2'> ".$_SESSION['q'][1]." </span>";
                            
                echo "</div>";
            
            ?>
        </div>

        <div class='cont'>

            <div id='chat' class='chat'> </div> <!-- DIVISION FOR LOAD CHAT FREQUENTLY -->

            <form name='frm' action="chat_personal.php" method="post" style="padding:0px; margin:0px;">

                <input type="text" name='msg' id='msg' class='msg' rows='1' placeholder='Type message...' autocomplete="off" autofocus required />
                <!--<input type='submit' name='send' id='send' value='send' class='send' />-->
                <input type='button' name='send' id='send' value='send' onclick='msg_sent(msg)' class='send' style='width:100px;' />

            </form>

        </div>

        <div id='snd'></div> <!-- DIVISION FOR SEND MSG USING send_msg.php and this division -->
</body>
</html>
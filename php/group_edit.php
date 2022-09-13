<?php
    session_start();
    require("log_check.php");
    log_chk();
    $_SESSION['page'] = 'g_edit';
    require("connect.php");
    include("navigation_bar.php");

    //_______________CONVERT COOKIE VALUES IN SESSION AND DESTROY COOKIES_____________
    extract($_POST);
    if(isset($_COOKIE['gname']))
    {
        $_SESSION['tname'] = $_COOKIE['gname'];
        $tmp = explode('_',$_SESSION['tname']);
        $_SESSION['gname'] = $tmp[1];
        unset($tmp);
        @setcookie("gname","",time()-360);
    }
    else if(!isset($_SESSION['gname'])){
        echo "<script> window.location.replace('groups.php'); </script>";
    }
    
    $_SESSION['mem_detail'] = mysqli_query($con,"select permission,notify from group_details where id=".$_SESSION['id']." and group_name='".$_SESSION['tname']."'");
    $_SESSION['mem_detail'] = mysqli_fetch_array($_SESSION['mem_detail']);
?>
<html>

<head>
    <title> ShareCal &nbsp;|&nbsp; Edit </title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="../css/group_edit.css">
    <style>
        .panel{
            background-image: url(../img/PSX_20200219_172602.jpg); 
        }
    </style>
</head>

<script type="text/javascript" src="jquery-3.4.1.min.js"> </script>
<script type="text/javascript">
    //_______________REFRESHING CHAT CONTENT BY LOADING chat_load.php FREQUEMTLY_________________
    $(document).ready(function() {
        $('#chat').load('chat_load.php');
        refresh();
    });

    function refresh() {
        setTimeout(function() {
            $('#chat').load('chat_load.php');
            refresh();
        }, 3000);
    }
    //____________________SENDING MESSAGE AND STORING IN DB______________________
    function msg_sent(msg) {
        if (msg.value != "") {
            document.cookie = "msg=" + msg.value;
            msg.value = "";
            $('#snd').load('send_msg.php');
            $('#chat').load('chat_load.php');
            updateScroll();
        } else {
            alert(" Message is empty ! ");
        }
    }
    //________________________SCROLL DIV TO THE BOTTOM____________________________
    function updateScroll() {
        var i = document.getElementById("chat");
        i.scrollTop = i.scrollHeight;
    }

    function fun1(x) {
        var a = x.id;
        x.id = x.innerHTML;
        x.innerHTML = a;
    }

    //--------------------------------EVENT REMINDERS ON/OFF-----------------------------------
    function notify(x) {
        if (x == 'yes') {
            if (confirm(" off/disable event reminders for this group ? ")) {
                document.cookie = "notify=" + 'no';
                $('#snd').load('send_msg.php');
            }
        } else {
            if (confirm(" on/enable event reminders for this group ? ")) {
                document.cookie = "notify=" + 'yes';
                $('#snd').load('send_msg.php');
            }
        }
    }

    //-----------------------------------------------------------------------------------
    function left() {
        if (confirm(" WARNING : All conversations and group events will be unavailable for you...\n\n Want to leave this group ?")) {
            if (confirm(" Do you want to remove all your events from this group ? ")) {
                window.location.replace("send_msg.php?left=1");
            } else {
                window.location.replace("send_msg.php?left=2");
            }
        }
    }

    function del() {
        if (confirm("    ...WARNING...\n\n -> All messages and group events will be deleted \n\n -> All group members will be removed including you \n\n    ?? Want to delete this group ??\n")) {

            window.location.replace("send_msg.php?del=1");

        }
    }

    function chat_() {
        window.location.href = 'chat_group.php';
    }

</script>

<body>

    <div class='panel'>
        <span class="s1"><?php echo $_SESSION['gname']; ?></span>
        <div style="overflow:auto; max-height:355px;">
            <?php
                echo "<span class='s2' style='opacity:0.9;' > Members";
                $mem = mysqli_query($con,"select count(id) from group_details where group_name='".$_SESSION['tname']."'");
                $mem = mysqli_fetch_array($mem);
                echo " &nbsp;(".$mem[0].")";
                echo "</span>";
                $q = mysqli_query($con,"select id from group_details where group_name='".$_SESSION['tname']."'");
                while($row = mysqli_fetch_array($q))
                {
                    $q2 = mysqli_query($con,"select u_name,mail from main_table where id=".$row[0]);
                    $q2 = mysqli_fetch_array($q2);
                    echo "<span class='s2' onmouseover='fun1(this)' onmouseout='fun1(this)' id='".$q2[1]."' > $q2[0] </span>";
                }
                
                echo "</div>
                      <span class='s2' style='opacity:0.9;'> Options </span>";
            
                echo "<button class='s2' onclick='chat_()'> Chat </button>";
            
                if($_SESSION['mem_detail']['permission']==1 or $_SESSION['mem_detail']['permission']==2){
                    echo "<button class='s2' onclick=window.location.href='show_group_events.php'; > Events </button>";
                }
                if($_SESSION['mem_detail']['notify']=='yes'){
                    echo "<button class='s2' onclick=notify('yes') > Event Reminders (on) </button>";
                }   
                else{
                    echo "<button class='s2' onclick=notify('no') > Event Reminders (off) </button>";
                }
                if($_SESSION['mem_detail']['permission']==1){
                    echo "<button class='s2' onclick='del()'> Delete Group </button>";
                }
                else{
                    echo "<button class='s2' onclick='left()'> Leave Group </button>";
                }
            ?>

        </div>

        <div class='cont'>
            <center>
                <table>

                    <tr>
                        <form action="send_msg.php" method="post" name="frm">
                            <td>
                                <input type=text name='gname' placeholder=' enter new name ' required />
                            </td>
                            <td colspan="2">
                                <input type="submit" name="rename" value=" Rename Group " />
                            </td>
                        </form>
                    </tr>
                    <tr>
                        <form action="send_msg.php" method="post" name="frm">

                            <td> <input type="email" name="_mail" id="add_mail" placeholder=' email of user ' class="mail" required /></td>

                            <td> <input type=submit name="m_add" value=" Add participant " class="send" /> </td>

                            <td> <input type=submit name="m_rem" value=" Remove participant " class="send" /> </td>
                        </form>
                    </tr>
                    <tr>
                        <td style="text-align:center;" colspan="3">
                            <?php if(isset($_SESSION['msg']))
                                    {  echo $_SESSION['msg']; unset($_SESSION['msg']); }
                                    else{ echo "&nbsp;&nbsp;"; }
                            ?>
                        </td>
                    </tr>
                </table>
                <div id='div1'>
                </div>
            </center>
        </div>
</body>
</html>
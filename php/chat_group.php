 <?php
    session_start();
    require("log_check.php");
    log_chk();
    $_SESSION['page'] = 'g_chat';
    require("connect.php");
    include("navigation_bar.php");
    $_SESSION['cnt'] = 0;
    //____________ CONVERT COOKIE VALUES IN SESSION AND DESTROY COOKIES ____________
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
        header("location:groups.php");
    }

    $_SESSION['mem_detail'] = mysqli_query($con,"select permission,notify from group_details where id=".$_SESSION['id']." and group_name='".$_SESSION['tname']."'");
    $_SESSION['mem_detail'] = mysqli_fetch_array($_SESSION['mem_detail']);
    
    //--------------------------------- SEND MESSAGE USING FORM --------------------------------
    if(isset($send)){
        if(isset($msg)){
            trim($msg);
            if($msg!=''){
                mysqli_query($con,"insert into group_chat (msg,id,group_name) values('".$msg."',".$_SESSION['id'].", '".$_SESSION['tname']."')");
                echo "<script> window.location.replace('chat_group.php'); </script>";
            }
        }
    }
?>
<html>

<script type="text/javascript" src="jquery-3.4.1.min.js"> </script>
<script type="text/javascript">
    //--------------------THIS IS USED TO AVOID PROMPT BOX THAT ASKS FOR RESUBMISSION-------------------
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }

    //_______________REFRESHING CHAT CONTENT BY LOADING chat_load.php FREQUEMTLY_________________
    $(document).ready( () => {
        $('#chat').load('chat_load.php');
		var i = document.getElementById("chat");
        i.scrollTop = i.scrollHeight;
        refresh();
    });

    function refresh() {
        setInterval( () => {
            $('#chat').load('chat_load.php');
			var i = document.getElementById("chat");
        }, 2000);
    }
    //____________________SENDING MESSAGE AND STORING IN DB______________________
    function msg_sent(msg) {
        if (msg.value != "") {
            document.cookie = "msg=" + msg.value;
            msg.value = "";
            $('#snd').load('send_msg.php');
            $('#chat').load('chat_load.php');
            var i = document.getElementById("chat");
			i.scrollTop = i.scrollHeight;
        } 
		else {
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

    function g_edit() {
        window.location.href = 'group_edit.php';
    }


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
        if (confirm("   ...WARNING...\n\n -> All messages and group events will be deleted \n\n -> All group members will be removed including you \n\n   ?? Want to delete this group ??\n")) {

            window.location.replace("send_msg.php?del=1");

        }
    }

</script>

<head>
    <title> ShareCal &nbsp;|&nbsp; <?php echo $_SESSION['gname']; ?> </title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="../css/chat_group.css">
</head>

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
            
                if($_SESSION['mem_detail']['permission'] == 1){
                    echo "<button class='s2' onclick='g_edit()' > Edit Group </button>";
                }
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

            <div id='chat' class='chat'> </div> <!-- DIVISION FOR LOAD CHAT FREQUENTLY -->

            <form name='frm' action="chat_group.php" method="post" style="padding:0px; margin:0px;">

                <input type="text" name='msg' id='msg' class='msg' rows='3' placeholder=' Message...' autofocus autocomplete="off" required />
                <!--<input type='submit' name='send' id='send' value='send' class='send' /> -->

                <input type='button' name='send' id='send' value='send' onclick='msg_sent(msg)' class='send' style='width:100px;' />

            </form>
        </div>
        <div id='snd'></div> <!-- DIVISION FOR SEND MSG USING send_msg.php and this division -->
</body>
</html>
<?php
    session_start(); 
    require("log_check.php");
    log_chk();
    require("connect.php");
    $_SESSION['page'] = 'create_groups';
    include("navigation_bar.php");
    extract($_POST);

	if(!isset($_SESSION['nmails']))
		$_SESSION['nmails']=1;
	
	if(isset($add_mail))
		$_SESSION['nmails']++;
	elseif(isset($rem_mail))
		$_SESSION['nmails']--;
		
    if(isset($submit))
    {
        $res = mysqli_query($con,"select * from group_details where group_name = 'group_".$group_name."_".$_SESSION['id']."'");
        if(mysqli_num_rows($res) == 0)
        {   
            $tmp = true;
            $a = explode(',',$mails);
            foreach($a as $val)
            {
                if($val != "")
                {
                    $val = trim($val);
                    $r = mysqli_query($con,"select * from main_table where mail='".$val."'");
                    if(mysqli_num_rows($r)==0)
                    {
                        $tmp = false;
                    }
                }
            }
            if($tmp)
            {
                mysqli_query($con,"insert into group_details ( group_name , id , permission , notify ) values ( 'group_".$group_name."_".$_SESSION['id']."' , ".$_SESSION['id']." , 1 , 'yes' ) ");
                $a = explode(',',$mails);
                foreach($a as $val)
                {
                    if($val != "")
                    {
                        $val = trim($val);
                        $r = mysqli_query($con,"select id from main_table where mail='".$val."'");
                        $r = mysqli_fetch_array($r);
                        mysqli_query($con,"insert into group_details ( group_name , id , permission , notify ) values ( 'group_".$group_name."_".$_SESSION['id']."' , ".$r['id']." , 2 , 'yes' ) ");
                    }
                }
                echo "<script> window.location.replace('groups.php'); </script>";
            }
            else
            {
                $_SESSION['msg'] = " One of emails you entered is not registered on site... ";
            }
        }
        else
        {
            $_SESSION['msg'] = " You have already created group with same name... ";
        }
    }
?>

<html>
<script type="text/javascript">
    //--------------------THIS IS USED TO AVOID PROMPT BOX THAT ASKS FOR RESUBMISSION-------------------
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }

    function block(e) {
        var k = e.keyCode;

        return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 45 || (k >= 48 && k <= 57));

    }

</script>

<head>
    <title> ShareCal &nbsp;|&nbsp;Create Group</title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="../css/create_group.css">
    <style>
        body{
            background-image: url(../img/13.jpg);
        }
    </style>
</head>
<body>
    <center>
        <table>
            <form name="frm" method="post" action="create_group.php">
                <tr>
                    <th style="font-weight:100; font-size:25px;"> Create Group </th>
                </tr>

                <!------------------------------ G R O U P - N A M E --------------------------------->
                <tr>
                    <td colspan='2'> Group Name </td>
                </tr>
                <tr>
                    <td>
                        <input type=text id="i1" name="group_name" required autofocus autocomplete="off" onkeypress="return block(event)" onpaste="return false;" ondrop="return false;" />
                    </td>
                </tr>

                <!----------------------------- M E M B E R S --------------------------------->
				<tr>
                    <td> Mails of participants </td>
                </tr>
				<?php
					for($i=1 ; $i<=$_SESSION['nmails'] ; $i++){
						echo "<tr>
							    <td> <input type=text name='mail".$i."' id='mails".$i."' placeholder=' email address ' required> </td>
							  </tr>";
					}
				?>
                <!------------------------------ S U B M I T --------------------------------->
                <tr>
                    <td style="text-align:center;">
                        <input style="text-align:center;" type="submit" value=" create " name="submit" />
                    </td>
                </tr>

            </form>
			<form name="frm2" action="create_group.php" method="post">

					<tr><td>
						<input type='submit' value=' + ' name='add_mail' >
					</td></tr>
					<tr><td>
						<input type='submit' value=' - ' name='rem_mail' >
					</td></tr>
			</form>
        </table>
        <?php if(isset($_SESSION['msg'])){ echo "<h3>".$_SESSION['msg']."</h3>"; unset($_SESSION['msg']); } ?>
    </center>
	<br><br><br><bR><bR>	
</body>
</html>
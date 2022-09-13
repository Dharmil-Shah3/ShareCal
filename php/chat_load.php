<html>

<head>
	<link rel="stylesheet" href="../css/chat_load.css">
</head>

</html>

<?php
    session_start();
    require("connect.php");
    require("log_check.php");

    if( $_SESSION['page']=='p_chat' )
    {
		$lmid = mysqli_query($con,"select max(mid) from chat where (id=".$_SESSION['id']." and rid=".$_SESSION['id2'].") or (id=".$_SESSION['id2']." and rid=".$_SESSION['id'].")");
		$lmid = mysqli_fetch_array($lmid);
		if(!isset($_SESSION['lmid'])){ $_SESSION['lmid']=0; }
		
			//==================== FETCHING ALL MESSAGES FROM CHAT TABLE ========================
			$res = mysqli_query($con,"select * from chat where (id=".$_SESSION['id']." and rid=".$_SESSION['id2'].") or (id=".$_SESSION['id2']." and rid=".$_SESSION['id'].")");
			$q = "update chat set seen=1 where rid=".$_SESSION['id']." and id=".$_SESSION['id2'];
			mysqli_query($con,$q);
			echo "<table>";
			$_SESSION['cd'] = 0;
			while(@$row = mysqli_fetch_array($res))
			{
				if($_SESSION['cd'] != date("d / m / Y",strtotime($row['mtime']))){
					$_SESSION['cd'] = date("d / m / Y",strtotime($row['mtime']));
					if($_SESSION['cd'] == date("d / m / Y",time()))
					{
						echo "<tr><td class='dt'> Today </td></tr>";
					}
					else{
						echo "<tr><td class='dt'> ".$_SESSION['cd']." </td></tr>";
					}
				}
				echo "<tr>";
				echo "<td> <p class='";
				if($row['id'] == $_SESSION['id']){ echo "me"; } 
				else{ echo"you"; }
				echo "' >".$row['msg']." <font class='time'>";
				echo date("h:i A", strtotime($row['mtime']));
				if($row['id'] == $_SESSION['id'] and $row['seen']==1){ echo "<font color='dodgerblue'> ✓</font>"; }
				elseif($row['id'] == $_SESSION['id']){ echo "<font color='#fff'> ✓<font>"; }
				echo " </font></p></td></tr>";
			}
			echo "</table>";
		
    }

    /*============================ GROUP CHAT =============================*/

    else if( $_SESSION['page']=='g_chat' )
    {
        //____________________FETCHING ALL MESSAGES FROM GROUP TABLE_______________________
        $res = mysqli_query($con,"select * from group_chat where group_name='".$_SESSION['tname']."' and mtime >= (select time from group_details where id=".$_SESSION['id']." and group_name='".$_SESSION['tname']."') order by mtime");
        
        //$res2 = mysqli_query($con , "SELECT id,time from group_details where group_name='".$_SESSION['tname']."'");
        
        echo "<table>";
        $_SESSION['tmp'] = '';
        $_SESSION['cd'] = 0;
        //$creator = 0; //------For displaying group creater
        
        while(@$row = mysqli_fetch_array($res))
        {
            /*echo "<tr><td> hi </td></tr>";
            //-------------- USER ADDED MESSAGE -----------------
            $temp = -1;
            while($row2 = mysqli_fetch_array($res2))
            {
                echo "<tr><td>Executed</tr></td>";
                //print_r($row2);
                $temp++;
                if($creator++ == 0)
                {
                    $tmp = mysqli_query($con,"select u_name from main_table where id=".$row2['id']);
                    $tmp = mysqli_fetch_array($tmp);
                    echo "<tr><td class='dt'> $tmp[0] created group (".date('d / m / Y',strtotime($row2['time'])).") </td></tr>";
                    $row2['id'] = -1;
                }
                else if($row2['id'] != -1 and $row2['time'] <= $row['mtime'])
                {
                    $tmp = mysqli_query($con,"select u_name from main_table where id=".$row2['id']);
                    $tmp = mysqli_fetch_array($tmp);
                    echo "<tr><td class='dt'> $tmp[0] is added </td></tr>";
                    $row2['id'] = -1;
                }
            }*/
            
            //------------- DISPLAYING DATES IN CHAT --------------
            if($_SESSION['cd'] != date("d / m / Y",strtotime($row['mtime'])))
            {
                $_SESSION['cd'] = date("d / m / Y",strtotime($row['mtime']));
                echo "<tr><td class='dt'> ".$_SESSION['cd'];
                if($_SESSION['cd'] == date("d / m / Y",time()))
                {
                    echo " ( Today )";
                }
                echo "</td></tr>";
            }
            
            echo "<tr>";
            echo "<td> <p class='";
            if($row['id'] == $_SESSION['id'])
            { echo "me'>"; } 
            else
            { echo"you'>"; }
            
            if($_SESSION['id'] != $row['id'])
            {
                $tmp = mysqli_query($con,"select u_name from main_table where id=".$row['id']);
                $tmp = mysqli_fetch_array($tmp);
                if($_SESSION['tmp'] != $tmp[0])	
                {
                    $_SESSION['tmp'] = $tmp[0];
                    echo "<font style='color:limegreen; font-size:14px; font-weight:none;'>".$_SESSION['tmp']."</font><br>";
                }
            }
            else
            {
                $_SESSION['tmp'] = '';
            }
            echo $row['msg']." <font class='time'>";
            echo date("h:i A",strtotime($row['mtime']));
            echo " </font> </p></td></tr>";
        }
        echo "</table>";
    }
    if($_SESSION['cnt'] == 0)
    {
        echo "<script> 
                updateScroll(); 
            </script>";
        $_SESSION['cnt'] = 1;
    }
?>
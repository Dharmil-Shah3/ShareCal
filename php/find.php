<?php
    @extract($_REQUEST);
    session_start(); 
    require("log_check.php");
    log_chk();
    $_SESSION['page'] = 'find';
    include("navigation_bar.php");
?>
<html>

<head>
    <title> ShareCal &nbsp;|&nbsp; Contacts </title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="../css/find.css">
    <style>
        body{
            background-image: url(../img/top-view-photo-of-people-near-wooden-table-3183150.jpg);
        }
    </style>
</head>

<body>
    <center>
        <div class="frm">
            <form name="frm" method="post" action="find.php" style="padding:20px;">

                <input type="search" name="fn" id="fn" placeholder=" username or email " value="<?php if(isset($fn)){echo $fn;} ?>" required autofocus>
                <input type="submit" value=" Find " name="find" />

            </form>
        </div>
    </center>
</body>

<script type="text/javascript">
    function set_id(x) {
        document.cookie = "id2=" + x.name;
    }
</script>

</html>
<?php
    require("connect.php");

    if(isset($find))
    {       
        $res = mysqli_query($con, "select id, u_name, mail from main_table where mail='".$fn."' or u_name like'".$fn."%'");
        
        echo "<br><center>
              <form method='post' name='f' action='chat_personal.php' style='padding:5px;'>
              <table> 
                <tr>
                    <th col span='2'> Result </th>
                </tr>";
        if(mysqli_num_rows($res) > 0)
        {
            while($row = mysqli_fetch_array($res))
            {
                if($row['id'] != $_SESSION['id'])
                {
                    echo "<tr>";
                    echo "<td>".$row['u_name']."</td>";
                    echo "<td> 
                    <input type='submit' name='".$row['id']."' value=' Start chat ' class='chat' onclick='set_id(this, un_".$row['id'].")' onsubmit='set_id(this,un_".$row['id'].")'> 

                    <input type='hidden' name='un_".$row['id']."' value='".$row['u_name']."' /> </td>";
                    echo "</tr>";
                }
            }
        }
        else{ echo "<tr><td colspan='2'> NO match found for ' ".$fn." ' </td></tr>"; }
        echo "</table></form></center>";
    }

    //=============================== H I S T O R Y =======================================

    $res = mysqli_query($con ,"SELECT DISTINCT rid FROM chat WHERE id=".$_SESSION['id']." UNION SELECT DISTINCT id FROM chat WHERE rid=".$_SESSION['id']);

    echo "<br><center> <div class='history'><table> <tr><th colspan='2'> History </th></tr>";

    if(mysqli_num_rows($res)>0)
    {
		$i=0;
		while($arr = mysqli_fetch_array($res))
		{
			$res2 = mysqli_query($con,"SELECT max(mid) FROM chat WHERE (id=".$_SESSION['id']." and rid=".$arr[0].") or (rid=".$_SESSION['id']." and id=".$arr[0].")");
			$res2 = mysqli_fetch_array($res2);
			$j[$i][0] = $res2[0];
			$j[$i][1] = $arr[0];
			$i++;
		}
		rsort($j);
		//print_r($j);
        echo "<form method='post' name='f2' action='chat_personal.php'>";
              
        foreach($j as $val)
        {
			$name = mysqli_query($con , "select u_name from main_table where id=".$val[1]);
			$name = mysqli_fetch_array($name);
			$q = "select count(seen) from chat where rid=".$_SESSION['id']." and id=".$val[1]." and seen=0";
			$unread = mysqli_query($con,$q);
			$unread = mysqli_fetch_array($unread);
			echo "<tr>";
			echo "<td>".$name[0];
			if($unread[0] > 0){ echo "  <span class='un'>".$unread[0]." </span>";}
			echo "</td>";
			echo "<td>

				<input type='submit' name='".$val[1]."' value=' Chat ' class='chat' onclick='set_id(this)' onsubmit='set_id(this)'>

				</td>";
			echo "</tr>";
        }
    }
    else {
            echo "<tr><td colspan='2'> No conversation yet..</td></tr>";
    }
    echo "</table></form></center>";
?>
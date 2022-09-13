<?php
    session_start();
    require("log_check.php");
    log_chk();
    $_SESSION['page'] = 'show_group_events';
    require("connect.php");
    
    if(isset($_COOKIE['gname']))
    {
        $_SESSION['tname'] = $_COOKIE['gname'];
        $tmp = explode('_',$_SESSION['tname']);
        $_SESSION['gname'] = $tmp[1];
        unset($tmp);
        @setcookie("gname","",time()-360);
    }
    
    include("navigation_bar.php");
    if(isset($_SESSION['gname']))
    {
        $res = mysqli_query($con,"select * from group_events where group_name='".$_SESSION['tname']."' order by event_add_date desc");
    }
    else{
        if(isset($_SESSION['tname'])){ unset($_SESSION['tname']); }
        echo "<script> window.location.replace('groups.php'); </script>";
    }
    if(isset($_COOKIE['e_id']))
    {
        $res = mysqli_query($con,"select * from group_events where event_id=".$_COOKIE['e_id']);
        setcookie("e_id","",time()-360);
    }
    
    ?>
<html>
<head>
    <link href="main.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/show_group_events.css">
    <style>
        body{
            background-image: url(../img/14.jpg);
        }
    </style>
    <title> <?php echo $_SESSION['gname']; ?> &nbsp;|&nbsp; Group Events </title>
</head>

<body>    
    <center>
        <form name="frm" method="post" action="add_event.php">
            <table style="<?php if(mysqli_num_rows($res) > 6){echo "margin:5vh 0 5vh 0;";}?>">
                    
            <?php        
            echo "<tr style='opacity:1;'>";
            if(mysqli_num_rows($res) == 0){
                echo "<th> No event is saved yet! </th>";
            }
            else{
                echo "
                <th> Added on </th>
                <th> Date/Time </th>
                <th> Creator </th>
                <th> Subject </th>
                <th style='width:50%;'> Details </th>
                <th> Edit </th>
                <th> Delete </th>";
            }
            echo "</tr>";
            while($row = mysqli_fetch_array($res)){
                echo "<tr>";
                
                echo "<td> ".date("d-m-Y",strtotime($row['event_add_date']))."
                        <br> ".date("l",strtotime($row['event_add_date']))."
                        <br> ".date("h:i A",strtotime($row['event_add_date']))." </td>";
                                
                echo "<td> ".date("d-m-Y",strtotime($row['event_date_time']))."
                        <br> ".date("l",strtotime($row['event_date_time']))."
                        <br> ".date("h:i A",strtotime($row['event_date_time']))." </td>";

                $tmp = mysqli_query($con,"select u_name from main_table where id=".$row['id']);
                $tmp = mysqli_fetch_array($tmp);
                
                echo "<td> $tmp[0] </td>";
                
                echo "<td class='sub'> ".$row['event_subject']." </td>";
                
                echo "<td class='desc'> ".$row['event_description']." </td>";
                
                $i = explode('_',$_SESSION['tname']);
                if($row['id'] == $_SESSION['id'] or $_SESSION['id'] == $i[2])
                {
                        echo "<td>
                <a name='".$row['event_id']."' onclick='set_id(this)' href='add_group_event.php'> Update </a>
                        </td>";
                    echo "<td> 
                <a name='".$row['event_id']."' onclick='ask(this)' class='del' > Delete </a>
                        </td>";
                }
                else {
                    echo "<td> --- </td>";
                    echo "<td> --- </td>";
                }
                
                echo "</tr>";
            }
            ?>
        </table>
        </form>
    </center>
</body>

<script type="text/javascript">
    function set_id(x) {
        document.cookie = "gevent_id=" + x.name;
    }

    function ask(x) {
        if (confirm(" You want to delete that event ? ")) {
            set_id(x);
            window.location.replace("delete_event.php");
        }
    }
</script>
</html>
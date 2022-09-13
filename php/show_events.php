<?php
    session_start();
    require("log_check.php");
    log_chk();
    $_SESSION['page'] = 'show_events';
    include("navigation_bar.php");
    require("connect.php");
    $res = mysqli_query($con,"select * from events where id=".$_SESSION['id']." order by event_add_date desc");
    if(isset($_COOKIE['e_id'])){
        $res = mysqli_query($con,"select * from events where event_id=".$_COOKIE['e_id']);
        setcookie("e_id","",time()-360);
    }
    ?>
<html>
<head>
    <link href="main.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/show_events.css">
    <style>
        body{
            background-image: url(../img/13.jpg);
        }
    </style>
    <title> ShareCal &nbsp;|&nbsp; Events </title>
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
                <th> Event time </th>
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
                
                echo "<td class='sub'> ".$row['event_subject']." </td>";
                
                echo "<td class='desc'> ".$row['event_description']." </td>";
            
                $tmp = $row['event_id'];
                echo "<td> 
                <a onclick='set_id($tmp)' href='add_event.php'> Update </a>
                      </td>";
                
                echo "<td> 
                <a onclick='ask($tmp)' class='del' > Delete </a>
                      </td>";
                echo "</tr>";
            }
            ?>
        </table>
        </form>
    </center>

</body>

<script type="text/javascript">
    function set_id(x) {
        document.cookie = "event_id=" + x;
    }

    function ask(x) {
        if (confirm(" You want to delete that event ? ")) {
            set_id(x);
            window.location.replace("delete_event.php");
        }
    }
</script>
</html>
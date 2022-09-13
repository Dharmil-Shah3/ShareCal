<?php
    
    session_start();
    require("log_check.php");
    log_chk();
    require("connect.php");
    @extract($_POST);
    $_SESSION['page'] = "calendar";
    include("navigation_bar.php");
    
    date_default_timezone_set('Asia/Kolkata');

    /*while($row = mysqli_fetch_array($res)){
        echo "<br>".$row['event_date_time'];
        $tmp = date("d",strtotime($row['event_date_time']));
        echo "  ->  ".$tmp;
    }*/

    //___________________________WORKING WITH DATE AND ETC___________________________
    if(isset($submit)){
        $month = strtotime($mn);
    }
    else{
        $month = date(time());
    }

    //echo "<br>month = ".$month;
    //echo "<br>this = ".date("1-m-Y",$month);
    $m = date("1-m-Y",$month);
    $m = date("w",strtotime($m));
    $days_in_month = date("t",$month);
    //echo "<br>m=".$m."<br>dim=".$days_in_month;
    
?>
<html>
<head>
    <title> ShareCal | Calendar</title>
    <link href="main.css" rel="stylesheet">
    <link href="icons/77_Essential_Icons/FONT/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/calendar.css">
    <style>
        body{
            background-image: url(../img/abstract-art-background-blur-220072.jpg);
        }
    </style>
</head>
<body>
    <div class="cal">
        <center>
        <div><span class="mon"><span class="icon-Calendar"></span> <?php echo strtoupper(date("F Y",$month)); ?> </span></div>

        <form action="calendar.php" method="post" name="frm">
            <input type="month" name="mn" id="mn" value="<?php echo date("Y-m",$month); ?>">
            <span class="icon-Search"></span><input type="submit" name="submit" value=" Show ">
        </form>

        <!-- _________________SHOWING CALANDER TABLE USING PHP___________________-->
        <table>

            <tr>
                <th>SUNDAY</th>
                <th>MONDAY</th>
                <th>TUESDAY</th>
                <th>WEDNESDAY</th>
                <th>THURSDAY</th>
                <th>FRIDAY</th>
                <th>SATURDAY</th>
            </tr>

            <?php
        $t2=1;
        
        $query = "select * from events where id=".$_SESSION['id']." and date_format(event_date_time, '%Y-%m') = '".date("Y-m", $month)."' order by event_date_time";
        $res = mysqli_query($con, $query);
            
        for($i=0 ; $t2<=$days_in_month ; $i++)
        {
            echo "<tr>";
            for($j=1 ; $j<8 and $t2<=$days_in_month ; $j++)
            {
                if($m>0)
                {
                    $m--;
                    echo "<td></td>";
                    continue;
                }
                $color = "style='background-color: none; color: #000;'";
                
                /*if(mysqli_num_rows($res) > 0)
                {
                    $tmp = mysqli_fetch_array($res);
                    $tmp = date("d",strtotime($row['event_date_time']));
                    while($row = mysqli_fetch_array($res))
                    {
                        $tmp = date("d",strtotime($row['event_date_time']));
                        echo " $tmp - $t2 ";
                        if($tmp == $t2)
                        {
                            $color = "style='background-color:seagreen; color:white;'";
                            unset($tmp);
                        }
                        else{
                            continue;
                        }
                        break;
                    }
                }*/
                
                echo "<td class='yes tooltip' id='".$t2.date("-m-Y",$month)."' onclick='set_date(this)' ".$color.">".$t2."
                        <span class='tooltiptext'> Click to add events </span>
                        </td>";
                $t2++;
            }
            echo "</tr>";
        }
        ?>
        </table>
        <div class='events'>
            <span style="max-width:94%; min-width:94%;"> Month Events </span>
            <table class="e">
            <?php

                $res = mysqli_query($con,"select * from events where id=".$_SESSION['id']." and date_format(event_date_time,'%Y-%m') = '".date("Y-m",$month)."' order by event_date_time");

                if(mysqli_num_rows($res) > 0){
                    while($row = mysqli_fetch_array($res)){
                        echo "<tr>";
                        $tmp = $row['event_id'];
                        echo "<td class='dt' onclick='set($tmp)' style='font-size:20px;'>";
                        unset($tmp);
                        echo date("jS M ( l )",strtotime($row['event_date_time']));
                        echo "<br>[ ".$row['event_subject']." ]";
                        echo "</td>";
                        echo "</tr>";
                    }
                }
                else{
                    echo "<tr> <td style='color:#fff;'> Not events </td> </tr>";
                }
            ?>
            </table>
        </div>
        </center>
    </div>
</body>
<script type="text/javascript">
    function set_date(x) {
        document.cookie = "e_date=" + x.id;
        location.assign("add_event.php");
    }

    function set(x) {
        document.cookie = "e_id=" + x;
        window.location.href = 'show_events.php';
    }
</script>
</html>
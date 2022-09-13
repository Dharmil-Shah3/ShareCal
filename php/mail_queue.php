<?php
    session_start();
    include("connect.php");
    include("log_check.php");

        date_default_timezone_set('Asia/Kolkata');
        
        $time2 = date_create(strtotime(time()));
        date_add($time2 , date_interval_create_from_date_string("-1 minute"));
        
        $time1 = date_create(strtotime(time()));
        
        $time1 = date_format($time1 , "Y-m-d H:i:00");
        $time2 = date_format($time2 , "Y-m-d H:i:00");

        $res = mysqli_query($con,"select * from mail_queue where mail_send_datetime between '".$time2."' and '".$time1."' and status=1");
        
        //----------------------------------------------------------------------------------
        echo "<table class='t1'>
            <tr><th colspan='3' style='background-color: #008cba;'> Mails sent in last 1 minute </th></tr>
            <tr><th>id</th><th>sending time</th><th>status</th></tr>";
        
        if(mysqli_num_rows($res) > 0)
        {
            while($row = mysqli_fetch_array($res))
            {
                echo "<tr><td>".$row['mail_id']."</td>";
                echo "<td>".$row['mail_send_datetime']."</td>";
                echo "<td>".$row['status']."</td></tr>";
            }
        }
        else{
            echo "<tr><td colspan='3'> No mails sent in last 1 minute </td></tr>";
        }
        echo "</table>";
        //----------------------------------------------------------------------------------
        $time2 = date_create(strtotime(time()));
        date_add($time2 , date_interval_create_from_date_string("+1 minute"));
        
        $time2 = date_format($time2 , "Y-m-d H:i:00");
        
        $res = mysqli_query($con,"select * from mail_queue where mail_send_datetime between '".$time1."' and '".$time2."' and status=0");
        //----------------------------------------------------------------------------------
        echo "<table class='t2'>
            <tr><th colspan='3' style='background-color: #008cba;' > Mails to be sent in next 1 minute </th></tr>
            <tr><th>id</th><th>sending time</th><th>status</th></tr>";
        
        if(mysqli_num_rows($res) > 0)
        {   
            while($row = mysqli_fetch_array($res))
            {
                echo "<tr><td>".$row['mail_id']."</td>";
                echo "<td>".$row['mail_send_datetime']."</td>";
                echo "<td>".$row['status']."</td></tr>";
            }
        }
        else{
            echo "<tr><td colspan='3'> No mails to be sent in next 1 minute </td></tr>";
        }
        echo "</table>";
        //----------------------------------------------------------------------------------
        $res = mysqli_query($con,"select * from mail_queue where mail_send_datetime < '".$time1."' and status=0");
        
        echo "<table class='t3'>
            <tr><th colspan='3' style='background-color: #008cba;'> Mails failed to be sent </th></tr>
            <tr><th>id</th><th>sending time</th><th>status</th></tr>";
        //----------------------------------------------------------------------------------
        if(mysqli_num_rows($res) > 0)
        {   
            while($row = mysqli_fetch_array($res))
            {
                echo "<tr><td>".$row['mail_id']."</td>";
                echo "<td>".$row['mail_send_datetime']."</td>";
                echo "<td>".$row['status']."</td></tr>";
            }
        }
        else{
            echo "<tr><td colspan='3'> No mail is failed to sent </td></tr>";
        }
        echo "</table>";
        
?>
<html>

<head>
    <style>
        .t1,
        .t2,
        .t3 {
            display: inline-block;
            margin-left: 50px;
            margin-top: 10px;
        }

        tr:nth - child(even) {
            background-color: #ddd;
        }

        tr: hover,
        tr:nth-child(even): hover {
            background-color: #fff;
        }

        tr {
            background-color: #eee;
            transition-duration: 0.2s;
        }

    </style>
</head>

</html>

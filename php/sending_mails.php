<?php
    // Ignore user aborts and allow the script to run forever

    ignore_user_abort(true);
    set_time_limit(172800); // 1 days = 86400s
    require("connect.php");

    date_default_timezone_set('Asia/Kolkata');

    while(1)
    {
        // Did the connection fail?
        if(connection_status() != CONNECTION_NORMAL){
            break;
        }
        
        $res1 = mysqli_query($con,"select * from mail_queue where date_format(mail_send_datetime,'%Y-%m-%d %h:%i') = date_format(CURRENT_TIMESTAMP,'%Y-%m-%d %h:%i')");
        
        $res2 = mysqli_query($con,"select * from events where date_format(event_date_time,'%Y-%m-%d %h:%i') = date_format(CURRENT_TIMESTAMP,'%Y-%m-%d %h:%i')");
        
        $res3 = mysqli_query($con,"select * from group_events where date_format(event_date_time,'%Y-%m-%d %h:%i') = date_format(CURRENT_TIMESTAMP,'%Y-%m-%d %h:%i')");
        
        if(mysqli_num_rows($res1))
        {
            while($row = mysqli_fetch_array($res1))
            {
                $m = mysqli_query($con,"select mail from main_table where id=".$row['id']);
                $m = mysqli_fetch_array($m);
                $headers = "From: ".$m[0]."\r\n";
                /*$tmp = mail($row['mail_recipient'], $row['mail_subject'], $row['mail_text'], $headers);
                if($tmp){
                    mysqli_query($con, "update mail_queue set status=1 where mail_id=".$row['mail_id']);
                }
                unset($tmp);*/
                mysqli_query($con,"update mail_queue set status=1 where mail_id=".$row['mail_id']);
            }
        }
        
        if(mysqli_num_rows($res2))
        {   
            while($row = mysqli_fetch_array($res2))
            {
                $m = mysqli_query($con,"select mail from main_table where id=".$row['id']);
                $m = mysqli_fetch_array($m);
                $headers = "From: sharecal@gmail.com\r\n";
                //mail($m[0] , $row['event_subject'] , $row['event_description'] , $headers);
            }
        }
        
        if(mysqli_num_rows($res3))
        {
            while($row = mysqli_fetch_array($res3))
            {
                $m = mysqli_query($con,"select mail from main_table where id=".$row['id']);
                $m = mysqli_fetch_array($m);
                $headers = "From: sharecal@gmail.com\r\n";
                //mail($m[0] , $row['event_subject'] , $row['event_description'] , $headers);
            }
        }
        
        $time1 = date_create(strtotime(time()));
        $time1 = date_format($time1 , "Y-m-d H:i:s");
        
        mysqli_query($con,"update mail_send_time set time='$time1'");
        unset($time1);
        
        // Sleep for 30 seconds
        sleep(30);
    }
?>
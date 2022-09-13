<?php

    session_start();
    require("log_check.php");
    require("connect.php");
    
    if(isset($_COOKIE['event_id']) and log_ret())
    {
        mysqli_query($con,"delete from events where event_id=".$_COOKIE['event_id']);
        setcookie("event_id","",time()-360);
        echo "<script> window.location.replace('show_events.php'); </script>";
    }
    else if(isset($_COOKIE['gevent_id']) and log_ret())
    {
        mysqli_query($con,"delete from group_events where event_id=".$_COOKIE['gevent_id']);
        setcookie("gevent_id","",time()-360);
        echo "<script> window.location.replace('show_group_events.php'); </script>";
    }
    else if(isset($_COOKIE['mail_id']) and log_ret())
    {
        mysqli_query($con,"delete from mail_queue where mail_id=".$_COOKIE['mail_id']);
        setcookie("mail_id","",time()-360);
        echo "<script> window.location.replace('mails.php'); </script>";
    }
    else{
        echo "<script> window.location.replace('index.php'); </script>";
    }

?>

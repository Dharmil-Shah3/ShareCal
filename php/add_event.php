<?php

    session_start();
    require("log_check.php");
    log_chk();

    if($_SESSION['page']!='add_event' and isset($_SESSION['event_id']))
    {
        unset($_SESSION['event_id']);
        unset($_SESSION['event_subject']);
        unset($_SESSION['event_description']);
        unset($_SESSION['event_date']);
    }

    $_SESSION['page']='add_event';
    include("navigation_bar.php");
    extract($_POST);
    require("connect.php");

    date_default_timezone_set('Asia/Kolkata');
    $time_ = date_create(strtotime(time()));    
    date_add($time_ , date_interval_create_from_date_string("+1 day"));
    $time_ = date_format($time_,"Y-m-d")."T".date_format($time_,"H:i");

    /*----------------------------------------------------------------------------------------------
        IF FLOW CAME FROM calendar.php THEN GET SELECTED DATE STORED IN COOKIE AND DELETE COOKIE
    ----------------------------------------------------------------------------------------------*/
    if(isset($_COOKIE['e_date']) and log_ret())
    {
        $_SESSION['event_date'] = $_COOKIE['e_date'];
        setcookie("e_date","",time()-360);
        $time_ = date("Y-m-d",strtotime($_SESSION['event_date']))."T".date("h:i",strtotime($_SESSION['event_date']));
    }
    /*----------------------------------------------------------------------------------------------
                IF FORM IS SUBMITED TO UPDATE EXISTING EVENT THEN UPDATE IT INTO DATABASE
    ----------------------------------------------------------------------------------------------*/
    else if(isset($update) and isset($_SESSION['event_id']) and log_ret())
    {
        if($event_subject=="")
            $event_subject = "No Subject";
        mysqli_query($con,"update events set event_subject='".$event_subject."' , event_description='".$event_desc."' , event_date_time='".$dt."' where event_id=".$_SESSION['event_id']);
        unset($_SESSION['event_id']);
        unset($_SESSION['event_subject']);
        unset($_SESSION['event_description']);
        unset($_SESSION['event_date']);
        header("location:show_events.php");
    }
    /*-------------------------------------------------------------------------------------------------
            IF FLOW CAME TO UPDATE EXISTING EVENT THEN STORE VALUES IN SESSION AND DESTROY COOKIE OF
                            EVENT_ID AND ASSIGN VALUES TO INPUT FIELDS
    -------------------------------------------------------------------------------------------------*/
    else if((isset($_COOKIE['event_id']) or isset($_SESSION['event_id'])) and log_ret())
    {
        if(isset($_COOKIE['event_id']))
        {
            $_SESSION['event_id'] = $_COOKIE['event_id'];
            setcookie("event_id","",time()-360);
        }
        $row = mysqli_query($con,"select * from events where event_id=".$_SESSION['event_id']);
        $row = mysqli_fetch_array($row);
        $_SESSION['event_subject'] = $row['event_subject'];
        $_SESSION['event_description'] = $row['event_description'];
        $_SESSION['event_date'] = $row['event_date_time'];
        $time_ = date("Y-m-d",strtotime($_SESSION['event_date']))."T".date("h:i",strtotime($_SESSION['event_date']));
    }
    /*----------------------------------------------------------------------------------------------
                    IF FORM IS SUBMITED TO ADD NEW EVENT THEN INSERT IT INTO DATABASE
    ----------------------------------------------------------------------------------------------*/
    else if(isset($add) and log_ret())
    {
        $dt = date("Y-m-d h:i:s",strtotime($dt));
        mysqli_query($con,"INSERT INTO events (id , event_subject , event_description , event_date_time) VALUES (".$_SESSION['id']." , '$event_subject','$event_desc','$dt')");
        unset($_SESSION['event_date']);
        echo "<script> window.location.replace('show_events.php'); </script>";
    }

?>

<html>
<head>
    <title> ShareCal &nbsp;|&nbsp; Add Event </title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="../css/add_event.css">
    <style>
        body{
            background-image: url(../img/13.jpg);
        }
    </style>
</head>
<body>
    <center>
        <table>
            <form name="frm" method="post" action="add_event.php">

                <tr>
                    <th style="font-weight:100; font-size:20px;"> Event detils </th>
                </tr>

                <!------------------------------ DATE ----------------------------------->
                <tr>
                    <td> Date-Time (MM/DD/YYYY)</td>
                </tr>
                <tr class="tooltip">
                    <td>
                        <input type=datetime-local value="<?php echo $time_; ?>" name="dt" />
                        <span class="tooltiptext"> ( Reminder email will be sent at this date & time )</span>
                    </td>
                </tr>
                <!---------------------------- SUBJECT ---------------------------------->
                <tr>
                    <td> Subject </td>
                </tr>
                <tr>
                    <td><input type="text" placeholder=" No Subject" name="event_subject" value="<?php if(isset($_SESSION['event_id'])){ echo $_SESSION['event_subject'];}?>" autofocus>
                    </td>
                </tr>
                <!--------------------------- DISCRIPTION -------------------------------->
                <tr>
                    <td> Event Description </td>
                </tr>
                <tr>
                    <td>
                        <textarea name="event_desc" rows="3" placeholder=" Reqiured..." required><?php if(isset($_SESSION['event_id'])){ echo $_SESSION['event_description'];}?></textarea>
                    </td>
                </tr>
                <!------------------------------ SUBMIT --------------------------------->
                <tr>
                    <td style="text-align:center;">
                        <input style="text-align:center;" type="submit" <?php 
                if(isset($_SESSION['event_id'])){ echo "name='update' value=' Update '";}else{echo "name='add' value=' Add '";}?> />
                    </td>
                </tr>
            </form>
        </table>
    </center>
</body>
</html>

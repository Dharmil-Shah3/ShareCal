<?php

    session_start();
    require("log_check.php");
    log_chk();
    if(($_SESSION['page']!='add_mail') and (isset($_SESSION['mail_id']) and isset($_SESSION['mail_text']))){
        unset($_SESSION['mail_id']);
        unset($_SESSION['mail_subject']);
        unset($_SESSION['mail_text']);
        unset($_SESSION['mail_datetime']);
        unset($_SESSION['mail_recipient']);
    }

    $_SESSION['page'] = 'add_mail';
    extract($_REQUEST);
    require("connect.php");
    include("navigation_bar.php");

    date_default_timezone_set('Asia/Kolkata');
    $t = date_create(strtotime(time()));    
    date_add($t , date_interval_create_from_date_string("+5 minute"));
    $t = date_format($t,"Y-m-d")."T".date_format($t,"H:i");

    /*----------------------------------------------------------------------------------------------
                IF FORM IS SUBMITED TO SEND MAIL THEN SEND IT RIGHT NOW
    ----------------------------------------------------------------------------------------------*/
    if(isset($send_now) and log_ret())
    {
        $a = explode(',',$mail_recipient);
        foreach($a as $val)
        {
            $headers = 'From: dhar8866@gmail.com';
            mail($val , $mail_subject , $mail_text , $headers);
        }
    }
    /*----------------------------------------------------------------------------------------------
                IF FORM IS SUBMITED TO UPDATE EXISTING EVENT THEN UPDATE IT INTO DATABASE
    ----------------------------------------------------------------------------------------------*/
    else if(isset($update) and isset($_SESSION['mail_id']) and log_ret())
    {
        $mail_datetime = date("Y-m-d H:i:00",strtotime($mail_datetime));
        mysqli_query($con,"update mail_queue set mail_subject='".$mail_subject."' , mail_text='".$mail_text."' , mail_recipient='".$mail_recipient."' , mail_send_datetime='".$mail_datetime."' where mail_id=".$_SESSION['mail_id']);
        unset($_SESSION['mail_id']);
        unset($_SESSION['mail_subject']);
        unset($_SESSION['mail_text']);
        unset($_SESSION['mail_datetime']);
        unset($_SESSION['mail_recipient']);
        header("location:mails.php");
    }
    /*-------------------------------------------------------------------------------------------------
            IF FLOW CAME TO UPDATE EXISTING EVENT THEN STORE VALUES IN SESSION AND DESTROY COOKIE OF                            EVENT_ID AND ASSIGN VALUES TO INPUT FIELDS
    -------------------------------------------------------------------------------------------------*/
    else if((isset($_COOKIE['mail_id']) or isset($_SESSION['mail_id'])) and log_ret())
    {
        if(isset($_COOKIE['mail_id']))
        {
            $_SESSION['mail_id'] = $_COOKIE['mail_id'];
            setcookie("mail_id","",time()-360);
        }
        $row = mysqli_query($con,"select * from mail_queue where mail_id=".$_SESSION['mail_id']);
        $row = mysqli_fetch_array($row);
        $_SESSION['mail_subject'] = $row['mail_subject'];
        $_SESSION['mail_text'] = $row['mail_text'];
        $_SESSION['mail_recipient'] = $row['mail_recipient'];
        $_SESSION['mail_datetime'] = $row['mail_send_datetime'];
        $t = date('Y-m-d',strtotime($_SESSION['mail_datetime']))."T".date('H:i',strtotime($_SESSION['mail_datetime']));
    }
    /*----------------------------------------------------------------------------------------------
                    IF FORM IS SUBMITED TO ADD NEW MAIL THEN INSERT IT INTO DATABASE
    ----------------------------------------------------------------------------------------------*/
    else if(isset($add) and log_ret())
    {
        $a = explode(',',$mail_recipient);
        foreach($a as $val){
            
            if(strlen($val) > 6)
            {
                mysqli_query($con,"INSERT INTO mail_queue (mail_subject , mail_text , mail_send_datetime , mail_recipient , id) VALUES ('$mail_subject','$mail_text','$mail_datetime','$val',".$_SESSION['id'].")");
            }
        }
        echo "<script> window.location.replace('mails.php'); </script>";
    }
    
?>

<html>
<head>
    <title> ShareCal &nbsp;|&nbsp; Add Mail</title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="../css/add_mail.css">
    <style>
        body{
            background-image: url(../img/1.jpg);
        }
    </style>
</head>
<body>
    <center>
        <table>
        <form name="frm" method="post" action="add_mail.php">
            <tr>
                <th colspan='2' style="font-weight:100; font-size:25px;"> Mail details </th>
            </tr>

            <!------------------------------ DATE-TIME --------------------------------->
            <tr>
                <td colspan='2'> Date & Time to send mail </td>
            </tr>
            <tr>
                <td colspan='2'>
                    <input type=datetime-local value="<?php echo $t; ?>" name="mail_datetime" />
                </td>
            </tr>
            <!------------------------------ SUBJECT ---------------------------------->
            <tr>
                <td colspan='2'> Subject </td>
            </tr>
            <tr>
                <td colspan='2'><input type="text" placeholder=" Subject" name="mail_subject" value="<?php if(isset($_SESSION['mail_id'])){ echo $_SESSION['mail_subject'];}?>" required autofocus>
                </td>
            </tr>
            <!----------------------------- MAIL TEXT -------------------------------->
            <tr>
                <td colspan='2'> Mail text </td>
            </tr>
            <tr>
                <td colspan='2'>
                    <textarea name="mail_text" rows="7" placeholder=" type mail here..." required><?php if(isset($_SESSION['mail_id'])){ echo $_SESSION['mail_text'];}?></textarea>
                </td>
            </tr>
            <!----------------------------- RECIPIENT --------------------------------->
            <tr>
                <td> Send to </td>
            </tr>
            <tr>
                <td colspan="2"> <input type=text name="mail_recipient" id="mail_recipient" value="<?php if(isset($_SESSION['mail_id'])){ echo $_SESSION['mail_recipient'];}?>" placeholder=" use ' , ' for multiple email addresses" required> </td>
            </tr>
            <!------------------------------ SUBMIT --------------------------------->
            <tr>
                <td style="text-align:right;" class="tooltip">
                    <input style="text-align:center;" type="submit" <?php 
            if(isset($_SESSION['mail_id'])){ echo "name='update' value=' Update '";}else{echo "name='add' value=' Schedule '";}?> />
                    <span class="tooltiptext" style="left:-0;"> Send mail on selected time </span>
                </td>
                <td class="tooltip">
                    <input type="submit" value=" Send Now " style="text-align:center;" name="send_now" />
                    <span class="tooltiptext"> Send mail right now </span>
                </td>
            </tr>

        </form>
        </table>
    </center>

</body>
<script type="text/javascript">
    function add(x) {
        var y = document.getElementById('mail_recipient');
        y.value = "hi";
    }

    function mail_sent() {
        alert(" Mail is sent if there is no error in data you entered !");
    }
</script>
</html>
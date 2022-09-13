<?php
    session_start();
    require("log_check.php");
    log_chk();
    $_SESSION['page'] = 'mails';
    include("navigation_bar.php");
    require("connect.php");
    if(log_ret()){
        $res = mysqli_query($con,"select * from mail_queue where id=".$_SESSION['id']." order by mail_stored_datetime desc");
    }
?>
<html>
<head>
    <title> ShareCal &nbsp;|&nbsp; Mails </title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="../css/mail.css">
    <style>
        body{
            background-image: url(../img/1.jpg);   
        }
    </style>
</head>
<body>
    <center>
        <table>
            <tr>
                <th style="width:8%;"> Date/Time </th>
                <th style="width:16%;"> Subject </th>
                <th style="width:40%;"> Mail </th>
                <th style="width:18%;"> Send To </th>
                <th style="width:5%;"> Update </th>
                <th style="width:5%;"> Delete </th>
            </tr>
            <?php
                while($row = mysqli_fetch_array($res))
                {
                    echo "<tr>";
                    echo "<td> ".date("d-m-Y  h:i:s A",strtotime($row['mail_send_datetime']))." </td>";
                    echo "<td> ".$row['mail_subject']." </td>";
                    echo "<td> <textarea rows='4' style='width:100%;' disabled locked>".$row['mail_text']."</textarea> </td>";
                    echo "<td> ".$row['mail_recipient']." </td>";
                    echo "<td> 
                    <a name='".$row['mail_id']."' onclick='set_id(this)' href='add_mail.php' class='btn'> Update </a>
                          </td>";
                    echo "<td> 
                    <a name='".$row['mail_id']."' onclick='ask(this)' class='btn del' > Delete </a>
                          </td>";
                    echo "</tr>";
                    echo "</tr>";
                }
        ?>
        </table>
    </center>
</body>

<script type="text/javascript">
    function set_id(x) {
        document.cookie = "mail_id=" + x.name;
    }

    function ask(x) {
        if (confirm(" You want to delete that mail ? ")) {
            set_id(x);
            window.location.href = "delete_event.php";
        }
    }
</script>
</html>
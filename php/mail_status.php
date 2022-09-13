<?php
    
    session_start();
    include("log_check.php");
    $_SESSION['page'] = "mail_status";
    include("connect.php");
    include("navigation_bar.php");  
    if(admin_check() == false){ echo "<script> window.location.replace('index.php'); </script>"; }

?>
<html>
<head>
    <script type="text/javascript" src="jquery-3.4.1.min.js"> </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#rld').load('mail_send_time.php');
            $('#d2').load('mail_queue.php');
            refresh();
        });
    
        function refresh() {
            setTimeout(function() {
                $('#rld').load('mail_send_time.php');
                $('#d2').load('mail_queue.php');
                refresh();
            }, 5000);
        }
    
    </script>

    <title> Mail/Event Process</title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="../css/mail_status.css">
    <style>
        body{
            background-image: url(../img/raining-in-the-city-2448749.jpg);
        }
    </style>
</head>

<body>
    <center>
        <div id='rld' name='rld' class='rld'> </div>
        <div calss='d2' id='d2'> </div>
    </center>
</body>
</html>
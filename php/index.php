<?php 
    session_start();
    $_SESSION['page']='index';
    require("log_check.php");
    include("navigation_bar.php");
?>
<html>

<head>
    <title> ShareCal &nbsp;|&nbsp; Home </title>
    <link href="main.css" rel="stylesheet">
    <link href="icons/77_Essential_Icons/FONT/demo-files/demo.css" rel="stylesheet">
    <link href="icons/77_Essential_Icons/FONT/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/index.css">
    <style>
        .d1 {
            background-image: url(../img/top-view-photo-of-people-near-wooden-table-3183150.jpg);
            z-index:2;
        }
        .d2 {
            background-image: url(../img/6.jpg);
            z-index:1;
        }
        .d3 {
            background-image: url(../img/1.jpg);
            z-index:0;
        }
    </style>
</head>

<body>
    <!---------------------------------------D I V 1---------------------------------------------------->
    <div class="d1">
        <div>
            <span class="d1s1"> <span class="icon-Users"></span>Say hello to your friends !</span>
            <a href="find.php"><span class="d1s2"> <span class="icon-Search"></span>Find them by their mail or name and have chat with them...</span></a>
        </div>
    </div>
    <!---------------------------------------D I V 2-------------------------------------------------->
    <div class="d2">
        <span class="d2s1"><span class="icon-Notification"></span> Save your events in your calendar<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;and get remainders </span>
        <a href="calendar.php"> <span class="d2s2"><span class="icon-Calendar"></span> Explore your calendar & events </span> </a>
    </div>
    <!---------------------------------------D I V 3--------------------------------------------------->
    <div class="d3">
        <span class="d3s1"><span class="icon-Clock"></span> We take care of your priceless time </span>
        <a href="add_mail.php"> <span class="d3s2"><span class="icon-Email"></span> Shedule your Mails ! </span> </a>
    </div>
</body>
</html>
<?php

    session_start();
    if(isset($_SESSION['id']) and isset($_SESSION['mail']) and $_SESSION['mail']!="")
    {
        //session_destroy();
        unset($_SESSION['id']);
        unset($_SESSION['uname']);
        unset($_SESSION['mail']);
        header("location:index.php");
    }
    else{header("location:login.php");}
    
?>
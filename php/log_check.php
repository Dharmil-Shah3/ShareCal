<?php
    function log_ret(){
        if(isset($_SESSION['uname']) and isset($_SESSION['mail']) and isset($_SESSION['id'])){
            return true;
        }
        else{
            return false;
        }
    }

    function log_chk(){
        if(!log_ret()){
            echo "<script> window.location.replace('index.php'); </script>";
        }
    }

    function admin_check(){
        if(log_ret()){
            if($_SESSION['mail'] === 'dha8866@gmail.com'){
                return true;
            }
            else{
                return false;
            }
        }
    }
?>
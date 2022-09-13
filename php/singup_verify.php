<html>

<head>
    <style>
        h3 {
            color: #fff;
            background-color: lightgreen;
            padding: 5px;
            position: absolute;
            display: inline-block;
        }

    </style>
</head>

</html>
<?php
    session_start();
    @extract($_POST);
    require 'connect.php';

    //---------------------------- Login ------------------------------
    if(isset($login)){
        $q = mysqli_query($con,"select * from main_table where mail='".$mail."' and password='".$password."'");
        $result = mysqli_fetch_assoc($q);
        if(mysqli_num_rows($q)==1){
            $_SESSION['uname'] = $result['u_name'];
            $_SESSION['mail'] = $mail;
            $_SESSION['id']= $result['id'];
            echo "<script> window.location.replace('index.php'); </script>";
        }
        else {
            $_SESSION['msg']="<br><h3> incorrect email or password </h3>";
            echo "<script> window.location.replace('login.php'); </script>";
        }
    }

    //---------------------------- Sign-Up ------------------------------
    if(isset($signup))
    {
        $uname = trim($uname);
        if($uname == "")
        {
            $_SESSION['msg']="<h3> Invalid username </h3>";
            echo "<script> window.location.replace('login.php'); </script>";
        }
        $q = mysqli_query($con,"select * from main_table where mail='".$mail."'");
        if(mysqli_num_rows($q)>0){
            $_SESSION['msg']="<h3> '".$mail."' this email is already registered :( </h3>";
            echo "<script> window.location.replace('login.php'); </script>";
        }
        else{
            if(strlen($password)>=8 and $password===$cpassword){
                $_SESSION['otp'] = mt_rand(343434,696969);
                $_SESSION['uname'] = $uname;
                $_SESSION['password'] = $password;
                $_SESSION['mail'] = $mail;
                $msg = "Thank you ".$uname." to take interest in our webapp. Here is your OTP ".$_SESSION['otp']." . Don't share with anyone !";
                /*mail($mail,"OTP - ShareCal",$msg,"From: sharecal@gmail.com \r\n");*/
                echo "<script>
                    window.location.replace('otp.php');
                </script>";
            }
            else{
                $_SESSION['msg']="<h3> short or mismatched password </h3>";
            echo "<script> window.location.replace('login.php'); </script>";
            }
        }
    }
    else
    {
        echo "<script> window.location.replace(index.php'); </script>";
    }
?>

<?php
    require("connect.php");
    @extract($_POST);
    session_start();
?>
<html>

<head>
    <title> Forgot Password </title>
    <link rel="stylesheet" href="main.css" />
    <link rel="stylesheet" href="../css/forgot_pass.css">
    <style>
        body{
            background-image: url(../img/12.jpg);
        }
    </style>
</head>

<body>
    <center>
    <?php
            
        if(isset($_SESSION['otp']))
        {
        echo "<div class='frm' style='margin-top:18%;'>
            <form name='frm' method='post' action='forgot_pass.php'>
                <table>
                    <!-- <tr> <th> Forgot &nbsp; password </th> </tr> -->

                    <!-- _________________________O T P___________________ -->
                    <tr>
                        <td> <input class='s' type='number' name='otp' id='otp' placeholder='Enter OTP' required /> </td>
                    </tr>
                    <!-- _______________________S U B M I T___________________ -->
                    <tr>
                        <td>
                            <center> <input type='submit' name='Otp' value=' Verify OTP ' /> </center>
                        </td>
                    </tr>
                </table>
            </form>
        </div>";
        echo "<br>".$_SESSION['otp'];
        }
        else if(isset($_SESSION['repass']))
        {
        echo "<div class='frm' style='margin-top:18%;'>
            <form name='frm' method='post' action='forgot_pass.php'>
                <table>
                    <!-- <tr> <th> Enter new password </th> </tr> -->

                    <!-- ______________________P A S S W O R D___________________ -->
                    <tr>
                        <td> <input type='password' name='pass' placeholder=' Password ' required /> </td>
                    </tr>
                    <!-- _____________________C P A S S W O R D___________________ -->
                    <tr>
                        <td> <input type='password' name='cpass' placeholder=' Confirm password ' required /> </td>
                    </tr>
                    <!-- _______________________S U B M I T___________________ -->
                    <tr>
                        <td>
                            <center> <input type='submit' name='Pass' value=' Change ' /> </center>
                        </td>
                    </tr>
                </table>
            </form>
        </div>";
        }
        else if(!isset($_SESSION['otp']) and !isset($_SESSION['repass']))
        {
        echo "<div class='frm' style='margin-top:18%;'>
            <form name='frm' method='post' action='forgot_pass.php'>
                <table>
                    <!-- <tr> <th> Forgot &nbsp; password </th> </tr> -->

                    <!-- _________________________M A I L___________________ -->
                    <tr>
                        <td> <input type='email' name='mail' id='mail' placeholder='Email address' maxlength='48' required /> </td>
                    </tr>
                    <!-- _______________________S U B M I T___________________ -->
                    <tr>
                        <td>
                            <center> <input type='submit' name='submit' value=' Send OTP ' /> </center>
                        </td>
                    </tr>
                </table>
            </form>
        </div>";
        }
        ?>
    <?php 
            
        if(isset($submit))
        {
            $res = mysqli_query($con, "select * from main_table where mail='".$mail."'");
            if(mysqli_num_rows($res) > 0)
            {
                $_SESSION['otp'] = mt_rand(343434,696969);
                $_SESSION['mail'] = $mail;
                echo "<script> window.location.replace('forgot_pass.php'); </script>";
            }
            else
            {
                echo "<br><h3> This mail is not registered in site ! </h3>";
            }
        }
        else if(isset($Otp))
        {
            if($_SESSION['otp'] == $otp)
            {
                unset($_SESSION['otp']);
                $_SESSION['repass'] = 1;
                echo "<script> window.location.replace('forgot_pass.php'); </script>";
            }
            else
            {
                echo "<br><h3> Invalid OTP ! </h3>";
            }
        }
        else if(isset($Pass))
        {
            if($pass === $cpass)
            {
                mysqli_query($con , "update main_table set password='".$pass."' where mail='".$_SESSION['mail']."'");
                $res = mysqli_query($con , "select * from main_table where mail='".$_SESSION['mail']."'");
                $res = mysqli_fetch_array($res);
                $_SESSION['uname'] = $res['u_name'];
                $_SESSION['id']= $res['id'];
                echo "<script> 
                        alert(' Your password has successfully changed... ');
                        window.location.replace('index.php'); 
                    </script>";
            }
            else
            {
                echo "<br><h3> Passwords didn't matched ! </h3>";
            }
        }

    ?>
    </center>
</body>
</html>
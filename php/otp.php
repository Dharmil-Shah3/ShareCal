<html>

<head>
    <title> Signup OTP verification </title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="../css/otp.css">
    <style>
        body{
            background-image: url(../img/2.jpg);
        }
    </style>
</head>

<body>
    <center>
        <?php
            require 'connect.php';
            extract($_POST);
            session_start();
            echo "<br>OPT = ".$_SESSION['otp']."<br><br>";
            echo "<br><br><br> <h3> Check ".$_SESSION['mail']." inbox for OTP... </h3><br><br><br>";

            if(isset($otpver) and ($otp==$_SESSION['otp']))
            {
                mysqli_query($con,"insert into main_table(u_name, password, mail) values ('".$_SESSION['uname']."','".$_SESSION['password']."','".$_SESSION['mail']."')");
                unset($_SESSION['password']);
                unset($_SESSION['otp']);
                $result = mysqli_query($con,"select id from main_table where mail='".$_SESSION['mail']."'");
                $result = mysqli_fetch_array($result);
                $_SESSION['id'] = $result['id'];
                echo "<script> window.location.href = 'index.php'; </script>";
            }
            else if(isset($otpver)){
                echo "<br><br><h3>OTP didn't match...</h3>";
            }
        ?>

        <br><br><br>
        <div class="frm">
            <form name="frm" method="post" action="otp.php">
                <input type="text" name="otp" placeholder=" Enter OTP " required />
                <br><br>
                <input type="submit" name="otpver" value=" Verify " />
            </form>
        </div>
    </center>
</body>

</html>
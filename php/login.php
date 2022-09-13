<script type="text/javascript">
    function forgot() {
        document.cookie = "forgot_pass=" + "yes";
        window.location.href = "forgot_pass.php";
    }

</script>
<html>
<head>
    <title> Login / Signup </title>
    <link rel="stylesheet" href="main.css" />
    <link rel="stylesheet" href="../css/login.css">
    <style>
        body{
            background-image: url(../img/app-apple-calendar-computer-39578.jpg);
        }
    </style>
</head>
<body>

    <div class="login">
        <p onclick="window.location.href='index.php'">ShareCal</p>
        <form name="frm" method="post" action="./singup_verify.php" style="padding-bottom:40px;">

            <!-- _________________________M A I L___________________ -->
            <input type="email" name="mail" id="mail" placeholder="Email address" maxlength="48" required autofocus />

            <!-- _____________________P A S S W O R D___________________ -->
            <input type="password" name="password" placeholder="Password" id="password" required />

            <!-- _______________________S U B M I T___________________ -->
            <input type="submit" name="login" value=" Login " />
            <a style="position:absolute; margin-top:39px; margin-left:-120px;" onclick='forgot()'>Forgot Password</a>

        </form>
    </div>

    <center>
        <?php 
            session_start(); 
            $_SESSION['page'] = "login";
            if(@isset($_SESSION['msg'])){ 
                echo $_SESSION['msg']; 
                unset($_SESSION['msg']); 
            }
        ?>
        <div class="frm" style="margin-top:8%;">
            <form name="frm" method="post" action="singup_verify.php">
                <table>
                    <tr>
                        <th> S i n g &nbsp; u p </th>
                    </tr>
                    <!-- _______________________USER NAME_____________________ -->
                    <tr>
                        <td> <input class="s" type="text" name="uname" placeholder="User name " required onpaste="return false;" ondrop="return false;" onkeypress="return block(event)" /> </td>
                    </tr>
                    <tr>
                        <th id="w1" style="color:red; font-size:15px; "> &nbsp; </th>
                    </tr>
                    <!-- _________________________M A I L___________________ -->
                    <tr>
                        <td> <input class="s" type="email" name="mail" id="mail" placeholder="Email address" maxlength="48" onfocus="mail(w4)" onblur="mail2(w4)" required /> </td>
                    </tr>
                    <tr>
                        <th id="w4" style="color:red; font-size:15px;"> &nbsp; </th>
                    </tr>
                    <!-- _____________________P A S S W O R D___________________ -->
                    <tr>
                        <td> <input class="s" type="password" name="password" placeholder="Password " id="password" onkeyup="passlen(this,w2)" required /> </td>
                    </tr>
                    <tr>
                        <th id="w2" style="color:red; font-size:15px;"> &nbsp; </th>
                    </tr>
                    <!-- _____________________C P A S S W O R D___________________ -->
                    <tr>
                        <td> <input class="s" type="password" name="cpassword" placeholder="Confirm Password " oninput="check(password,cpassword,w3)" id="cpassword" required /> </td>
                    </tr>
                    <tr>
                        <th id="w3" style="color:red; font-size:15px;"> &nbsp; </th>
                    </tr>
                    <!-- _______________________S U B M I T___________________ -->
                    <tr>
                        <td>
                            <center> <input type="submit" name="signup" value=" Sign up " /> </center>
                        </td>
                    </tr>

                </table>
            </form>
        </div>
    </center>
</body>
</html>

<script type="text/javascript">
    function passlen(x, y) {
        if (x.value.length < 8) {
            y.innerHTML = "Minimum 8 characters";
            x.style.border = "1px solid red";
            x.style.color = "red";
        } else {
            x.style.border = "none";
            x.style.color = "#29323f";
            y.innerHTML = "&nbsp;";
        }
    }

    function check(x, y, z) {
        if (x.value != y.value) {
            y.style.border = "1px solid red";
            y.style.color = "red";
            z.innerHTML = "Password didn't matched";
        } else {
            y.style.border = "none";
            y.style.color = "#29323f";
            z.innerHTML = "&nbsp;";
        }
    }

    function mail(x) {
        x.innerHTML = "OTP will be sent to this email";
    }

    function mail2(x) {
        x.innerHTML = "&nbsp;";
    }

    function isNumber(evt) {
        var iKeyCode = (evt.which) ? evt.which : evt.keyCode
        if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57))
            return false;

        return true;
    }

    function block(e) {
        var k = e.keyCode;

        return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || k == 45 || (k >= 48 && k <= 57));

    }
</script>
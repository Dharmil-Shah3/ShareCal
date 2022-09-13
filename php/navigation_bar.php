<link rel="icon" href="../img/logo/Logo/1024w/Asset_21.png" type="image/png" >
<link rel="stylesheet" href="../css/navigation_bar.css">

<script type="text/javascript">
    function show(x) {
        x.style.display = 'inline-block';
    }

    function hide(x) {
        x.style.display = 'none';
    }
</script>
<!--
<div class='dc dc1' id='dc1' onmouseover="show(this)" onmouseout="hide(this)">
    <a href="#">Link 1</a>
    <a href="#">Link 2</a>
    <a href="#">Link 3</a>
</div>
<div class='dc dc2' id='dc2' onmouseover="show(this)" onmouseout="hide(this)">
    <a href="find.php"> F r i e n d s </a>
</div>
-->
<ul>
    <?php $isLogin = log_ret() ?>
    <li> <a href='index.php' <?php if($isLogin and $_SESSION['page']=='index'){echo "class='n'";} ?>> H o m e </a></li>

    <li><a href="calendar.php" <?php if($isLogin and $_SESSION['page']=='calendar'){echo "class='n'";} ?>> C a l e n d a r </a></li>

    <li><a href='show_events.php' <?php if($isLogin and $_SESSION['page']=='show_events'){echo "class='n'";} ?>> E v e n t s </a></li>
	<?php if($isLogin and $_SESSION['page']=='show_events'){echo 
    "<li> <a href='add_event.php' class='op' > A d d &nbsp; E v e n t </a></li>";}?>

    <li><a href="mails.php" <?php if($isLogin and $_SESSION['page']=='mails'){echo "class='n'";} ?>> M a i l s </a></li>
	<?php if($isLogin and $_SESSION['page']=='mails'){echo 
    "<li> <a href='add_mail.php' class='op' > A d d &nbsp; E m a i l </a></li>";}?>

    <li><a href="find.php" <?php if($isLogin and $_SESSION['page']=='find'){echo "class='n'";} ?>> F r i e n d s </a></li>

    <li><a href='groups.php' <?php if($isLogin and $_SESSION['page']=='groups'){echo "class='n'";} ?>> G r o u p s </a></li>
	<?php if($isLogin and $_SESSION['page']=='groups'){echo 
    "<li> <a href='create_group.php' class='op' > C r e a t e &nbsp; g r o u p </a></li>";}?>

    <?php if(admin_check()){echo 
    "<li> <a href='mail_status.php' class='op'> MAIL - PROCESS </a></li>";}?>

    <?php if($isLogin and ($_SESSION['page']=='group_calendar' or $_SESSION['page']=='add_group_event')){ $tmp = $_SESSION['tname']; echo 
    "<li> <a href='show_group_events.php' class='op' > G r o u p &nbsp; E v e n t s </a></li>";}?>

    <?php if($isLogin and $_SESSION['page']=='show_group_events'){ $tmp = $_SESSION['tname']; echo 
    "<li> <a href='add_group_event.php' class='op' > A d d &nbsp; G r o u p &nbsp; E v e n t </a></li>";}?>

    <?php if($isLogin and ($_SESSION['page']=='show_group_events' or $_SESSION['page']=='add_group_event')){ $tmp = $_SESSION['tname']; echo 
    "<li> <a href='group_calendar.php' class='op' > G r o u p &nbsp; C a l e n d a r </a></li>";}?>

    <li class="last"><a href="logout.php"> <?php if(isset($_SESSION['uname']) and isset($_SESSION['id'])){echo "L o g o u t";}else{echo "L o g i n";}?> </a></li>

    <?php 
        if(log_ret()){ 
            $tmp = str_split($_SESSION['uname']);
            echo "<li class='last'><a class='name'>";
            foreach($tmp as $val){
                if($val==" ")
                    echo"&nbsp;";
                echo $val." ";
            }
            echo "</a></li>";
        } 
    ?>
</ul>

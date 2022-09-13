<?php session_start();?>
<script type="text/javascript">

    var e = document.getElementById('fn');
    var h = document.getElementById('here');
    h.value = e.value;
    document.cookie = "search=" + e.value;
    a = document.getElementById('auto');
    //a.innerHTML = e.value;
    
    sessionStorage.setItem("ses",e.value);
    //alert(sessionStorage.getItem("ses"));
</script>

<?php
    $srch = $_COOKIE['search'];
    require('connect.php');
    $res = mysql_query("select * from main_table where uname='".$srch."' or mail='".$srch."'");
    $res = mysql_fetch_assoc($res);
    print_r($res);
    echo $srch;
    //echo mysqli_num_rows($res);
    //echo $_SESSION['temp'];
    //echo $e;
?>
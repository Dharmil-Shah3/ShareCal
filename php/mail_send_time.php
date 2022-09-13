<html>

<head>
    <style>
        .dis {
            background-color: gray;
        }

        .dis:hover {
            cursor: not-allowed;
        }

    </style>
</head>

</html>
<?php
        
    include("connect.php");
    date_default_timezone_set('Asia/Kolkata');

    $time2 = date_create(strtotime(time()));
    $time2 = date_format($time2 , "d-m-Y h:i:s A");

    $t = mysqli_query($con,"select * from mail_send_time");
    $t = mysqli_fetch_array($t);
    echo "<table><tr><th colspan='5' style='background-color:#008cba;'> last time script executed </th></tr>
    <tr>
        <th> Time </th>
        <th> Last executed </th>
        <th> Time gap </th>
        <th> Status </th>
        <th> Execute </th>
    </tr>";
    echo "<tr><td>".$time2."</td>";
    echo "<td>".date("d-m-Y h:i:s A",strtotime($t[0]))."</td>";
    $dif = abs(strtotime($time2) -  strtotime($t[0]));
    echo "<td>".$dif."</td>";

    if($dif > 30){
        echo "<td> <font color='red'> Not-Runnig </font> </td>";
        echo "<td><a href='sending_mails.php' target='_blank' disable> Execute </a></td>";
    }
    else{
        echo "<td> <font color='limegreen'> Runnig </font> </td>";
        echo "<td><a class='dis'> Execute </a></td>";
    }

    echo "</tr></table>";
?>

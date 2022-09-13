<?php
    @extract($_POST);
    session_start(); 
    require("log_check.php");
    log_chk();
    $_SESSION['page'] = 'groups';
    include("navigation_bar.php");
?>
<html>

<head>
    <title> ShareCal &nbsp;|&nbsp; Groups</title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="../css/groups.css">
    <style>
        body{
            background-image: url(../img/top-view-photo-of-people-near-wooden-table-3183150.jpg);
        }
    </style>
</head>

<body>
    <center>

        <div class="frm">
            <form name="frm" method="post" action="find.php">

                <input type="search" name="fn" id="fn" placeholder=" group name " value="<?php if(isset($fn)){echo $fn;} ?>" required autofocus>

                <input type="submit" value=" Find " name="find" />

            </form>
        </div>
    </center>
</body>

<script type="text/javascript">
    function set_name(x) {
        document.cookie = "gname=" + x.name;
    }

</script>

</html>

<?php

    require("connect.php");
    /*=============================================================================*/
    echo "<center>
              <table>
              <tr> 
                   <th style='width:7%; border-right:1px solid white;' > Group Name </th> 
                   <th style='width:8%; border-right:1px solid white;' > Creator </th> 
                   <th style='width:1%; border-right:1px solid white; '> Chat </th> 
                   <th style='width:1%; border-right:1px solid white; '> Events </th>
                   <th style='width:1%;'> Edit </th> 
              </tr>";
    $res = mysqli_query($con,"select * from group_details where id=".$_SESSION['id']);
    /*if(isset($find))
    {       
        $fnd = mysqli_query($con,"select group_name from group_details where id=".$_SESSION['id']);
        
    }*/
    while($row = mysqli_fetch_array($res))
    {
        $gname = explode('_',$row[0]);
        $creator = mysqli_query($con , "select u_name from main_table where id=".$gname[2]);
        $creator = mysqli_fetch_array($creator);

        echo "<tr>";
        echo "<td>".$gname[1]."</td>";

        if($gname[2] == $_SESSION['id'])
            echo "<td> ".$creator[0]." (you) </td>";
        else
            echo "<td> ".$creator[0]." </td>";

        $tmp = $row[0];
        echo "<td> <a onclick='set_name(this)' name='".$row[0]."' href='chat_group.php' > Go ! </a></td>";

        echo "<td> <a onclick='set_name(this)' name='".$row[0]."' href='show_group_events.php' > Go ! </a> </td>";

        if($gname[2] == $_SESSION['id'])
            echo "<td> <a onclick='set_name(this)' name='".$row[0]."' href='group_edit.php' > Edit </a> </td>";
        else
            echo "<td> -- </td>";
        
        unset($tmp);
        echo "</tr>";
    }
    if(!isset($gname))
    {
        echo "<tr><td colspan='5'> No group found </td></tr>";
    }
    echo "</table></center>";

?>

<!--

CREATE TABLE gdetail_lol_1
( 
  id INT(4) NOT NULL COMMENT 'This will store group member id same as in main table' ,
  permission INT(1) NOT NULL COMMENT 'This is used to know group member\'s privileges.' ,
  notify VARCHAR(3) NOT NULL DEFAULT 'yes' COMMENT 'Used to know that if member is interested in group event notifications or not.'
) ENGINE = InnoDB COMMENT = 'This table contains details of group members'

CREATE TABLE gchat_lol_1
( 
  id INT(4) NOT NULL COMMENT 'This will store user/member id who sent the message' ,
  mid INT(4) NOT NULL AUTO_INCREMENT COMMENT 'This will store message id by auto increment' ,
  msg TEXT NOT NULL COMMENT 'This will store the message' ,
  mtime DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'This will store the time of the message' ,
  primary key (mid)
) ENGINE = InnoDB COMMENT = 'This table contains chats of group members'

CREATE TABLE gcal_lol_1
(
  event_id INT(3) NOT NULL AUTO_INCREMENT , 
  event_subject VARCHAR(25) NOT NULL DEFAULT 'No Subject' ,
  event_description VARCHAR(512) NOT NULL ,
  event_date_time DATETIME NOT NULL ,   
  event_add_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY  (event_id)
) ENGINE = InnoDB COMMENT = 'This table contains group events'

insert into gdetail_lol_1 values(".$_SESSION['id']." , 1 , 'yes' )

SELECT COUNT(id) Group_members from gdetail_lol_1

SELECT * FROM main_table where id in (select id from gdetail_lol_1 where notify='yes')
-->

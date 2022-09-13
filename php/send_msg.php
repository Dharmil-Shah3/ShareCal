<?php
    session_start();
    require("connect.php");
    require("log_check.php");
    log_chk();
    extract($_POST);

    //--------------------------------------------------------------------------------
    if(isset($_GET['del']))
    {
        mysqli_query($con,"delete from group_details where group_name='".$_SESSION['tname']."'");
        mysqli_query($con,"delete from group_chat where group_name='".$_SESSION['tname']."'");
        mysqli_query($con,"delete from group_events where group_name='".$_SESSION['tname']."'");
        echo "<script> window.location.replace('groups.php'); </script>";
    }

    //---------------------------------------------------------------------------------
    if(isset($_GET['left']))
    {    
        mysqli_query($con,"delete from group_details where id=".$_SESSION['id']." and group_name='".$_SESSION['tname']."'");
        
        if($_GET['left'] == 2){
            mysqli_query($con,"delete from group_events where id=".$_SESSION['id']." and group_name='".$_SESSION['tname']."'");
        }
        
        echo "<script> window.location.replace('groups.php'); </script>";
    }

     //---------------------------------------------------------------------------------
        if(isset($rename))
        {
            $gn = "group_".$gname."_".$_SESSION['id'];
            $res = mysqli_query($con , "select id from group_details where group_name='".$gn."'");
            
            if(mysqli_num_rows($res) == 0)
            {
                mysqli_query($con,"update group_details set group_name='".$gn."' where group_name='".$_SESSION['tname']."'");
                mysqli_query($con,"update group_chat set group_name='".$gn."' where group_name='".$_SESSION['tname']."'");
                mysqli_query($con,"update group_events set group_name='".$gn."' where group_name='".$_SESSION['tname']."'");
                setcookie("gname","$gn");
                $_SESSION['msg'] = "<h3> Successfuly renamed to '".$gname."' </h3>";
            }
            else
            {
                $_SESSION['msg'] = "<h3> You have already created group '".$gname."' </h3>";
            }
            echo "<script> window.location.replace('group_edit.php'); </script>";    
        }

     //---------------------------------------------------------------------------------
    if(isset($m_add)){
        $res = mysqli_query($con , "select * from main_table where mail='".$_mail."'");
    
        if(mysqli_num_rows($res)==0){
            $_SESSION['msg'] = "<h3> No such user found on this site </h3>";
        }
        else{
            $res = mysqli_fetch_array($res);
            $id2 = $res['id'];
            $res = mysqli_query($con , "select * from group_details where id=$id2 and group_name='".$_SESSION['tname']."'");
            if(mysqli_num_rows($res)==0){
                mysqli_query($con,"insert into group_details (group_name , id , permission ) values('".$_SESSION['tname']."' , $id2 , 2)");
                $_SESSION['msg'] = "<h3> Successfuly added ".$_mail." </h3>";
            }
            else
            {
                $_SESSION['msg'] = "<h3> $_mail is already group participant </h3>";
            }
        }
        echo "<script> window.location.replace('group_edit.php'); </script>";
    }
    //---------------------------------------------------------------------------------
    if(isset($m_rem)){
        $res = mysqli_query($con , "select * from main_table where mail='".$_mail."'");
    
        if(mysqli_num_rows($res)==0){
            $_SESSION['msg'] = "<h3> No such user found on this site </h3>";
        }
        else{
            $res = mysqli_fetch_array($res);
            $id2 = $res['id'];
            $res = mysqli_query($con , "select * from group_details where id=$id2 and group_name='".$_SESSION['tname']."'");
            
            if(mysqli_num_rows($res)==0){
                $_SESSION['msg'] = "<h3> ".$_mail." is not a participant </h3>";
            }
            else
            {
                mysqli_query($con,"delete from group_details where id=$id2 and group_name='".$_SESSION['tname']."'");
                $_SESSION['msg'] = "<h3> Successfuly removed ".$_mail." </h3>";
            }
        }
        echo "<script> window.location.replace('group_edit.php'); </script>";
    }
    //----------------------------------------------------------------------------------
    if( isset($_COOKIE['msg']) and ($_COOKIE['msg'] != "") )
    {
            mysqli_query($con,"insert into group_chat (msg,id,group_name) values('".$_COOKIE['msg']."',".$_SESSION['id'].",'".$_SESSION['tname']."')");
            setcookie("msg","",time()-360);
			$_SESSION['cnt']=0;
    }
	//----------------------------------------------------------------------------------
    if( isset($_COOKIE['pmsg']) and ($_COOKIE['pmsg'] != "") )
    {
            mysqli_query($con,"insert into chat (msg,id,rid) values('".$_COOKIE['pmsg']."',".$_SESSION['id'].",'".$_SESSION['id2']."')");
            setcookie("pmsg","",time()-360);
			$_SESSION['cnt']=0;
    }
    //----------------------------------------------------------------------------------
    if( isset($_COOKIE['notify']) )
    {
        mysqli_query($con,"update group_details set notify='".$_COOKIE['notify']."' where id=".$_SESSION['id']." and group_name='".$_SESSION['tname']."'");
        setcookie("notify","",time()-360);
        echo "<script> window.location.replace('chat_group.php'); </script>";
    }
   
?>

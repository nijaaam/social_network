<?php	
    ob_start();
    session_start();
    require_once 'dbconnect.php';
    require_once 'functions.php';
    
    $userId = $_SESSION['user'];
    $request = $_GET['request'];
    
    if($request == "add_friend"){
        $friendId = $_GET['id'];
        mysql_query("INSERT INTO relationships(userID1,userID2,invitationSentBy,timeRequestSent) VALUES ('$userId','$friendId','$userId',now()),('$friendId','$userId','$userId',now()) ")or die(mysql_error());
        header("Location: friends.php");
        exit;
    }	

    if($request == "accept_friend_request"){
        $friendId = $_GET['id'];
        mysql_query("UPDATE relationships SET invitationAccepted = 1, timeRequestAccepted = now() WHERE (userID1 = '$friendId' AND userID2 = '$userId') OR (userID1 = '$userId' AND userID2 = '$friendId')")or die(mysql_error());
        header("Location: friends.php");
        exit;
    }	

    if($request == "reject_friend_request"){
        $friendId = $_GET['id'];
        mysql_query("DELETE FROM relationships WHERE (userID1 = '$friendId' AND userID2 = '$userId') OR (userID1 = '$userId' AND userID2 = '$friendId')")or die(mysql_error());
        header("Location: friends.php");
        exit;
    }

    if($request == "change_privacy"){
        $option = $_GET['option'];
        $value = $_GET['value'];
        
        if($option == "profileView"){
            mysql_query("UPDATE securitysettings SET whoCanSeeProfile = '$value' WHERE (userID = '$userId')")or die(mysql_error());
        }
        
        if($option == "blogView"){
            mysql_query("UPDATE securitysettings SET whoCanSeeBlog = '$value' WHERE (userID = '$userId')")or die(mysql_error());
        }
        
        header("Location: profile.php");
        exit;
    }

    if($_POST['send_message_circle'] != ""){
        $message = $_POST['send_message_circle'];
        $circleID = $_POST['circleID'];
        
        $sql = "INSERT INTO messagecircles (circleID, userID, message, timeSent) VALUES ('$circleID', '$userId', '$message', now())
";
        mysql_query($sql) or die(mysql_error());
        header("Location: view_circle.php?action=view&id=".$circleID);
        exit;
    }
?>
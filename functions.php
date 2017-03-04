<?php
    ob_start();
    session_start();
    require_once 'dbconnect.php';

    $userId = $_SESSION['user'];
    $request = $_GET['request'];

    if($request == "add_friend"){
        $friendId = $_GET['id'];
        echo $userId;
        $query = "INSERT INTO relationships VALUES($userId,$friendId,$userId,0,now(),now());"; 
        mysql_query($query) or die(mysql_error());
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
            header("Location: profile.php");
            exit;
        }

        if($option == "blogView"){
            mysql_query("UPDATE securitysettings SET whoCanSeeBlog = '$value' WHERE (userID = '$userId')")or die(mysql_error());
            header("Location: profile.php");
            exit;
        }
        
        if($option == "photoCollection"){
            $id = $_GET['id'];
            mysql_query("UPDATE photoCollections SET whoCanSee = '$value' WHERE (photoCollectionID = '$id')")or die(mysql_error());
            header("Location: view_photo_collection.php?action=view&id=".$id);
            exit;
        }
    }

    if($request == "change_privacy_admin"){
        $option = $_GET['option'];
        $value = $_GET['value'];
        $id = $_GET['id'];

        if($option == "profileView"){
            mysql_query("UPDATE securitysettings SET whoCanSeeProfile = '$value' WHERE (userID = '$id')")or die(mysql_error());
        }

        if($option == "blogView"){
            mysql_query("UPDATE securitysettings SET whoCanSeeBlog = '$value' WHERE (userID = '$id')")or die(mysql_error());
        }

        header("Location: view_profile.php?action=view&id=$id");
        exit;
    }

    if($_POST['add_friend_circle']){
        // add friend circle sql
        $friendIdsList = array();
        foreach($_POST as $key=>$value) {
            if($key != "header" && $key != "add_friend_circle"){
                $friendIdsList[] = $value;
            }
        }
        // Comma delimited string
        $circleName = $_POST['header'];
        
        $sql = "START TRANSACTION;";
        $res = mysql_query($sql);
        $sql = "INSERT INTO circles(name,adminUserId) 
            VALUES('$circleName','$userId');";
        $res = mysql_query($sql);
        $circleId = mysql_insert_id();
        $sql = "INSERT INTO circlememberships(circleId, userId) VALUES ";
        
        foreach($friendIdsList as $friendId) {
            $sql = $sql."(".$circleId.",".$friendId."),";
        }
        $sql = $sql."(".$circleId.",".$userId.")";
        
        $res = mysql_query($sql);
        $sql = "COMMIT;";            
        $res = mysql_query($sql) or die(mysql_error());
        
        if($res){
            header("Location: view_circle.php?action=view&id=".$circleId);
            exit;
        }
    }

    if($_POST['modify_friend_circle']){
        $circleId = $_POST['circleId'];
        $checkedIds;
        foreach($_POST as $key=>$value) {
            if($key != "circleId" && $key != "modify_friend_circle")
                $checkedIds[] = $value;
        }
        
        $existingMembers = $_SESSION['existingMembers'];
        
        $newMembers = array_diff($checkedIds, $existingMembers);

        $removedMembers = array();
        foreach($existingMembers as $member){
            if(!in_array($member, $checkedIds) && $member != $userId)
                $removedMembers[] = $member;
        }
        $removedMembers = implode(", ", $removedMembers);
             
        $sql = "START TRANSACTION;";
        $res = mysql_query($sql);
        $sql = "DELETE FROM circlememberships WHERE circleID = ".$circleId." AND userID IN (".$removedMembers.")";
        $res = mysql_query($sql);
        $sql = "INSERT INTO circlememberships(circleId, userId) VALUES ";
        $lastElement = end($newMembers);
        foreach($newMembers as $newMemberId) {
            $sql = $sql."(".$circleId.",".$newMemberId.")";
            if($newMemberId != $lastElement)
                $sql = $sql.",";
        }
        $res = mysql_query($sql);
        $sql = "COMMIT;";            
        $res = mysql_query($sql) or die(mysql_error());
        
        if($res){
            header("Location: view_circle.php?action=view&id=".$circleId);
            exit;
        }
    }

    if($_POST['send_message_circle'] != ""){
        $message = $_POST['send_message_circle'];
        $circleID = $_POST['circleID'];

        $sql = "INSERT INTO messagecircles (circleID, userID, message, timeSent) VALUES ('$circleID', '$userId', '$message', now())";
        mysql_query($sql) or die(mysql_error());
        header("Location: view_circle.php?action=view&id=".$circleID);
        exit;
    }

    if($_POST['post_blog'] != ""){
        $blogPost = $_POST['post_blog'];

        $sql = "INSERT INTO blogposts (userID, blogPostBody, dateTime) VALUES ('$userId', '$blogPost', now())";
        mysql_query($sql) or die(mysql_error());
        header("Location: profile.php");
        exit;
    }

    if($_POST['post_photo_comment'] != ""){
        $photoComment = $_POST['post_photo_comment'];
        $photoId = $_POST['photoId'];

        $sql = "INSERT INTO photocomments (photoID, userID, comment, dateTime) VALUES ('$photoId', '$userId', '$photoComment', now())";
        mysql_query($sql) or die(mysql_error());
        header("Location: view_photo.php");
        exit;
    }

    if($_POST['new_photo_collection'] != ""){
        if (isset($_POST['upload'])) {
            $count = count($_FILES['img']['name']);
            $sql = "START TRANSACTION;";
            $res = mysql_query($sql);
            $sql = "INSERT INTO photoCollections(userID) VALUES('$userId');";
            $res = mysql_query($sql);
            $photoCollectionId = mysql_insert_id();

            for ($i = 0; $i < $count; $i++){
                $name = $_FILES["img"]["name"][$i];
                $imageBlob = addslashes(file_get_contents($_FILES['img']['tmp_name'][$i]));
                $caption = "caption";
                $sql = "INSERT INTO photos (photoCollectionID,name,caption,image, dateUploaded) VALUES ('$photoCollectionId', '$name', '$caption', '$imageBlob', now());";
                $res = mysql_query($sql) or die(mysql_error());
            }
                        
            $sql = "COMMIT;";            
            $res = mysql_query($sql) or die(mysql_error());
            
            header("Location: photos.php");
            exit;
        }
    }

    if($_POST['add_photo_collection'] != ""){
        if (isset($_POST['upload'])) {
            $photoCollectionId = $_POST['add_photo_collection'];

            $count = count($_FILES['img']['name']);
            $sql = "START TRANSACTION;";
            $res = mysql_query($sql);

            for ($i = 0; $i < $count; $i++){
                $name = $_FILES["img"]["name"][$i];
                $imageBlob = addslashes(file_get_contents($_FILES['img']['tmp_name'][$i]));
                $caption = "caption";
                $sql = "INSERT INTO photos (photoCollectionID,name,caption,image, dateUploaded) VALUES ('$photoCollectionId', '$name', '$caption', '$imageBlob', now());";
                $res = mysql_query($sql) or die(mysql_error());
            }
                        
            $sql = "COMMIT;";            
            $res = mysql_query($sql) or die(mysql_error());
            
            header("Location: view_photo_collection.php?action=view&id=".$photoCollectionId);
            exit;
        }
    }

    if($_POST['like_photo_action'] != ""){
        $photoId = $_POST['photoId'];
        $sql = "";
        $likeAction = $_POST['like_photo_action'];
        if($likeAction == "Like")
            $sql = "INSERT INTO photolikes (photoID, userID) VALUES ('$photoId', '$userId')";
        else
            $sql = "DELETE FROM photolikes WHERE photoID = '$photoId' AND userID = '$userId'";
        
        $res = mysql_query($sql) or die(mysql_error());
        header("Location: view_photo.php");
        exit;
    }
?>
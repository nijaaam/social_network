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

if($request == "remove_admin"){
    $userId = $_GET['id'];
    mysql_query("UPDATE users SET isAdmin = FALSE WHERE userId = '$userId'") or die(mysql_error());;
    header("Location: view_profile.php?action=view&id=$userId");
}

if($request == "make_admin"){
    $userId = $_GET['id'];
    mysql_query("UPDATE users SET isAdmin = TRUE WHERE userId = '$userId'") or die(mysql_error());;
    header("Location: view_profile.php?action=view&id=$userId");
}

if($request == "delete_post"){
    $userId = $_GET['id'];
    $postId = $_GET['postId'];
    mysql_query("DELETE FROM blogPosts WHERE postID = '$postId'") or die(mysql_error());
    header("Location: view_profile.php?action=view&id=$userId");
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
        $collectionName = $_POST['new_photo_collection'];
        $sql = "START TRANSACTION;";
        $res = mysql_query($sql);
        $sql = "INSERT INTO photoCollections(userID,name,whoCanSee) VALUES('$userId','$collectionName',0);";
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

        header("Location: view_photo_collection.php?action=view&id=".$photoCollectionId);
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

if(isset($_POST['profile_pic'])){

   $count = count($_FILES['img']['name']);
   $sql = "START TRANSACTION;";
   $res = mysql_query($sql);

   for ($i = 0; $i < $count; $i++){
    $name = $_FILES["img"]["name"][$i];
    $imageBlob = addslashes(file_get_contents($_FILES['img']['tmp_name'][$i]));
    $caption = "caption";
    $sql = "UPDATE personalinfo SET picture='$imageBlob' WHERE userID='$userId'";
    $res = mysql_query($sql) or die(mysql_error());
    }   

    $sql = "COMMIT;";            
    $res = mysql_query($sql) or die(mysql_error());

    header("Location: profile.php");
    exit;
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

if($_POST['delete_photo_comment'] != ""){
    $commentId = $_POST['delete_photo_comment'];
    $sql = "DELETE FROM photocomments WHERE commentId = '$commentId'";

    $res = mysql_query($sql) or die(mysql_error());
    header("Location: view_photo.php");
    exit;
}

if($_POST['delete_post'] != ""){
    $postId = $_POST['delete_post'];
    $sql = "DELETE FROM blogposts WHERE postID = '$postId'";

    $res = mysql_query($sql) or die(mysql_error());
    header("Location: profile.php");
    exit;
}

if($request == "delete_message"){
    $id = $_GET['id'];
    $postId = $_GET['postId'];
    $sql = "DELETE FROM messagecircles WHERE messageID = '$postId'";

    $res = mysql_query($sql) or die(mysql_error());
    header("Location: view_circle.php?action=view&id=".$id);
    exit;
}

if($request == "delete_circle"){
    $circleId = $_GET['circleId'];

    $sql = "START TRANSACTION;";
    $res = mysql_query($sql);
    $sql = "DELETE FROM messagecircles WHERE circleId = '$circleId'";
    $res = mysql_query($sql) or die(mysql_error());
    $sql = "DELETE FROM circlememberships WHERE circleId = '$circleId'";
    $res = mysql_query($sql) or die(mysql_error());
    $sql = "DELETE FROM circles WHERE circleId = '$circleId'";
    $res = mysql_query($sql) or die(mysql_error());
    $sql = "COMMIT";
    $res = mysql_query($sql);

    header("Location: circles.php");
    exit;
}

if($_POST['delete_collection'] != ""){
    $collectionId = $_POST['delete_collection'];

    $sql = "START TRANSACTION;";
    $res = mysql_query($sql);
    $sql = "DELETE FROM photolikes WHERE photoID IN (SELECT photoID FROM photos WHERE photoCollectionID = '$collectionId')";
    $res = mysql_query($sql) or die(mysql_error());
    $sql = "DELETE FROM photocomments WHERE photoID IN (SELECT photoID FROM photos WHERE photoCollectionID = '$collectionId')";
    $res = mysql_query($sql) or die(mysql_error());
    $sql = "DELETE FROM photos WHERE photoCollectionID = '$collectionId'";
    $res = mysql_query($sql) or die(mysql_error());
    $sql = "DELETE FROM photocollections WHERE photoCollectionID = '$collectionId'";
    $res = mysql_query($sql) or die(mysql_error());
    $sql = "COMMIT";
    $res = mysql_query($sql);

    header("Location: photos.php");
    exit;
}

if($_POST['delete_photo'] != ""){
    $photoId = $_POST['delete_photo'];
    $collectionId = $_POST['photo_collection'];

    $sql = "START TRANSACTION;";
    $res = mysql_query($sql);
    $sql = "DELETE FROM photolikes WHERE photoID = '$photoId'";
    $res = mysql_query($sql) or die(mysql_error());
    $sql = "DELETE FROM photocomments WHERE photoID = '$photoId'";
    $res = mysql_query($sql) or die(mysql_error());
    $sql = "DELETE FROM photos WHERE photoID = '$photoId'";
    $res = mysql_query($sql) or die(mysql_error());
    $sql = "COMMIT";
    $res = mysql_query($sql);

    header("Location: view_photo_collection.php?action=view&id=".$collectionId);
    exit;
}

if($_POST['delete_user'] != ""){
    $userProfileId = $_POST['delete_user'];

    $sql = "START TRANSACTION;";
    $res = mysql_query($sql);

    //delete all likes on their photos
    $sql = "DELETE FROM photolikes WHERE photoID IN (SELECT photoID FROM photos WHERE photoCollectionID IN ( SELECT photoCollectionID FROM photocollections WHERE userID='$userProfileId'))";
    $res = mysql_query($sql) or die(mysql_error());

    //delete all comments on their photos
    $sql = "DELETE FROM photocomments WHERE photoID IN (SELECT photoID FROM photos WHERE photoCollectionID IN ( SELECT photoCollectionID FROM photocollections WHERE userID='$userProfileId'))";
    $res = mysql_query($sql) or die(mysql_error());

    //delete all of their likes on other users photos
    $sql = "DELETE FROM photolikes WHERE userID = '$userProfileId'";
    $res = mysql_query($sql) or die(mysql_error());

    //delete all of their comments on other users photos
    $sql = "DELETE FROM photocomments WHERE userID = '$userProfileId'";
    $res = mysql_query($sql) or die(mysql_error());

    //delete their photos
    $sql = "DELETE FROM photos WHERE photoCollectionID IN (SELECT photoCollectionID FROM photocollections WHERE userID='$userProfileId')";
    $res = mysql_query($sql) or die(mysql_error());
   
    //delete all of their photo collections
    $sql = "DELETE FROM photocollections WHERE userID = '$userProfileId'";
    $res = mysql_query($sql) or die(mysql_error());

    //delete all of their relationships
    $sql = "DELETE FROM relationships WHERE userID1 = '$userProfileId' OR userID2 = '$userProfileId'";
    $res = mysql_query($sql) or die(mysql_error());

    //delete all of their security settings
    $sql = "DELETE FROM securitysettings WHERE userID = '$userProfileId'";
    $res = mysql_query($sql) or die(mysql_error());

    //delete all of their personal info
    $sql = "DELETE FROM personalInfo WHERE userID = '$userProfileId'";
    $res = mysql_query($sql) or die(mysql_error());

    //delete all of their blogposts
    $sql = "DELETE FROM blogposts WHERE userID = '$userProfileId'";
    $res = mysql_query($sql) or die(mysql_error());

    //delete all of their general settings
    $sql = "DELETE FROM generalsettings WHERE userID = '$userProfileId'";
    $res = mysql_query($sql) or die(mysql_error());

    //delete all of their messages in message circles
    $sql = "DELETE FROM messagecircles WHERE userID = '$userProfileId'";
    $res = mysql_query($sql) or die(mysql_error());

    //delete all of their circle memberships
    $sql = "DELETE FROM circlememberships WHERE userID = '$userProfileId'";
    $res = mysql_query($sql) or die(mysql_error());

    //delete all of messages in the circels where they are the admin
    $sql = "DELETE FROM messagecircles WHERE circleID IN (SELECT circleID FROM circles where adminUserId = '$userProfileId')";
    $res = mysql_query($sql) or die(mysql_error());

    //delete all circle memberships in the circels where they are the admin
    $sql = "DELETE FROM circlememberships WHERE circleID IN (SELECT circleID FROM circles where adminUserId = '$userProfileId')";
    $res = mysql_query($sql) or die(mysql_error());

    //delete all the circels where they are the admin
    $sql = "DELETE FROM circles WHERE adminUserID = '$userProfileId'";
    $res = mysql_query($sql) or die(mysql_error());

    //delete from the user table
    $sql = "DELETE FROM users WHERE userID = '$userProfileId'";
    $res = mysql_query($sql) or die(mysql_error());

    $sql = "COMMIT";
    $res = mysql_query($sql);

    if($userId == $userProfileId) {
        header("Location: logout.php?logout");
    } else {
        header("Location: friends.php");
    }
    exit;
}
?>

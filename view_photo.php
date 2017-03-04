
<?php
    ob_start();
    session_start();
    require_once 'dbconnect.php';

    // if session is not set this will redirect to login page
    if( !isset($_SESSION['user']) ) {
        header("Location: index.php");
        exit;
    }
    // select loggedin users detail
    $email = $_SESSION['email'];
    $userId = $_SESSION['user'];
    $image = "";
    $photoId = "";
    $photoCollectionAdminId = "";
    if($_POST['view_photo'] != ""){
        $image = $_POST['view_photo'];
        $photoId = $_POST['photoId'];
        $photoCollectionAdminId = $_POST['photoAdminId'];
    }
    else if($image == "" && $_SESSION['image'] != ""){
        $image = $_SESSION['image'];
        $photoId = $_SESSION['photoId'];
        $photoCollectionAdminId = $_POST['photoAdminId'];
    }
    else{
        header("Location: photos.php");
        exit;
    }

    $sql = mysql_query("SELECT * FROM relationships WHERE invitationAccepted = 1 AND userID1 = ".$userId." AND userID2 =".$photoCollectionAdminId);
    $row = mysql_fetch_array($sql, MYSQL_NUM);
    $friend = $row[0];
    $canComment = $friend || $userId == $photoCollectionAdminId;

    $sql = mysql_query("SELECT * FROM photolikes WHERE photoID =".$photoId." AND userID =".$userId);
    $row = mysql_fetch_array($sql, MYSQL_NUM);
    $liked = $row[0];
    $likeAction = "";
    if($liked)
        $likeAction = "Unlike";
    else
        $likeAction = "Like";

    $sql = mysql_query("SELECT COUNT(*) FROM `photolikes` WHERE photoID =".$photoId);
    $row = mysql_fetch_array($sql, MYSQL_NUM);
    $likeNo = $row[0];
    $likeCountHeader = "";
    if(!$likeNo)
        $likeNo = "0";
    if($like == 1)
        $likeCountHeader = $likeNo." like";
    else
        $likeCountHeader = $likeNo." likes";

    require_once 'check_admin.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Social Network</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/font-awesome.css" rel="stylesheet">
  </head>

  <body>

    <nav class="navbar navbar-default">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
            
        <a class="navbar-brand" href="#">Social Network</a>

        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="profile.php">My Profile</a></li>
            <li><a href="friends.php">Friends</a></li>
            <li><a href="circles.php">Circles</a></li>
            <li class="active"><a href="photos.php">Photos</a></li>
            <li><a href="search.php">Search</a></li>
          </ul>
            
            <ul class="nav navbar-nav navbar-right">
                <?php
                if($isAdmin) {
                    echo "<li><p class=\"navbar-text\">Logged in as Administrator </p></li>";
                }
                ?>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                  <span class="glyphicon glyphicon-user"></span>&nbsp;<?php echo $email ?>&nbsp;<span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>
                  </ul>
                </li>
            </ul>
            
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <section>
      <div class="container">
        <div class="row">
          <div class="col-md-8">
            <div class="profile">
                
              <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <span style="color:white;"><?php echo $likeCountHeader ?></span>
                            <span style="float:right; font-family:sans-serif">
                                <form method="post" action="functions.php">
                                    <input type="hidden" name="photoId" value="<?php echo $photoId ?>"/>    
                                    <input type="hidden" name="like_photo_action" value="<?php echo $likeAction ?>"/>    
                                    <button type="submit" class="btn-primary"><?php echo " ".$likeAction?></button>
                                </form>
                            </span>
                        </div>
                        <div class="panel-body" style="overflow: auto;" >
                            <img class="resize" style="max-width:500px; margin: 0 auto" src="<?php echo $image?>" />
                        </div>
                    </div>
                </div>
                  
              </div><br>
                
              <div class="row">
                <div class="col-md-12">
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h3 class="panel-title">Comments</h3>
                    </div>
                  <?php 
                    if($canComment){
                    ?>
                    <div class="panel-body">
                        <form name="blogPhotoCommentForm" action="functions.php" method="post" onsubmit="return validateInput()">
                          <div class="form-group">
                            <textarea name="post_photo_comment" class="form-control" placeholder="Write post"></textarea>
                            <input type="hidden" name="photoId" value="<?php echo $photoId ?>"/>
                            <?php 
                                $_SESSION['image'] = $image;
                                $_SESSION['photoId'] = $photoId;
                              ?>
                          </div>
                          <button type="submit" class="btn btn-default">Post</button>
                        </form>
                    </div>
                    <?php
                    }
                    ?>
                  </div>
                    
                  <div class="panel panel-default post">
                    <div class="panel-body">
              
                    <?php 
                        $query = "SELECT comment, dateTime, u.userID, firstName, surname FROM photocomments as p, users as u, personalinfo as pi WHERE photoID ='".$photoId."' AND u.userID = p.userID AND p.userID = pi.userID ORDER BY dateTime ASC";  
                        $sql = mysql_query($query);
                        while ($row = mysql_fetch_array($sql, MYSQL_NUM)) { 
                            $comment = $row[0];
                            $timeSent = $row[1];
                            $commentUserId = $row[2];
                            $fullName = $row[3]." ".$row[4];
                            $myDateTime = DateTime::createFromFormat('Y-m-d H:i:s', $timeSent);
                            $timeSent = $myDateTime->format('d/m/Y H:i:s');
                    ?> 
                         <div class="row">
                           <div class="col-sm-2">
                             <a href="view_profile.php?action=view&id=<?php echo $commentUserId?>" class="post-avatar thumbnail"><img src="img/user.png" alt=""><div class="text-center"><?php echo $fullName ?></div></a>
                           </div>
                           <div class="col-sm-10">
                             <div class="bubble">
                               <div class="pointer">
                                 <p><?php echo $comment ?></p>
                               </div>
                               <div class="pointer-border"></div>
                               <p class="post-actions" style="text-align:right"><a href="#"><?php echo $timeSent ?></a></p>
                             </div>
                           </div>
                         </div>             
                    <?php  
                        }
                    ?>  
                  </div>
                </div>                       
                    
                </div>
              </div>
            </div>
          </div>
     
        </div>
            
      </div>
    </section>
    <footer>
      <div class="container">
        <p>Group 3 Social Network; Osman Ahmed, Nijamudeen Abubacker, Shivam Dhall, Bagus Maulana</p>
      </div>
    </footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="js/bootstrap.js"></script>
  </body>
</html>
<script>
function validateInput(){
    var a = document.forms["blogPhotoCommentForm"]["post_photo_comment"].value;
    
    if (a == ""){
        alert("Comment cannot be empty.");
        return false;
    }
}
</script>
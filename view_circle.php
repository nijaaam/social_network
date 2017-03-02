
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
    if (empty($_GET)){
        header("Location: circles.php");
        exit;
    }
    $email = $_SESSION['email'];
    $userId = $_SESSION['user'];
    require_once 'check_admin.php';
    $circleId = $_GET['id'];

    $res = mysql_query("SELECT circleID FROM circlememberships, users WHERE users.userID = ".$userId." AND circlememberships.userID = ".$userId." AND circleID=".$circleId) or die (mysql_error());
    $userRow=mysql_fetch_array($res);    
    // Checks if user is in this circle. If not redirects to circles.php
    if(!$userRow['circleID']){
        header("Location: circles.php");
        exit;
    }
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
            <li class="active"><a href="circles.php">Circles</a></li>
            <li><a href="photos.php">Photos</a></li>
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
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Circle Message Centre</h3>
              </div>
              <div class="panel-body">
                <form name="sendMessage" action="functions.php" method="post" onsubmit="return validateInput()">
                  <div class="form-group">
                    <textarea name="send_message_circle" class="form-control" placeholder="Write message"></textarea>
                  </div>
                  <input type="hidden" name="circleID" value="<?php echo $circleId?>"/>
                  <button type="submit" class="btn btn-default">Send message</button>
                </form>
              </div>
            </div>
              
            <div class="panel panel-default post">
               <div class="panel-body">
              
            <?php 
                $query = "SELECT pi.userID, message, timeSent, firstName, surname FROM messagecircles as mc, personalinfo as pi WHERE pi.userID = mc.userID AND mc.circleID =".$circleId." ORDER BY timeSent DESC";  
                $sql = mysql_query($query);
                while ($row = mysql_fetch_array($sql, MYSQL_NUM)) { 
                    $id = $row[0];
                    $firstName = $row[3];
                    $surname = $row[4];
                    $fullName = $firstName." ".$surname;
                    $message = $row[1];
                    $timeSent = $row[2];
                    $myDateTime = DateTime::createFromFormat('Y-m-d H:m:s', $timeSent);
                    $timeSent = $myDateTime->format('d/m/Y H:m');
            ?> 
                 <div class="row">
                   <div class="col-sm-2">
                     <a href="view_profile.php?action=view&id=<?php echo $id?>" class="post-avatar thumbnail"><img src="img/user.png" alt=""><div class="text-center"><?php echo $fullName ?></div></a>
                   </div>
                   <div class="col-sm-10">
                     <div class="bubble">
                       <div class="pointer">
                         <p><?php echo $message ?></p>
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
               
          <div class="col-md-4">
            <div class="panel panel-default friends">
              <div class="panel-heading">
                <h3 class="panel-title">Circle members</h3>
              </div>
            <?php 
                $query = "SELECT adminUserId FROM circles WHERE circleID =".$circleId;  
                $sql = mysql_query($query);
                $row = mysql_fetch_array($sql, MYSQL_NUM);
                // If they are the admin of the circle
                if($row[0] == $userId){
            ?>
                  <div class="panel-body">
                    <form action="edit_friend_circle.php" method="post">
                        <div style="text-align:center">
                          <input type="hidden" name="modify_friend_circle" value="<?php echo $circleId ?>" />
                          <button type="submit" class="btn btn-primary" >Modify friend circle</button>
                        </div>
                    </form>
                  </div>
            <?php
                }
            ?>
                
              <div class="panel-body">
                <?php
                $query = "SELECT personalinfo.userID, firstName, surname FROM personalinfo JOIN circlememberships ON personalinfo.userID = circlememberships.userID WHERE circleID =".$circleId;  
                $sql = mysql_query($query);
                while ($row = mysql_fetch_array($sql, MYSQL_NUM)) { 
                    $id = $row[0];
                    $firstName = $row[1];
                    $surname = $row[2];
                    $fullName = $firstName." ".$surname;
                ?>
                    <ul>
                        <li>
                            <div style="width: 50px;margin: 0 auto;">
                              <img src="img/user.png" class="img-thumbnail" alt="">
                              <div class="text-center">
                                  <a href="view_profile.php?action=view&id=<?php echo $id?>"><?php echo $fullName ?></a>
                              </div>
                            </div>
                        </li>
                <?php
                }  
                ?>
                </ul>
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
    var a = document.forms["sendMessage"]["send_message_circle"].value;
    
    if (a == ""){
        alert("Message cannot be empty.");
        return false;
    }
}
</script>
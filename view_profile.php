
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
    $profileUserId = $_GET['id'];
    if($userId == $profileUserId){
        header("Location: profile.php");
        exit; 
    }

    $res = mysql_query("SELECT securitysettings.*, relationships.invitationAccepted FROM securitysettings LEFT JOIN relationships ON userID=$userId WHERE (userID1 = $userId AND userID2 =$profileUserId)");
//    $res = mysql_query("SELECT * FROM securitysettings WHERE userID=".$profileUserId);
    $row = mysql_fetch_array($res) or die (mysql_error());
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Social Network: User Profile Page</title>

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
            <li><a href="photos.php">Photos</a></li>
            <li><a href="search.php">Search</a></li>
          </ul>
            
            
            <ul class="nav navbar-nav navbar-right">            
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                  <span class="glyphicon glyphicon-user"></span>&nbsp;<?php echo $email; ?>&nbsp;<span class="caret"></span></a>
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
              <h1 class="page-header"><?php echo $userRow['firstName']." ".$userRow['surname'];?></h1>
              <div class="row">
                <div class="col-md-4">
                  <img src="img/user.png" class="img-thumbnail" alt="">
                </div>
                  
                <div class="col-md-8">
                    <ul>
                  
                  <?php
                    if($row['whoCanSeeProfile'] == 0 || ($row['whoCanSeeProfile'] == 1 && $row['invitationAccepted'])){
                        $query = "SELECT personalinfo.*, users.email FROM personalinfo, users WHERE personalinfo.userID='$profileUserId' AND users.userID = '$profileUserId'";
                        $res=mysql_query($query) or die(mysql_error());
                        $userRow=mysql_fetch_array($res);    
                    ?>
                        <li><strong>Name: </strong><?php echo $userRow['firstName']." ".$userRow['surname'] ;?></li>
                        <li><strong>Email: </strong><?php echo $userRow['email'];?></li>
                        <li><strong>City: </strong><?php echo $userRow['city'];?></li>
                        <li><strong>Country: </strong><?php echo $userRow['country'];?></li>
                        <li><strong>Gender: </strong><?php echo $userRow['gender'];?></li>
                        <li><strong>DOB: </strong><?php                                     
                                        $myDateTime = DateTime::createFromFormat('Y-m-d', $userRow['birthday']);
                                        echo $myDateTime->format('d M Y'); ?></li>
                  <?php       
                    }
                    else{
                  ?>
                        <li><strong>You don't have the necessary privileges to view the profile</strong></li>
                  <?php
                    }
                   ?>
                      </ul>
                    </div>
                  
                  
              </div><br><br>
              <div class="row">
                <div class="col-md-12">
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h3 class="panel-title">Blog Wall</h3>
                    </div>
                    <div class="panel-body">
                        
                    <?php
                        if($row['whoCanSeeBlog'] == 0 || ($row['whoCanSeeBlog'] == 1 && $row['invitationAccepted'])){
//                            $query = "SELECT personalinfo.*, users.email FROM personalinfo, users WHERE personalinfo.userID='$profileUserId' AND users.userID = '$profileUserId'";
//                            $res=mysql_query($query) or die(mysql_error());
//                            $userRow=mysql_fetch_array($res);    
                    ?>    
                              <form>
                                <div class="form-group">
                                  <textarea class="form-control" placeholder="Write on the wall"></textarea>
                                </div>
                                <button type="submit" class="btn btn-default">Submit</button>
                              </form>
                    <?php       
                        }
                        else{
                      ?>
                            <li><strong>You don't have the necessary privileges to view the blog</strong></li>
                    <?php
                        }
                   ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
            
          <div class="col-md-4">
            <div class="panel panel-default friends">
              <div class="panel-heading">
                <h3 class="panel-title">My Friends</h3>
              </div>
              <div class="panel-body">
                <div style="text-align:center">
                  <a  class="btn btn-primary" href="friends.php">View All Friends</a>
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


<?php
    ob_start();
    session_start();
    require_once 'dbconnect.php';

    // if session is not set this will redirect to login page
    if( !isset($_SESSION['user']) ) {
        header("Location: index.php");
        exit;
    }
    $userId = $_SESSION['user'];
    // select loggedin users detail
    $query = "SELECT personalinfo.*, users.email FROM personalinfo, users WHERE personalinfo.userID='$userId' AND users.userID = '$userId'";
    $res=mysql_query($query) or die(mysql_error());
    $userRow=mysql_fetch_array($res);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Social Network: Profile Page</title>

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
            <li><a href="index.php">Home</a></li>
            <li><a href="friends.php">Friends</a></li>
            <li><a href="groups.php">Groups</a></li>
            <li><a href="photos.php">Photos</a></li>
            <li class="active"><a href="profile.php">Profile</a></li>
            <li><a href="search.php">Search</a></li>
          </ul>
            
            
            <ul class="nav navbar-nav navbar-right">            
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                  <span class="glyphicon glyphicon-user"></span>&nbsp;<?php echo $userRow['email']; ?>&nbsp;<span class="caret"></span></a>
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
                    <li><strong>Name: </strong><?php echo $userRow['firstName']." ".$userRow['surname'] ;?></li>
                    <li><strong>Email: </strong><?php echo $userRow['email'];?></li>
                    <li><strong>City: </strong><?php echo $userRow['city'];?></li>
                    <li><strong>Country: </strong><?php echo $userRow['country'];?></li>
                    <li><strong>Gender: </strong><?php echo $userRow['gender'];?></li>
                    <li><strong>DOB: </strong><?php                                     
                                    $myDateTime = DateTime::createFromFormat('Y-m-d', $userRow['birthday']);
                                    echo $myDateTime->format('d M Y'); ?></li>
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
                      <form>
                        <div class="form-group">
                          <textarea class="form-control" placeholder="Write on the wall"></textarea>
                        </div>
                        <button type="submit" class="btn btn-default">Submit</button>
                      </form>
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
              <div class="panel panel-default friends">
              <div class="panel-heading">
                <h3 class="panel-title">Privacy Settings</h3>
              </div>
                  
              <?php
                  $res = mysql_query("SELECT * FROM securitysettings WHERE userID=".$_SESSION['user']);
                  $userRow = mysql_fetch_array($res);
                  $whoCanSeeBlogValue = $userRow['whoCanSeeBlog'];
                  $whoCanSeeProfileValue = $userRow['whoCanSeeProfile'];
                  $whoCanSeeOptions = array("Everyone", "Friends", "Only Me");
                  // in database they are represented by tinyint values; 0,1,2 respectively
                  
                  $whoCanSeeBlogText = $whoCanSeeOptions[$whoCanSeeBlogValue];
                  $whoCanSeeProfileText = $whoCanSeeOptions[$whoCanSeeProfileValue];
                                    
//                  $whoCanSendFriendRequests = $userRow['whoCanSendFriendRequests'];
//                  $whoCanSendFriendRequestsOptions = array("Everyone", "Friends of friends");
                  
                  // Will deal with these cases later if we have time
                  $visibleName = $userRow['visibleName'];
                  $visiblePersonalInfo = $userRow['visiblePersonalInfo'];
                  // By default values are equal to 0 which means everyone has these visibility priveleges.   
                  
              ?>
                  
              <div class="panel-body">
                <div style="text-align:center">
                    <div class="row member-row">
                        <div class="col-md-6">
                            <div>Who can see your profile?</div>
                        </div>
                        <div class="col-md-3">
                            <div class="dropdown">
                              <button class="btn btn-default dropdown-toggle" style="display:inline-block;" type="button" data-toggle="dropdown"><?php echo $whoCanSeeProfileText; ?>
                              <span class="caret"></span></button>
                                  <ul class="dropdown-menu">
                                    <?php
                                      $sizeofarray = sizeof($whoCanSeeOptions);
                                      for($i = 0; $i < $sizeofarray; $i++){
                                          if($i == $whoCanSeeProfileValue){
                                              ?>
                                              <li class="disabled"><a href="#"><?php echo $whoCanSeeProfileText ?></a></li>
                                    <?php
                                          }
                                          else{
                                    ?>   
                                              <li><a href="functions.php?action=view&request=change_privacy&option=profileView&value=<?php echo $i?>"><?php echo $whoCanSeeOptions[$i] ?></a></li>
                                    <?php        
                                          }
                                      }
                                    ?>                  
                                  </ul>

                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row member-row">
                        <div class="col-md-6">
                            <div>Who can see your blog?</div>
                        </div>
                        <div class="col-md-3">
                            <div class="dropdown">
                              <button class="btn btn-default dropdown-toggle" style="display:inline-block;" type="button" data-toggle="dropdown"><?php echo $whoCanSeeBlogText; ?>
                              <span class="caret"></span></button>
                                  <ul class="dropdown-menu">
                                    <?php
                                      $sizeofarray = sizeof($whoCanSeeOptions);
                                      for($i = 0; $i < $sizeofarray; $i++){
                                          if($i == $whoCanSeeBlogValue){
                                              ?>
                                              <li class="disabled"><a href="#"><?php echo $whoCanSeeBlogText ?></a></li>
                                    <?php
                                          }
                                          else{
                                    ?>   
                                              <li><a href="functions.php?action=view&request=change_privacy&option=blogView&value=<?php echo $i?>"><?php echo $whoCanSeeOptions[$i] ?></a></li>
                                    <?php        
                                          }
                                      }
                                    ?>                  
                                  </ul>

                            </div>
                        </div>
                    </div>
                </div>
              </div>
              <div class="panel-body">
                
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

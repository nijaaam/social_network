
<?php
    ob_start();
    session_start();
    require_once 'dbconnect.php';
    require_once 'functions.php';

    // if session is not set this will redirect to login page
    if( !isset($_SESSION['user']) ) {
        header("Location: index.php");
        exit;
    }
    // select loggedin users detail
    $email = $_SESSION['email'];
    $userId = $_SESSION['userId'];
    require_once 'check_admin.php';

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Social Network: Friends Page</title>

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
            <li class="active"><a href="friends.php">Friends</a></li>
            <li><a href="circles.php">Circles</a></li>
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
            <div class="members">
              <h1 class="page-header">Friends</h1>
                  <?php
                    $friends = array();
                    $userId = $_SESSION['user'];
                    $query1 = "SELECT userID2 FROM relationships WHERE userID1 = $userId and invitationAccepted = 1";
                    $query2 = "SELECT userID1 FROM relationships WHERE userID2 = $userId and invitationAccepted = 1";
                    $result1 = mysql_query($query1) or die(mysql_error());
                    $result2 = mysql_query($query2) or die(mysql_error());
                    while ($row = mysql_fetch_array($result1)){
                      array_push($friends, $row['userID2']);
                    }
                    while ($row = mysql_fetch_array($result2)){
                      array_push($friends, $row['userID1']);
                    }
                    $result = array_unique($friends);
                    foreach ($result as $val) {
                        $id = $val;
                        $name = mysql_query("SELECT CONCAT(firstName,' ', surname), picture from personalinfo WHERE userID = $id");
                        $row = mysql_fetch_array($name);
                        $fullName = $row[0];
                        $content = base64_encode($row[1]);
                        $image = "data:image/jpeg;base64,". $content;
                        if($content == ""){
                          $image = "img/user.png";
                        }
                        $headerName = $fullName . "'s Friends";
                        ?>
                        <div class="row member-row">
                          <div class="col-md-3">
                            <img src="<?php echo "$image"; ?>" class="img-thumbnail" alt="">
                            <div class="text-center"><?php echo $fullName ?></div>
                          </div>
                          <div class="col-md-3">
                            <p><a href="view_profile.php?action=view&id=<?php echo $id?>" class="btn btn-primary btn-block"><i class="fa fa-edit"></i> View Profile</a></p>
                          </div>
                          <div class="col-md-3">
                            <p><a href="search.php?action=view&search_friends_of_friends=<?php echo $id?>&header=<?php echo $headerName ?>" class="btn btn-default btn-block"><i class="fa fa-users"></i> View Friends</a></p>
                          </div>
                        </div>
                        <?php
                    }
                  ?>
              </div>
          </div>
            
          <div class="col-md-4">
              <br><br><br>
            <div class="panel panel-default friends">
              <div class="panel-heading">
                <h3 class="panel-title">Friend requests</h3>
              </div>
              <div class="panel-body">
                  <?php
                  $userId = $_SESSION['user'];
                  $query = "select * from relationships WHERE invitationAccepted = 0 AND userID2 = '$userId'";
                  $result = mysql_query($query) or die(mysql_error());
                  while($row = mysql_fetch_array($result)){
                    $id = $row['userID1'];
                    $name = mysql_query("SELECT CONCAT(firstName,' ', surname) from personalinfo WHERE userID = $id");
                    $fullName = mysql_fetch_array($name)[0];
                    ?>
                    <ul>
                      <div class="row member-row">
                        <div class="col-md-3">
                          <img src="img/user.png" class="img-thumbnail" alt="">
                          <div class="text-center"><?php echo $fullName ?></div>
                        </div>
                        <div class="col-md-3">
                          <p><a href="functions.php?action=view&request=accept_friend_request&id=<?php echo $id?>" class="btn btn-success btn-block"><i class="fa fa-check-circle"></i></a></p>
                        </div>
                        <div class="col-md-3">
                          <p><a href="functions.php?action=view&request=reject_friend_request&id=<?php echo $id?>" class="btn btn-danger btn-block"><i class="fa fa-remove"></i></a></p>
                        </div>
                      </div>
                    </ul>
                    <?php
                  }
                  ?>
              </div>
            </div>
              
            <div class="panel panel-default friends">
              <div class="panel-heading">
                <h3 class="panel-title">Pending sent requests</h3>
              </div>
              <div class="panel-body">
                <ul>
                  <?php
                    $userId = $_SESSION['user'];
                    $query = "select * from relationships WHERE invitationAccepted = 0 AND userID1 = '$userId'";
                    $result = mysql_query($query) or die(mysql_error());
                    while($row = mysql_fetch_array($result)){
                      $id = $row['userID2'];
                      $name = mysql_query("SELECT CONCAT(firstName,' ', surname) from personalinfo WHERE userID = $id");
                      $fullName = mysql_fetch_array($name)[0];
                      ?>
                      <ul>
                        <li>
                          <div style="width: 50px;margin: 0 auto;">
                            <img src="img/user.png" class="img-thumbnail" alt="">
                              <div class="text-center"><?php echo $fullName?></div>
                          </div>
                        </li>
                      </ul>
                      <?php }
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

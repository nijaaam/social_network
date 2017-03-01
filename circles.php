
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
    $userId = $_SESSION['userId'];
    require_once 'check_admin.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Social Network: Circles Page</title>

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
            <div class="groups">
              <h1 class="page-header">Circles</h1>
                <?php 
                    $sql = mysql_query("SELECT circleID, name FROM circles WHERE circleID IN (SELECT circleID FROM `circlememberships` WHERE userID = '".$_SESSION['user']."')") or die (mysql_error());
                    while ($row = mysql_fetch_array($sql, MYSQL_NUM)) { 
                        $circleId = $row[0];
                        $circleName = $row[1];
                ?>
                      <div class="group-item">
                            <img src="img/group.png" alt="">
                            <h3>&nbsp;&nbsp;&nbsp;<a href="view_circle.php?action=view&id=<?php echo $circleId?>"><?php echo $circleName?></a></h3>
                      </div>
                      <div class="clearfix"></div>
                <?php
                    }
                ?>
            </div>
          </div>   
          <div class="col-md-4">
              <br><br><br><br>
            <div class="panel panel-default friends">
              <div class="panel-heading">
                <h3 class="panel-title">Create new circle</h3>
              </div>
              <div class="panel-body">
                <ul>
                    <li>         
                        <form name="new_circle" method="POST" action="edit_friend_circle.php" onsubmit="return validateInput()" autocomplete="off">
                            <div class="form-group" style="max-width:300px">
                                <div class="input-group col-md-12">
                                    <input type="text" name="friend_circle_title" class="form-control input-md" placeholder="Enter friend circle title" />
                                    <span class="input-group-btn">
                                        <button class="btn btn-info btn-md" type="submit">
                                            <i class="glyphicon glyphicon-edit"></i>
                                        </button>
                                </div>
                            </div>        
                        </form>
                    </li>
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
    var a = document.forms["new_circle"]["friend_circle_title"].value;
    
    if (a == ""){
        alert("Friend circle must be given a name.");
        return false;
    }
}
</script>

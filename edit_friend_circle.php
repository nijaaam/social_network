
<?php
    ob_start();
    session_start();
    require_once 'dbconnect.php';

    // if session is not set this will redirect to login page
    if( !isset($_SESSION['user']) ) {
        header("Location: index.php");
        exit;
    }else if(empty($_POST)){
        header("Location: circles.php");
        exit;
    }
    // select loggedin users detail
    $userId = $_SESSION['user'];
    $email = $_SESSION['email'];

    $header = "";
    if($_POST['friend_circle_title'] != ""){
        $header = $_POST['friend_circle_title'];
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
        
        $lastElement = end($friendIdsList);
        foreach($friendIdsList as $friendId) {
            $sql = $sql."(".$circleId.",".$friendId.")";
            if($friendId != $lastElement)
                $sql = $sql.",";
        }
        
        $res = mysql_query($sql);
        $sql = "COMMIT;";            
        $res = mysql_query($sql) or die(mysql_error());
        
        if($res){
            header("Location: circles.php");
            exit;
        }
    }
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
      
    <?php 
        $sql = mysql_query(" SELECT userID, firstName, surname FROM personalinfo, relationships WHERE (userID1 = '".$_SESSION['user']."' AND userID2 = userID AND invitationAccepted = 1)") or die (mysql_error()); 
            $array = array();
            while ($row = mysql_fetch_array($sql, MYSQL_NUM)) {
                $array[] = $row;
            }
    ?>  
      
    <section>
      <div class="container">
        <div class="row">
          <div class="col-md-8">
            <div class="groups">
              <h1 class="page-header"><?php echo $header; ?>: Add friends to circle</h1>
            
              <?php 
                  if(empty($array)){
              ?>  
                  <font color='red' size='4' >No friends found.</font>
              <?php 
                  }
                  else{
              ?>  
                  <form action="edit_friend_circle.php" method="post">
                      <?php
                      foreach ($array as $v) {
                          $friendId = $v[0];
                          $firstName = $v[1];
                          $surname = $v[2];
                      ?>            
                        <input type="checkbox" name="<?php echo $friendId ?>" value="<?php echo $friendId ?>">&nbsp;&nbsp;<?php echo $firstName." ".$surname ?><br>

                <?php              
                      }
                  }
                ?>        
                        <br>
                        <input type="hidden" name="header" value="<?php echo $header ?>"/>
                        <input type="hidden" name="add_friend_circle" value="submit"/>
                        <input type="submit" id="submit" class="btn btn-info" value="Submit">
                    </form>
                <div class="clearfix"></div>
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

<script type="text/javascript">
    $(document).ready(function () {
        $('#submit').click(function() {
          checked = $("input[type=checkbox]:checked").length;

          if(!checked) {
            alert("You must select at least one friend.");
            return false;
          }

        });
    });
</script>
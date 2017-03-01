
<?php
    ob_start();
    session_start();
    require_once 'dbconnect.php';
	include("search_results.php");

    // if session is not set this will redirect to login page
    if( !isset($_SESSION['user']) ) {
        header("Location: index.php");
        exit;
    }
    // select loggedin users detail
    $email = $_SESSION['email'];
    $userId = $_SESSION['userId'];
    require_once 'check_admin.php';

    $header = "Search results";
    if($_GET['header'] != ""){
        $header = $_GET['header'];
    }
    else if($_POST['search_friends'] != ""){
        $searchQuery = $_POST['search_friends'];
        $header = "Search results for: '".$searchQuery."'";
    }
    else if(empty($_GET) && empty($_POST)){
        $header = "Suggested friends";
    }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Social Network: Members Page</title>

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
            <li class="active"><a href="search.php">Search</a></li>
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
  
    <nav class="navbar ">
      <div class="container">
            <ul class="nav navbar-nav">
                
            <li>         
                <form name="searchAll" method="POST" action="search.php" autocomplete="off">
                    <div class="form-group" style="max-width:300px">
                        <div class="input-group col-md-12">
                            <input type="text" name="search_friends" class="form-control input-md" placeholder="Search all users" />
                            <span class="input-group-btn">
                                <button class="btn btn-info btn-md" type="submit">
                                    <i class="glyphicon glyphicon-search"></i>
                                </button>
                        </div>
                    </div>        
                </form>
            </li>
            </ul>
      </div>
    </nav> 
       
    <section>
      <div class="container">
        <div class="row">
          <div class="col-md-8">
            <div class="members">
              <h1 class="page-header"><?php echo $header ?></h1>
                
                <?php
                    if(isset($_POST['search_friends'])){
                        // Search by search query
                        $search_term = $_POST['search_friends'];
                        search_members($search_term, 0);
                    }else if(isset($_GET['search_friends_of_friends'])){
                        // Search by friends of friends
                        $id = $_GET['search_friends_of_friends'];
                        search_members(0, $id);
                    }else{
                        // Default search on search page. "Suggested friends".
                        // This is where you put your collaborative filtering method of finding friends.
                        search_members(-1,-1);
                    }
                ?>

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

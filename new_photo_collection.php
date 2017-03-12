
<?php
ob_start();
session_start();
require_once 'dbconnect.php';
include_once 'validation_functions.php';

    // if session is not set this will redirect to login page
if( !isset($_SESSION['user']) ) {
  header("Location: index.php");
  exit;
}else if(empty($_POST)){
  header("Location: photos.php");
  exit;
}
    // select loggedin users detail
$userId = $_SESSION['user'];
$email = $_SESSION['email'];
require_once "check_admin.php";

$header = "";
if($_POST['photo_collection_title'] != ""){
  $header = clean_data('photo_collection_title');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Social Network: Photo Collections</title>

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
            <div class="groups">
              <h1 class="page-header"><?php echo $header; ?></h1>
              <form name="uploadImageForm" method="POST" action="functions.php" enctype="multipart/form-data" onsubmit="return validateImage()">
                <h4 style="color:#337ab7;">Select a picture to upload in this collection</h4>
                <input type="hidden" name="new_photo_collection" value="<?php echo $header; ?>"/>
                <div class="form-group">
                <input type="file" multiple="multiple" name="img[]">
                </div>
                <button type="submit" name="upload" class="btn btn-default">Upload</button>
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

    function validateImage(){
      var filename = document.forms["uploadImageForm"]["img[]"].value;
      if(filename == ""){
        alert("Please select an image to upload");
        return false;
      }
      else{
        var extension = filename.split('.').pop();
        if(extension == "jpeg" || extension == "png" || extension == "jpg" || extension == "gif"){
          return true;
        }
      }
      alert("The format of the file selected is not allowed\n\n File formats allowed are JPG, JPEG, GIF, PNG ");
      return false;
    }
  </script>
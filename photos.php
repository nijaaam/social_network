
<?php
    ob_start();
    session_start();
    require_once 'dbconnect.php';
    if (isset($_POST['upload'])) {
        $name=$_FILES["img"]["name"]; 
        $content=addslashes(file_get_contents($_FILES['img']['tmp_name']));
        $date = "2015-01-01";
        $insert_image="INSERT INTO photos (photoCollectionID,name,string,caption,dateUploaded,image) VALUES(0,'$name','stri','cap','$date','$content');";
        //mysql_query("INSERT INTO photocollection (userID) values(28)");
        mysql_query($insert_image) or die("Error in query: $query. ".mysql_error());
    }
    // if session is not set this will redirect to login page
    if( !isset($_SESSION['user']) ) {
        header("Location: index.php");
        exit;
    }
    // select loggedin users detail
    $email = $_SESSION['email'];
    $userId = $_SESSION['userId'];

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Social Network: Photos Page</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/font-awesome.css" rel="stylesheet">
    <link href="css/ekko-lightbox.css" rel="stylesheet">

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
            <h1 class="page-header">Photos</h1>
            <form method="POST" enctype="multipart/form-data">
              <input type="file" name="img">
              <input type="submit" name="upload" value="Upload">
              </form>
            <ul class="photos gallery-parent">
              <li><a href="img/sample1.jpg" data-hover="tooltip" data-placement="top" title="image" data-gallery="mygallery" data-parent=".gallery-parent" data-title="title" data-footer="this is a footer" data-toggle="lightbox"><img src="img/sample1.jpg" class="img-thumbnail" alt=""></a></li>
              <li><a href="img/sample2.jpg" data-hover="tooltip" data-placement="top" title="image" data-gallery="mygallery" data-parent=".gallery-parent" data-title="title" data-footer="this is a footer" data-toggle="lightbox"><img src="img/sample2.jpg" class="img-thumbnail" alt=""></a></li>
              <li><a href="img/sample3.jpg" data-hover="tooltip" data-placement="top" title="image" data-gallery="mygallery" data-parent=".gallery-parent" data-title="title" data-footer="this is a footer" data-toggle="lightbox"><img src="img/sample3.jpg" class="img-thumbnail" alt=""></a></li>
              <li><a href="img/sample4.jpg" data-hover="tooltip" data-placement="top" title="image" data-gallery="mygallery" data-parent=".gallery-parent" data-title="title" data-footer="this is a footer" data-toggle="lightbox"><img src="img/sample4.jpg" class="img-thumbnail" alt=""></a></li>
              <li><a href="img/sample5.jpg" data-hover="tooltip" data-placement="top" title="image" data-gallery="mygallery" data-parent=".gallery-parent" data-title="title" data-footer="this is a footer" data-toggle="lightbox"><img src="img/sample5.jpg" class="img-thumbnail" alt=""></a></li>
              <li><a href="img/sample6.jpg" data-hover="tooltip" data-placement="top" title="image" data-gallery="mygallery" data-parent=".gallery-parent" data-title="title" data-footer="this is a footer" data-toggle="lightbox"><img src="img/sample6.jpg" class="img-thumbnail" alt=""></a></li>
              <?php
                    $query = "SELECT * FROM photos where photoCollectionID = (SELECT photoCollectionID FROM photocollection WHERE userID = 28);";
                    $res = mysql_query($query) or die("Error in query: $query. ".mysql_error());
                    while($row=mysql_fetch_array($res))
                    {
                     $image_name=$row["name"];
                     
                     $image_content = base64_encode($row["image"]);
                     $image = "data:image/jpeg;base64,".$image_content;
                     echo "<li><a href='$image' data-hover='tooltip' data-placement='top' title='image' data-gallery='mygallery' data-parent='.gallery-parent' data-title='title' data-footer='this is a footer' data-toggle='lightbox'>"; 
                     echo '<img src="data:image/jpeg;base64,'. $image_content .'" alt = " "/>';
                     echo '</a></li>';
                    }
                  ?>
            </ul>
          </div>
          <div class="col-md-4">
            <div class="panel panel-default friends">
              <div class="panel-heading">
                <h3 class="panel-title">My Friends</h3>
              </div>
              <div class="panel-body">
                <ul>
                  <li><a href="profile.html" class="thumbnail"><img src="img/user.png" alt=""></a></li>
                  <li><a href="profile.html" class="thumbnail"><img src="img/user.png" alt=""></a></li>
                  <li><a href="profile.html" class="thumbnail"><img src="img/user.png" alt=""></a></li>
                  <li><a href="profile.html" class="thumbnail"><img src="img/user.png" alt=""></a></li>
                  <li><a href="profile.html" class="thumbnail"><img src="img/user.png" alt=""></a></li>
                  <li><a href="profile.html" class="thumbnail"><img src="img/user.png" alt=""></a></li>
                  <li><a href="profile.html" class="thumbnail"><img src="img/user.png" alt=""></a></li>
                  <li><a href="profile.html" class="thumbnail"><img src="img/user.png" alt=""></a></li>
                  <li><a href="profile.html" class="thumbnail"><img src="img/user.png" alt=""></a></li>
                </ul>
                <div class="clearfix"></div>
                <div style="text-align:center">
                  <a  class="btn btn-primary" href="#">View All Friends</a>
                </div>
              </div>
            </div>
            <div class="panel panel-default groups">
              <div class="panel-heading">
                <h3 class="panel-title">Latest Groups</h3>
              </div>
              <div class="panel-body">
                <div class="group-item">
                  <img src="img/group.png" alt="">
                  <h4><a href="#" class="">Sample Group One</a></h4>
                  <p>This is a paragraph of intro text, or whatever I want to call it.</p>
                </div>
                <div class="clearfix"></div>
                <div class="group-item">
                  <img src="img/group.png" alt="">
                  <h4><a href="#" class="">Sample Group Two</a></h4>
                  <p>This is a paragraph of intro text, or whatever I want to call it.</p>
                </div>
                <div class="clearfix"></div>
                <div class="group-item">
                  <img src="img/group.png" alt="">
                  <h4><a href="#" class="">Sample Group Three</a></h4>
                  <p>This is a paragraph of intro text, or whatever I want to call it.</p>
                </div>
                <div class="clearfix"></div>
                <div style="text-align:center">
                  <a  class="btn btn-primary" href="#">View All Groups</a>
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
    <script src="js/ekko-lightbox.js"></script>
    <script>
      $(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
      event.preventDefault();
      $(this).ekkoLightbox();
      }); 
      $(function () {
      $('[data-hover="tooltip"]').tooltip()
      })
    </script>
  </body>
</html>

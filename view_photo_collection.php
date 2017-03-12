<?php
ob_start();
session_start();
require_once 'dbconnect.php';
if (!isset($_SESSION['user'])) {
   header("Location: index.php");
   exit;
}
$email  = $_SESSION['email'];
$userId = $_SESSION['user'];

$photoCollectionId = $_SESSION['collectionId'];
if(empty($photoCollectionId)){
    header("Location: photos.php");
    exit;
}

$query = "SELECT userID, name, whoCanSee FROM photocollections WHERE photoCollectionID=".$photoCollectionId;
$sql = mysql_query($query) or die (mysql_error());
$row = mysql_fetch_array($sql, MYSQL_NUM);
$photoCollectionAdminId = $row[0];
$photoCollectionName = $row[1];
$whoCanSeeValue = $row[2];
$whoCanSeeOptions = array("Friends", "Friend Circles", "Friends of friends");
$whoCanSeeText = $whoCanSeeOptions[$whoCanSeeValue];

require_once 'check_admin.php';
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
                <?php
                if($isAdmin) {
                  echo "<li><p class=\"navbar-text\">Logged in as Administrator </p></li>";
              }
              ?>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <span class="glyphicon glyphicon-user"></span>&nbsp;
                    <?php echo $email; ?>&nbsp;<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
</nav>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1 class="page-header"><?php echo "Photo Collection: ".$photoCollectionName ?></h1>
                <ul class="photos gallery-parent">
                    <?php
                    $query = "SELECT * FROM photos where photoCollectionID = '$photoCollectionId';";
                    $res = mysql_query($query) or die("Error in query: $query. ".mysql_error());
                    $count = mysql_num_rows($res);
                    while($row=mysql_fetch_array($res)){
                        $name = $row["name"];
                        $content = base64_encode($row["image"]);
                        $image = "data:image/jpeg;base64,". $content;
                        $photoId = $row['photoID'];
                        ?>
                        <li>
                            <form method="post" action="view_photo.php">
                                <input type="hidden" name="photoId" value="<?php echo $photoId ?>"/>
                                <input type="hidden" name="photoAdminId" value="<?php echo $photoCollectionAdminId ?>"/>
                                <input type="hidden" name="photoCollectionId" value="<?php echo $photoCollectionId ?>"/>
                                <input style="max-width:150px" type="image" name="view_photo" value="<?php echo $image ?>" src="data:image/jpeg;base64,<?php echo $content?>" value="Submit" />
                            </form>
                        </li>
                        <?php
                    }
                    ?>
                    <h4 <?php if($count != 0){ echo "hidden"; } ?> style="color:#337ab7;">This collection has no images</h4>
                </ul>
            </div>
            
            <?php
            if($photoCollectionAdminId == $userId || $isAdmin){
                ?>
                <div class="col-md-4">
                    <br><br><br><br>
                    <div class="panel panel-default friends">
                      <div class="panel-heading">
                        <h3 class="panel-title">Add photos</h3>
                    </div>
                    <div class="panel-body">
                        <ul>
                            <li>         
                                <div class="form-group" style="max-width:300px">
                                    <div class="input-group col-md-12">
                                        <form name="uploadImageForm" method="POST" action="functions.php" enctype="multipart/form-data" onsubmit="return validateImage()">
                                            <input type="hidden" name="add_photo_collection" value="<?php echo $photoCollectionId; ?>"/>
                                            <div class="form-group">
                                            <input type="file" multiple="multiple" name="img[]">
                                            </div>
                                            <button type="submit" name="upload" class="btn btn-default">Upload</button>
                                        </form> 
                                    </div>
                                </div>        
                            </li>
                        </ul>
                    </div>
                </div>       
                <div class="panel panel-default friends">
                  <div class="panel-heading">
                    <h3 class="panel-title">Privacy settings</h3>
                </div>
                <div class="panel-body">
                    <ul>
                        <li> 
                            <div class="col-md-6">
                                <div>Who can see this photo collection?</div>
                            </div>
                            <div class="col-md-3">
                                <div class="dropdown">
                                  <button class="btn btn-default dropdown-toggle" style="display:inline-block;" type="button" data-toggle="dropdown"><?php echo $whoCanSeeText; ?>
                                      <span class="caret"></span></button>
                                      <ul class="dropdown-menu">
                                        <?php
                                        $sizeofarray = sizeof($whoCanSeeOptions);
                                        for($i = 0; $i < $sizeofarray; $i++){
                                          if($i == $whoCanSeeValue){
                                              ?>
                                              <li class="disabled"><a href="#"><?php echo $whoCanSeeText ?></a></li>
                                              <?php
                                          }
                                          else{
                                            ?>   
                                            <li><a href="functions.php?action=view&request=change_privacy&option=photoCollection&value=<?php echo $i?>&id=<?php echo $photoCollectionId?>"><?php echo $whoCanSeeOptions[$i] ?></a></li>
                                            <?php        
                                        }
                                    }
                                    ?>                  
                                </ul>

                            </div>
                        </div>       
                    </li>
                </ul>
            </div>
        </div>       
    </div> 
    <?php
}
?>
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
        $(function() {
            $('[data-hover="tooltip"]').tooltip()
        })
    </script>
</body>

</html>
<script>
    function validateInput(){
        var a = document.forms["new_photo_collection"]["photo_collection_title"].value;
        
        if (a == ""){
            alert("Photo collection must be given a name.");
            return false;
        }
    }

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
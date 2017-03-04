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
$visibilityOptions = array("Friends", "Friend Circles", "Friends of friends");
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
              <div class="groups">
                <h2 class="page-header">My Photo Collections</h2>
                <?php 
                $myPhotoCollectionsQuery = "SELECT photoCollectionID, name, whoCanSee, firstName, surname FROM photocollections as p, personalinfo as pi WHERE p.userID = '$userId' AND p.userID = pi.userID";

                if($isAdmin){
                    $otherPhotoCollectionsQuery = "SELECT photoCollectionID, name, whoCanSee, firstName, surname FROM photocollections as p, personalinfo as pi WHERE p.userID = pi.userID AND p.userID != '$userId'";
                }
                else{
                    $otherPhotoCollectionsQuery = "SELECT photoCollectionID, name, whoCanSee, firstName, surname FROM photocollections as p, personalinfo as pi 
                    WHERE 
                    (
                    ((whoCanSee = 0 OR whoCanSee = 2) AND EXISTS (SELECT * FROM relationships WHERE userID1 = p.userID AND userID2 = ".$userId."))  
                    OR
                    (whoCanSee = 1 AND EXISTS (SELECT circleID FROM `circlememberships` WHERE userID IN (p.userID,".$userId.") GROUP BY circleID HAVING COUNT(*)>1))
                    OR
                    (whoCanSee = 2 AND EXISTS (SELECT F2.userID1 FROM relationships F JOIN relationships F2 ON F.userID1 = F2.userID2 WHERE F2.userID1 NOT IN (SELECT userID1 FROM relationships WHERE userID2 = p.userID) AND F.userID2 = p.userID AND F2.userID1 = ".$userId."))
                    )    
                    AND p.userID = pi.userID";
                }

                $sql = mysql_query($myPhotoCollectionsQuery) or die (mysql_error());
                $count = mysql_num_rows($sql);
                if($count == 0){
                    echo "<h4 style=\"color:#337ab7;\">&nbsp;&nbsp;&nbsp;You do not have any photo collections</h4>";
                }
                else{
                    while ($row = mysql_fetch_array($sql, MYSQL_NUM)) { 
                        $photoCollectionId = $row[0];
                        $name = $row[1];
                        $whoCanSee = $row[2];
                        $colletionOwner = $row[3]." ".$row[4];
                        ?>

                        <div class="group-item">
                        <div class="row member-row">
                          <div class="col-md-5">
                            <h3>&nbsp;&nbsp;&nbsp;
                                <a href="view_photo_collection.php?action=view&id=<?php echo $photoCollectionId?>"><?php echo $name?></a>
                            </h3>
                            <h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Collection Owner: <?php echo $colletionOwner ?></h5>
                            <h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Visible to: <?php echo $visibilityOptions[$whoCanSee]?></h5>
                            </div>
                            <form name="deleteCollectionForm" action="functions.php" method="post" onsubmit="return confirm_delete()">
                            <div class="col-md-3">
                                <input type="hidden" name="delete_collection" value="<?php echo $photoCollectionId ?>"/>
                                <button type="submit" class="btn btn-danger btn-block">Delete</button>
                            </div>
                            </form>
                        </div>
                        </div>
                        <div class="clearfix"></div>
                        <?php
                    }
                }
                $sql = mysql_query($otherPhotoCollectionsQuery) or die (mysql_error());
                $count = mysql_num_rows($sql);
                if($count > 0){
                    echo "<h2 class=\"page-header\">Other Photo Collections</h2>";
                    while ($row = mysql_fetch_array($sql, MYSQL_NUM)) { 
                        $photoCollectionId = $row[0];
                        $name = $row[1];
                        $whoCanSee = $row[2];
                        $colletionOwner = $row[3]." ".$row[4];
                        
                        ?>
                        <div class="group-item">
                            <h3>&nbsp;&nbsp;&nbsp;
                                <a href="view_photo_collection.php?action=view&id=<?php echo $photoCollectionId?>"><?php echo $name?></a>
                            </h3>
                            <h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Collection Owner: <?php echo $colletionOwner ?></h5>
                            <h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Visible to: <?php echo $visibilityOptions[$whoCanSee]?></h5>
                        </div>
                        <div class="clearfix"></div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
        <div class="col-md-4">
            <br><br><br><br>
            <div class="panel panel-default friends">
              <div class="panel-heading">
                <h3 class="panel-title">Create new photo collection</h3>
            </div>
            <div class="panel-body">
                <ul>
                    <li>         
                        <form name="new_photo_collection" method="POST" action="new_photo_collection.php" onsubmit="return validateInput()" autocomplete="off">
                            <div class="form-group" style="max-width:300px">
                                <div class="input-group col-md-12">
                                    <input type="text" name="photo_collection_title" class="form-control input-md" placeholder="Enter photo collection title" />
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

    function confirm_delete(){
        if(confirm("Deleting this collection will permanently delete the photos contained within it.\n\nDo you want to proceed?")){
            return true;
        }
        return false;
    }
</script>
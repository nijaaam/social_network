
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
    $res=mysql_query("SELECT * FROM users WHERE userID=".$_SESSION['user']);
    $userRow=mysql_fetch_array($res);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Social Network</title>

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
            <li class="active"><a href="index.php">Home</a></li>
            <li><a href="friends.php">Friends</a></li>
            <li><a href="groups.php">Groups</a></li>
            <li><a href="photos.php">Photos</a></li>
            <li><a href="profile.php">Profile</a></li>
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
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Wall</h3>
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
              
            <?php 
                                  
            ?> 
              
              
            <?php  
                
            ?>  
              
              
            <div class="panel panel-default post">
              <div class="panel-body">
                 <div class="row">
                   <div class="col-sm-2">
                     <a href="profile.html" class="post-avatar thumbnail"><img src="img/user.png" alt=""><div class="text-center">DevUser1</div></a>
                     <div class="likes text-center">7 Likes</div>
                   </div>
                   <div class="col-sm-10">
                     <div class="bubble">
                       <div class="pointer">
                         <p>Hey I was wondering if you wanted to go check out the football game later. I heard they are supposed to be really good!</p>
                       </div>
                       <div class="pointer-border"></div>
                     </div>
                     <p class="post-actions"><a href="#">Comment</a> - <a href="#">Like</a> - <a href="#">Follow</a> - <a href="#">Share</a></p>
                     <div class="comment-form">
                       <form class="form-inline">
                        <div class="form-group">
                          <input type="text" class="form-control" placeholder="enter comment">
                        </div>
                        <button type="submit" class="btn btn-default">Add</button>
                      </form>
                     </div>
                     <div class="clearfix"></div>

                     <div class="comments">
                       <div class="comment">
                         <a href="#" class="comment-avatar pull-left"><img src="img/user.png" alt=""></a>
                         <div class="comment-text">
                           <p>I am just going to paste in a paragraph, then we will add another clearfix.</p>
                         </div>
                       </div>
                       <div class="clearfix"></div>
                       <div class="comment">
                         <a href="#" class="comment-avatar pull-left"><img src="img/user.png" alt=""></a>
                         <div class="comment-text">
                           <p>I am just going to paste in a paragraph, then we will add another clearfix.</p>
                         </div>
                       </div>
                       <div class="clearfix"></div>
                     </div>
                   </div>
                 </div>
              </div>
            </div>
            <div class="panel panel-default post">
              <div class="panel-body">
                 <div class="row">
                   <div class="col-sm-2">
                     <a href="profile.html" class="post-avatar thumbnail"><img src="img/user.png" alt=""><div class="text-center">DevUser1</div></a>
                     <div class="likes text-center">7 Likes</div>
                   </div>
                   <div class="col-sm-10">
                     <div class="bubble">
                       <div class="pointer">
                         <p>Hey I was wondering if you wanted to go check out the football game later. I heard they are supposed to be really good!</p>
                       </div>
                       <div class="pointer-border"></div>
                     </div>
                     <p class="post-actions"><a href="#">Comment</a> - <a href="#">Like</a> - <a href="#">Follow</a> - <a href="#">Share</a></p>
                     <div class="comment-form">
                       <form class="form-inline">
                        <div class="form-group">
                          <input type="text" class="form-control" placeholder="enter comment">
                        </div>
                        <button type="submit" class="btn btn-default">Add</button>
                      </form>
                     </div>
                     <div class="clearfix"></div>

                     <div class="comments">
                       <div class="comment">
                         <a href="#" class="comment-avatar pull-left"><img src="img/user.png" alt=""></a>
                         <div class="comment-text">
                           <p>I am just going to paste in a paragraph, then we will add another clearfix.</p>
                         </div>
                       </div>
                       <div class="clearfix"></div>
                       <div class="comment">
                         <a href="#" class="comment-avatar pull-left"><img src="img/user.png" alt=""></a>
                         <div class="comment-text">
                           <p>I am just going to paste in a paragraph, then we will add another clearfix.</p>
                         </div>
                       </div>
                       <div class="clearfix"></div>
                     </div>
                   </div>
                 </div>
              </div>
            </div>
            <div class="panel panel-default post">
              <div class="panel-body">
                 <div class="row">
                   <div class="col-sm-2">
                     <a href="profile.html" class="post-avatar thumbnail"><img src="img/user.png" alt=""><div class="text-center">DevUser1</div></a>
                     <div class="likes text-center">7 Likes</div>
                   </div>
                   <div class="col-sm-10">
                     <div class="bubble">
                       <div class="pointer">
                         <p>Hey I was wondering if you wanted to go check out the football game later. I heard they are supposed to be really good!</p>
                       </div>
                       <div class="pointer-border"></div>
                     </div>
                     <p class="post-actions"><a href="#">Comment</a> - <a href="#">Like</a> - <a href="#">Follow</a> - <a href="#">Share</a></p>
                     <div class="comment-form">
                       <form class="form-inline">
                        <div class="form-group">
                          <input type="text" class="form-control" placeholder="enter comment">
                        </div>
                        <button type="submit" class="btn btn-default">Add</button>
                      </form>
                     </div>
                     <div class="clearfix"></div>

                     <div class="comments">
                       <div class="comment">
                         <a href="#" class="comment-avatar pull-left"><img src="img/user.png" alt=""></a>
                         <div class="comment-text">
                           <p>I am just going to paste in a paragraph, then we will add another clearfix.</p>
                         </div>
                       </div>
                       <div class="clearfix"></div>
                       <div class="comment">
                         <a href="#" class="comment-avatar pull-left"><img src="img/user.png" alt=""></a>
                         <div class="comment-text">
                           <p>I am just going to paste in a paragraph, then we will add another clearfix.</p>
                         </div>
                       </div>
                       <div class="clearfix"></div>
                     </div>
                   </div>
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

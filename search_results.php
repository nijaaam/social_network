<?php	
    ob_start();
    session_start();
    require_once 'dbconnect.php';

	function search_members($search_term, $friendId){        
            $userId = $_SESSION['user'];

			$friendRequestsSql = mysql_query("SELECT * FROM `relationships` WHERE (`userID1`= '".$userId."')") or die (mysql_error()); 
            $array = array();
            while ($row = mysql_fetch_array($friendRequestsSql, MYSQL_NUM)) {
                $array[] = $row;
            }

            $query = "";
            if($friendId == 0){
                $query = "SELECT * FROM `personalinfo` WHERE (`firstName` LIKE '%$search_term%' OR `surname` LIKE '%$search_term%') AND `userID` != '".$userId."'";
            }
            else if($search_term == 0){
                // friends of friends query.
                // $query = $query."SELECT f1.userID2 FROM relationships AS f1 JOIN relationships AS f2 USING (userID2) WHERE f1.userID1 = '".$userId."' AND f2.userID1 = '".$mutualUserId."' AND f1.invitationAccepted = '1' AND f2.invitationAccepted = '1' )";
                $query = "SELECT * FROM `personalinfo` WHERE `userID` != '".$userId."' AND `userID` IN (";
                $query = $query."SELECT userID2 FROM relationships WHERE userID1 = '".$friendId."' AND invitationAccepted = '1' )";
            }
            else{
                // Collaborative filtering method query goes here.
                $query = "SELECT * FROM `personalinfo` WHERE (`firstName` LIKE '%$search_term%' OR `surname` LIKE '%$search_term%') AND `userID` != '".$userId."'";
            }
        
			       $sql = mysql_query($query) or die (mysql_error());
            $num_of_row   = mysql_num_rows($sql);
            if ($num_of_row > 0 ){
                 while($row    = mysql_fetch_array($sql)){ 
                    $id = $row['userID'];
                    $firstName = $row['firstName'];
                    $surname = $row['surname'];
                    $headerName =  $firstName." ".$surname."'s Friends";

                    ?>
                      <div class="row member-row">
                        <div class="col-md-3">
                          <img src="img/user.png" class="img-thumbnail" alt="">
                          <div class="text-center">
                            <?php echo $firstName." ".$surname ?>
                          </div>
                        </div>

                        <?php 
                            $relationshipPresent = false;
                            foreach ($array as $v) {
                                $friendAccepted = $v[3];
                                if($v[1] == $id)
                                  $relationshipPresent = true;
                            }

                            if(!$relationshipPresent){
                        ?>  

                        <div class="col-md-3">
                          <p><a href="functions.php?action=view&request=add_friend&id=<?php echo $id?>" class="btn btn-success btn-block"><i class="fa fa-users"></i> Add Friend</a></p>
                        </div>

                          <?php
                            }
                             else if($friendAccepted != 1){
                        ?>
                        <div class="col-md-3">
                             <p><a class="btn btn-default btn-block"><i class="fa "></i>Pending request</a></p>
                        </div>
                        <?php
                             }
                          ?>
                        <div class="col-md-3">
                          <p><a href="view_profile.php?action=view&id=<?php echo $id?>" class="btn btn-primary btn-block"><i class="fa fa-edit"></i> View Profile</a></p>
                          <a href="search.php?action=view&search_friends_of_friends=<?php echo $id?>&header=<?php echo $headerName ?>" class="btn btn-default btn-block"><i class="fa fa-users"></i> View Friends</a>
                        </div>
                      </div>
                    <?php

                }
            }
            else
            {

              echo "<font color='red' size='4' >No result found!</font>";
            }
	
    }	

	function search_friend_blogs($search_term){      
            $userId = $_SESSION['user'];
            $friends = array();
            if($search_term == "")
                return;
            $query1 = "SELECT userID2 FROM relationships WHERE userID1 = $userId and invitationAccepted = 1";
            $result1 = mysql_query($query1) or die(mysql_error());
            while ($row = mysql_fetch_array($result1)){
                array_push($friends, $row['userID2']);
            }
            $result = array_unique($friends);
            $posts = array();
            foreach ($friends as $val) {
                $result = mysql_query("SELECT * FROM blogposts WHERE blogPostBody LIKE '%$search_term%'") or die(mysql_error());
                while($row = mysql_fetch_array($result)){
                    array_push($posts,$row);
                }
            }
            $posts = array_key_unique($posts,'dateTime');
            foreach($posts as $post){
                $postBody = $post['blogPostBody'];
                $timeSent = $post['dateTime'];
                $userId = $post['userID'];
                $myDateTime = DateTime::createFromFormat('Y-m-d H:m:s', $timeSent);
                $timeSent = $myDateTime->format('d/m/Y H:m');
                $name = mysql_query("SELECT CONCAT(firstName,' ', surname) from personalinfo WHERE userID = $userId");
                $fullName = mysql_fetch_array($name)[0];
            ?> 
             <div class="row">
               <div class="col-sm-2">
                 <a href="view_profile.php?action=view&id=<?php echo $userId?>" class="post-avatar thumbnail"><img src="img/user.png" alt=""><div class="text-center"><?php echo $fullName ?></div></a>
               </div>
               <div class="col-sm-10">
                 <div class="bubble">
                   <div class="pointer">
                     <p><?php echo $postBody ?></p>
                   </div>
                   <div class="pointer-border"></div>
                   <p class="post-actions" style="text-align:right"><a href="#"><?php echo $timeSent ?></a></p>
                 </div>
               </div>
             </div>             
        <?php  
            }

    }
?>
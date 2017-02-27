<?php	
	function searchmembers($search_term, $userId){        
            
			$friendRequestsSql = mysql_query("SELECT * FROM `relationships` WHERE (`userID1`= '".$userId."')") or die (mysql_error()); 
            $array = array();
            while ($row = mysql_fetch_array($friendRequestsSql, MYSQL_NUM)) {
                $array[] = $row;
            }
        
			$sql = mysql_query("SELECT * FROM `personalinfo` WHERE (`firstName` LIKE '%$search_term%' OR `surname` LIKE '%$search_term%') AND `userID` != '".$userId."' LIMIT 0, 30 ") or die (mysql_error());
		            $num_of_row   = mysql_num_rows($sql);
			    if ($num_of_row > 0 ){
					 while($row    = mysql_fetch_array($sql)){ 
						$id = $row['userID'];
						$firstName = $row['firstName'];
						$surname = $row['surname'];
                                                
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
                                 else{
                            ?>
                            <div class="col-md-3">
                                 <p><a class="btn btn-default btn-block"><i class="fa "></i>Pending request</a></p>
                            </div>
                            <?php
                                 }
                              ?>
                            <div class="col-md-3">
                              <p><a href="#" class="btn btn-default btn-block"><i class="fa fa-envelope"></i> Send Message</a></p>
                            </div>
                            <div class="col-md-3">
                              <p><a href="view_profile.php?action=view&id=<?php echo $id?>" class="btn btn-primary btn-block"><i class="fa fa-edit"></i> View Profile</a></p>
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
?>
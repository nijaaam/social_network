<?php
    $isAdmin = false;
    $currentUser = $_SESSION['user'];
    $query_admin = "SELECT userID FROM admins WHERE admins.userID='$currentUser'";
    $res_admin = mysql_query($query_admin) or die(mysql_error());
    if(mysql_num_rows($res_admin) == 1) {
        $isAdmin = true;
    }
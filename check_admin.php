<?php
    $currentUser = $_SESSION['user'];
    $query_admin = "SELECT isAdmin FROM users WHERE userID='$currentUser'";
    $res_admin = mysql_query($query_admin) or die(mysql_error());
    $row = mysql_fetch_array($res_admin, MYSQL_NUM);
    $isAdmin = $row[0];
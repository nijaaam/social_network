<?php

	// this will avoid mysql_connect() deprecation error.
	error_reporting( ~E_DEPRECATED & ~E_NOTICE );
	// but I strongly suggest you to use PDO or MySQLi.

    define('DBHOST', 'us-cdbr-azure-southcentral-f.cloudapp.net');
    define('DBUSER', 'b9dee02f541f7c');
    define('DBPASS', '70d033d3');
	define('DBNAME', 'socialcw');
	
	$conn = mysql_connect(DBHOST,DBUSER,DBPASS);
	$dbcon = mysql_select_db(DBNAME);

    function get_conn(){
        return $dbcon;
    }
	
	if ( !$conn ) {
		die("Connection failed : " . mysql_error());
	}
	
	if ( !$dbcon ) {
		die("Database Connection failed : " . mysql_error());
	}
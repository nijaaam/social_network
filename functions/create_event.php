    <?php
        ob_start();
        session_start();
        require_once '../dbconnect.php';

        // if session is not set this will redirect to login page
        if( !isset($_SESSION['user']) ) {
            header("Location: ../index.php");
            exit;
        }

        if( isset($_POST['name']) && isset($_POST['description']) &&
            isset($_POST['location']) && isset($_POST['date']) && 
            isset($_POST['categorisation']) && isset($_POST['tickets_available']) &&
            isset($_POST['end_date']) ) {
            
            // find user_id
            
            echo $_SESSION['user'];

            $result = mysql_query("INSERT INTO events (userId, name, description, location, date, categorisation, tickets_available, end_date)
                VALUES ('".$_SESSION['user']."', '".$_POST['name']."', '".$_POST['description']."', '".$_POST['location']."', 
                '".$_POST['date']."', '".$_POST['categorisation']."', '".$_POST['tickets_available']."', '".$_POST['end_date']."')");
            if (!$result) {
                die('Invalid query: ' . mysql_error());
            }
            
//            prepare("INSERT INTO `events` VALUES 
//                    name=?, description=?, location=?, date=?, categorisation=?,
//                                        tickets_available=?, end_date=?");

            
            header("Location: ../my_events.php");
            exit; 
            
        }
        else{
            // do nothing, show popup?
            exit;  
        }
    ?>
    <?php ob_end_flush(); ?>
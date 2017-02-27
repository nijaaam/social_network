    <?php
        ob_start();
        session_start();
        require_once '../dbconnect.php';

        // if session is not set this will redirect to login page
        if( !isset($_SESSION['user']) ) {
            header("Location: ../index.php");
            exit;
        }

        if( isset($_POST['eventId']) ) {
                        
            $result = mysql_query("INSERT INTO tickets (userId, eventId)
                VALUES ('".$_SESSION['user']."', '".$_POST['eventId']."')");
            if (!$result) {
                die('Invalid query: ' . mysql_error());
            }

            $success = mysql_query("UPDATE events SET tickets_available = tickets_available - 1 WHERE eventId = ".$_POST['eventId'].
                                  " AND tickets_available > 0");
            
                 
            header("Location: ../my_tickets.php");
            exit; 
            
        }
        else{
            // do nothing, show popup?
            exit;  
        }
    ?>
    <?php ob_end_flush(); ?>
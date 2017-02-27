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
            
            $result = mysql_query("INSERT INTO feedback (userId, eventId, comment, rating)
                VALUES ('".$_SESSION['user']."', '".$_POST['eventId']."', '".$_POST['comment']."', '".$_POST['rating']."')");

            if (!$result) {
                die("You have already given feedback to this event.");
            }
  
            header("Location: ../my_tickets.php");
            exit; 
            
        }
        else{
            // do nothing, show popup?
            exit;  
        }
    ?>


    <?php ob_end_flush(); ?>
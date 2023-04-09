<?php
    require '/home/jason.zhan/calendarSqlConnection.php';   
    header("Content-Type: application/json"); 


    ini_set("session.cookie_httponly", 1);

    session_start();
    

    $json_str = file_get_contents('php://input');
    //This will store the data into an associative array
    $json_obj = json_decode($json_str, true);

    
    $userId = (int)($_SESSION["user_id"]);

    $sql = "select * from events where user_id='" .$userId. "'";
    $result = mysqli_query($mysqli, $sql) or die("Error in Selecting " . mysqli_error($mysqli));

    //create an array
    $events = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $events['events'][] = $row;
    }
    echo json_encode($events);
    

    //close the db connection
    mysqli_close($mysqli);


   
?>

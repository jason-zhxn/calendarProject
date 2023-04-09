<?php
    require '/home/jason.zhan/calendarSqlConnection.php';   
    header("Content-Type: application/json"); 

    ini_set("session.cookie_httponly", 1);

    session_start();

    $json_str = file_get_contents('php://input');
    $json_obj = json_decode($json_str, true);

    // $token = (int)$_POST['token'];
    // if(!hash_equals($_SESSION['token'], $_POST['token'])){
    // 	 die("Request forgery detected");
    //  }

    $event_id = (int)($json_obj['eventId']);
    


    $stmt = $mysqli->prepare("delete from events where event_id=?");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
	    exit;
    }

    $stmt->bind_param('i', $event_id);
    $stmt->execute();
    $stmt->close();

    echo json_encode(array(
		"success" => true,
	));
	exit;
?>
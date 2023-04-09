<?php
    require '/home/jason.zhan/calendarSqlConnection.php';   
    header("Content-Type: application/json"); 


    $json_str = file_get_contents('php://input');
    $json_obj = json_decode($json_str, true);

    $event_id = (int)($json_obj['eventId']);


    $stmt = $mysqli->prepare("select body, time from events where event_id=?");
    if(!$stmt){
        printf("Query Prep Failed: %s\n",$mysqli->error);
        exit;
    }
    $stmt->bind_param('i', $event_id);
    $stmt->execute();
    $stmt->bind_result($body, $time);
    $body = htmlentities($body);
    $time = htmlentities($time);
    $stmt->fetch();
    $stmt->close();

    echo json_encode(array(
		"success" => true,
        "body"=>$body,
        "time"=>$time
	));
	exit;
?>
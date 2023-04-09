<?php
	ini_set("session.cookie_httponly", 1);
	session_start();

	require '/home/jason.zhan/calendarSqlConnection.php'; 
	 
	header("Content-Type: application/json");

	$json_str = file_get_contents('php://input');
    //This will store the data into an associative array
    $json_obj = json_decode($json_str, true);

	// $token = (int)$_POST['token'];
	// if(!hash_equals($_SESSION['token'], $_POST['token'])){
	// 	 die("Request forgery detected");
	//  }


	$event_id= (int)($json_obj['eventId']);
    $title = (String)($json_obj['title']);
    $body = (String)($json_obj['body']);
	$time = (String)($json_obj['editTime']);
	$importance = (int)($json_obj['editImportance']);
	

	
	$stmt = $mysqli->prepare("update events set importance=?, title=?, body=?, time=? where event_id=?");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('isssi', $importance, $title, $body, $time, $event_id);	 
	$stmt->execute();
    $stmt->close();
	echo json_encode(array(
        "success" => true,
        "title"=> $title,
        "body"=>$body,
		"time"=>$time,
		"event_id"=>$event_id,
		"importance"=>$importance
    ));
    exit;

?>
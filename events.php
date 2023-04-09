<?php

//THIS FILE IS FOR ADDING EVENTS TO DATABASE
    require '/home/jason.zhan/calendarSqlConnection.php';
    header("Content-Type: application/json"); 


    ini_set("session.cookie_httponly", 1);

    session_start();

    $json_str = file_get_contents('php://input');
    //This will store the data into an associative array
    $json_obj = json_decode($json_str, true);

    //filter input
    $title = (string)($json_obj['title']);
    $body = (string)($json_obj['body']);
    $importance = (string)($json_obj['importance']);
    $date = (string)($json_obj['date']);
    $time = (string)($json_obj['time']);
    $user_id = (string)($json_obj['event_user_id']);

    if(!(strlen($title)==0)){
        //insert event into database
        $stmt = $mysqli->prepare("insert into events (title, body, date, time, user_id, importance) values (?,?,?,?,?,?)");
        if(!$stmt){
            printf ("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->bind_param('ssssis', $title, $body, $date, $time, $user_id, $importance);
        $stmt->execute();
        $stmt->close();

        echo json_encode(array(
            "success"=>true,
            "date"=> $date,
            "title"=> $title,
            "body" => $body,
            "time"=> $time,
            "user_id"=> $user_id,
            "importance"=>$importance
        ));
    }
    else{
        echo json_encode(array(
            "success"=> false,
            "message"=> "Add a title and time to your event."
        ));
    }

?>
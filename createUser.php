<?php
require '/home/jason.zhan/calendarSqlConnection.php';

header("Content-Type: application/json"); 


ini_set("session.cookie_httponly", 1);

session_start();

$json_str = file_get_contents('php://input');
//This will store the data into an associative array
$json_obj = json_decode($json_str, true);

//filter input
$chosenUsername = (string)($json_obj['usernameCreate']);
$chosenPassword = (string)($json_obj['passwordCreate']);

if(strlen($chosenUsername) < 1 || strlen($chosenPassword)<1){
    echo json_encode(array(
		"success" => false,
		"message" => "Invalid Username or Password"
	));
}

//insert userinfo into database
$stmt = $mysqli->prepare("insert into userInfo (username,hashed_pass) values (?, ?)");
if(!$stmt){
    echo json_encode(array(
		"success" => false,
		"message" => "Invalid Username or Password"
	));
	exit;
}

//hash the password and store it

$hashedChosenPassword = password_hash($chosenPassword,PASSWORD_BCRYPT);

$stmt->bind_param('ss', $chosenUsername, $hashedChosenPassword);

$stmt->execute();

$stmt->close();

echo json_encode(array(
    "success" => true
));

?>
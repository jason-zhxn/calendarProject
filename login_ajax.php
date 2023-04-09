<?php

require '/home/jason.zhan/calendarSqlConnection.php';   

header("Content-Type: application/json"); 


ini_set("session.cookie_httponly", 1);

$json_str = file_get_contents('php://input');
//This will store the data into an associative array
$json_obj = json_decode($json_str, true);

session_start();
// filtering input
$username = htmlentities((string)($json_obj['username']));
$passwordGuess = htmlentities((string)($json_obj['password']));

//filtering input 
if( !preg_match('/^[\w_\-]+$/', $username) ){
	echo "Invalid username";
	exit;
}
else{



$stmt = $mysqli->prepare("SELECT COUNT(*), id, hashed_pass FROM userInfo WHERE username=?");

// Bind the parameter

$stmt->bind_param('s', $username);
$stmt->execute();
  

// Bind the results
$stmt->bind_result($cnt, $user_id, $pwd_hash);
$stmt->fetch();

//escaping output
$cnt = htmlentities($cnt);
$user_id = htmlentities($user_id);
$pwd_hash = htmlentities($pwd_hash);

$isLoggedIn=false;

if($cnt == 1 && password_verify($passwordGuess, $pwd_hash)){
	// Login succeeded!

	$_SESSION['username'] = $username;
    $_SESSION['user_id'] = $user_id;
    $_SESSION['isLoggedIn']=true;
	$_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32)); 

	echo json_encode(array(
		"success" => true,
        "message"=> $_SESSION['token'],
        "user_id"=> $_SESSION['user_id'],
		"username" => $_SESSION['username']
	));
	exit;
}
else{
	echo json_encode(array(
		"success" => false,
		"message"=> $pwd_hash,
        "user_id"=> $_SESSION['user_id'],
		"username" => $_SESSION['username']
	));
	exit;
}
}
?>
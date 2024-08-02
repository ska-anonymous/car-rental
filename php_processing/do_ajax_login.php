<?php
// make a response object to send back to ajax request which holds data about the login whether successfull or not.
$response = array("error" => false, "error_message" => "");
try{
    require_once("db_connect.php");
}catch(Exception $e){
    $response["error"] = true;
    $response["error_message"] = " Database Connection Failed ";
}

// fetch post form data
$user_login = trim($_POST['user_login']);
$user_pass = trim($_POST['user_pass']);

// check for login email or id if exists then compare passwords to grant login
$sql = "SELECT * FROM users WHERE user_email='$user_login' OR user_login_id='$user_login'";
$qry = $pdo->prepare($sql);
$qry->execute();

if($qry->rowCount()){
    $data = $qry->fetch(PDO::FETCH_ASSOC);
    $password_hash = $data['user_pass'];
    if(password_verify($user_pass, $password_hash)){
        session_start();
        $_SESSION['logged'] = true;
        $_SESSION['user_id'] = $data['user_id'];
        $_SESSION['user'] = $data;
    }else{
        $response["error"] = true;
        $response["incorrect_field"] = "user_pass";
        $response["error_message"] = "Incorrect Password";
    }

}else{
    $response["error"] = true;
    $response["incorrect_field"] = "user_login";
    $response["error_message"] = "Incorrect Email or Login ID"; 
}

header("content-type:application/json");
echo json_encode($response);

?>
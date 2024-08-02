<?php
// make a response array which data about the status of the the process, whether the registeration is successfull or not. and if not then why.

    $response = array("error" => false, "error_message" => "");
    try{
        require_once("db_connect.php");
    }catch(Exception $e){
        $response["error"] = true;
        $response["error_message"] = " Database Connection Failed ";
    }
    
    // fetch post form data
    $full_name = trim($_POST['user_name']);
    $email = trim($_POST['user_email']);
    $login_id = trim($_POST['user_login_id']);
    $user_pass = trim($_POST['user_pass']);
    $user_pass_retype = trim($_POST['user_pass_retype']);

    // check for password and retyped password matching
    if($user_pass != $user_pass_retype){
        $response["error"] = true;
        $response["invalid_field"] = "user_pass";
        $response["error_message"] = "Passwords do not match";
    }else{
        
        // check for email in database if already exists to avoid saving duplicate emails
        $sql = "SELECT * FROM users WHERE user_email='$email'";
        $qry = $pdo->prepare($sql);
        $qry->execute();
        if($qry->rowCount()){
            $response["error"] = true;
            $response["invalid_field"] = "user_email";
            $response["error_message"] = "This Email \"$email\" already Exists";
        }else{
            // check for login_id in database if already exists to avoid saving duplicate login ids
            $sql = "SELECT * FROM users WHERE user_login_id='$login_id'";
            $qry = $pdo->prepare($sql);
            $qry->execute();
            if($qry->rowCount()){
                $response["error"] = true;
                $response["invalid_field"] = "user_login_id";
                $response["error_message"] = "This login id \"$login_id\" already Exists";
            }else{
                // change the password to hash
                $user_pass = password_hash($user_pass, PASSWORD_DEFAULT);

                $sql = "INSERT INTO users(user_name, user_login_id, user_email, user_pass, user_role) VALUES('$full_name','$login_id', '$email', '$user_pass', 'user')";
                $qry = $pdo->prepare($sql);
                $qry->execute();
                if($qry->rowCount()){
                    $response["error"] = false;
                    $response["error_message"] = "";
                }else{
                    $response["error"] = true;
                    $response["error_message"] = "Registeration failed! Please try again later";
                }
            }
        }
    }
 

    header("content-type: application/json");
    echo json_encode($response);

?>

<?php
session_start();
//  redirect user to login page if not logged in already and tries to access pages 
if (!$_SESSION['logged']) {
    // store the url to redirect the user to after successful login 
    header("location: dashboard/login.php");
} else {
    header("location: dashboard/index.php");
}

?>
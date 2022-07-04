<?php
require 'elements/config.php';

// Initialize the session
//session_start();
 
// Unset all of the session variables
unset(
$_SESSION["loggedin"],
$_SESSION["id"],
$_SESSION["username"]
);

// Destroy the session.
//session_destroy();
 
// Redirect to login page
header("location:login.php");
exit;
?>
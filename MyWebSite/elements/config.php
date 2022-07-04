<?php

$path = $_SERVER['DOCUMENT_ROOT'];
$title_page = 'PersonalJourney';

require 'db.class.php' ;
require 'function.php';

$DB = new DB();

if (!isset($_SESSION)){
    session_start();
}
$id_user= $_SESSION['id'];


?> 
<?php
require_once '../php/session.php';
require_once '../classes/database.class.php';
require_once '../classes/auth.class.php';

$database = new Database();
$auth = new Auth($database);

if($auth instanceof Auth){
  $auth->logout();
  session_destroy();
}
header('Location:../index.php');
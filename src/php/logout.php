<?php
require_once '../php/session.php';
require_once '../class/database.class.php';
require_once '../class/auth.class.php';

$database = new Database();
$auth = new Auth($database);

if($auth instanceof Auth){
  $auth->logout();
  session_destroy();
}
header('Location:../pages/cms.php');
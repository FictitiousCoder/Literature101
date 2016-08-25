<?php
//global.inc.php

require_once 'classes/User.class.php';
require_once 'classes/UserTools.class.php';
require_once 'classes/Device.class.php';
require_once 'classes/DeviceTools.class.php';
require_once 'classes/DB.class.php';

//connect to the database
$db = new DB();
$db->connect();

//initialize UserTools object
$userTools = new UserTools();

//start the session
session_start();

//refresh session variables if logged in
if(isset($_SESSION['logged_in'])) {
	$user = unserialize($_SESSION['user']);
	$_SESSION['user'] = serialize($userTools->get($user->id));
    $_SESSION['editor'] = ($userTools->checkEditor($user->id));
}
?>
<?php
	
$user = 'siteUpdater';
$pass = '9b7TaV6d4XHBvq2Z';
$db = new PDO( 'mysql:host=localhost;dbname=site', $user, $pass );


error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');

session_start();

?>

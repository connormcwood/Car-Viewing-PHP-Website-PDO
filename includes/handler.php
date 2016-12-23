<?php
include 'includes/functions.php';
define("MaxSize", 600); //Defines A Constant Which Cannot Be Changed.

//Sets Time Limited Login Only To Logged In Users
if(isset($_SESSION['login'])){
	$myUser = retrieveUserData($_SESSION['userid'], $db);
//Determines Whether Settime Has Been Created Or Is Empty
if(!isset($_SESSION['settime']) || empty($_SESSION['settime'])){
	//Sets The First Initial Time
	$_SESSION['settime'] = time();
	$_SESSION['givenip'] = retrieveIpData();
//Does The Math To Work Out Whether Max Time Has Been Reached
} else if(time() - $_SESSION['settime'] > MaxSize){
	//Unsets Session And Gives User Feedback
	unset ($_SESSION['login'], $_SESSION['username'], $_SESSION['userid']);
	$_SESSION['message'] = "Login Expired!";
	header('Location: logout.php'); //Moves User To Logout Page
} else {
	//Still Within Acceptable Time
	echo "Current Time(" .time(). ")";
	echo " ";
	echo "Time Set At(" .$_SESSION['settime']. ")";
	echo " ";	
	echo "Difference(" .(time() - $_SESSION['settime']). ")";
	echo " ";	
	$userssignedup = $myUser['regip'];
	echo "Signed Up IP: {$userssignedup} Currnet Ip: {$_SESSION['givenip']}";
	$_SESSION['settime'] = time();
}
}
?>

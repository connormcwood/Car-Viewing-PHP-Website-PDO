<?php

//Retrieve User Data
function retrieveUserData($usersid, $connection){
	$getUser = $connection->prepare("SELECT * from members WHERE userid = :userid");
	$getUser->execute(array(
        ':userid' => $usersid
        ));
	$users = $getUser->fetchAll();
	foreach($users as $user){
		return $user;
	}
}
function retrieveIpData(){
	if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      return $_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      return $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      return $_SERVER['REMOTE_ADDR'];
    }
}
function userStatusName($userrights){
	if($userrights == 1){
		return "Administrator ({$userrights})";
	} else if($userrights == 0){
		return "Regular User ({$userrights})";
	} else if($userrights == -1){
		return "Banned User ({$userrights})";
	}
}
?>

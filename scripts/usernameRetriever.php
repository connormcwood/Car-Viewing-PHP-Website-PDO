<?php
    include '../includes/connect.php';
 
   
    $filterUsername = $_POST['availablility']; 

    //Validation Needed.
    $available = array();
    $usernames = array();

        $getUsername = $db->prepare("SELECT username from members WHERE username = :username");
        $getUsername->execute(array(
        ':username' => $filterUsername
        ));
		$data = $getUsername->fetch(PDO::FETCH_ASSOC);
		
		if($data == FALSE){
			//Username Is Available
			array_push($available, 0); //False 0 Is Available.
		} else {
			//Username Is Not Available
			array_push($available, 1); //True 1 Is Not Available
		}
 
   
   $arr = array('availability'=>$available);
   print_r(json_encode($arr));
   
?>

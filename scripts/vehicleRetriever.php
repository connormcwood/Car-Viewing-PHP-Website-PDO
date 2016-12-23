<?php
    include '../includes/connect.php';
   
	
    $filtername = $_POST['name']; //Text
    $filtermax_price = $_POST['max_price']; //Number
    $filterbrand = $_POST['brand']; //Select
    $filterwheels = $_POST['wheels']; //Select
    $filtercolour = $_POST['colour']; //Select
	
	/*
	$filtername = '';
	$filtermax_price = 0;
	$filterbrand = '';
	$filtercolour = 'Any';
	$filterwheels = 'Any';
	*/
    if($filtercolour == "Any"){
		$filtercolour = "";
	}
	if($filterwheels == "Any"){
		$filterwheels = 0;
	}
	if($filterbrand == "Any"){
		$filterbrand = "";
	}
    //Validation Needed.
    $id = array();
    $name = array();
    $price = array();
    $picture = array();
    $color = array();
    $brand = array();
   	
   	
   		
   	
   	
   	
   	
   	
   	
    //Used When Max Price Is Set
    if($filterbrand != "" && $filtercolour != "") {
		$getVehicles = $db->prepare("SELECT vehicles_id, vehicles_name, vehicles_price, vehicles_picture, vehicles_color, vehicles_brand FROM vehicles 
			WHERE vehicles_brand = :filterbrand AND vehicles_color = :filtercolour GROUP BY vehicles_name"); 
        $getVehicles->execute(array(
        ':filterbrand' => $filterbrand,
        ':filtercolour' => $filtercolour
        )); 
	} else if($filtercolour != "" && $filterwheels == 0 && $filtermax_price == 0){
	//Used When Colour Is Set But Wheels And Max_Price Arent Set.    
		    $getVehicles = $db->prepare("SELECT vehicles_id, vehicles_name, vehicles_price, vehicles_picture, vehicles_color, vehicles_brand FROM vehicles 
			WHERE vehicles_name LIKE :filtername AND vehicles_brand LIKE :filterbrand AND vehicles_color = :filtercolour GROUP BY vehicles_name"); 
         $concatName = "%{$filtername}%";
         $concatBrand = "%{$filterbrand}%";
        $getVehicles->execute(array(
        ':filtername' => $concatName,
        ':filterbrand' => $concatBrand,
        ':filtercolour' => $filtercolour
        ));    	
    } else if($filterwheels != 0 && $filterbrand != ''){
			$getVehicles = $db->prepare("SELECT vehicles_id, vehicles_name, vehicles_price, vehicles_picture, vehicles_color, vehicles_brand FROM vehicles 
			WHERE vehicles_wheels = :filterwheels AND vehicles_brand = :filterbrand GROUP BY vehicles_name"); 
        $getVehicles->execute(array(
        ':filterwheels' => $filterwheels,
        ':filterbrand' => $filterbrand
        )); 		
	} else if($filterwheels != 0) {
		$getVehicles = $db->prepare("SELECT vehicles_id, vehicles_name, vehicles_price, vehicles_picture, vehicles_color, vehicles_brand FROM vehicles 
			WHERE vehicles_wheels = :filterwheels GROUP BY vehicles_name"); 
        $getVehicles->execute(array(
        ':filterwheels' => $filterwheels
        )); 	
    } else if($filterbrand != ""){
		    $getVehicles = $db->prepare("SELECT vehicles_id, vehicles_name, vehicles_price, vehicles_picture, vehicles_color, vehicles_brand FROM vehicles 
			WHERE vehicles_brand LIKE :filterbrand GROUP BY vehicles_name"); 
         $concatBrand = "%{$filterbrand}%";
        $getVehicles->execute(array(
        ':filterbrand' => $concatBrand
        ));	
    } else if($filtermax_price != 0){
	$getVehicles = $db->prepare("SELECT vehicles_id, vehicles_name, vehicles_price, vehicles_picture, vehicles_color, vehicles_brand FROM vehicles 
			WHERE vehicles_name LIKE :filtername AND vehicles_brand LIKE :filterbrand AND vehicles_price <= :filtermaxprice GROUP BY vehicles_name"); 
         $concatName = "%{$filtername}%";
         $concatBrand = "%{$filterbrand}%";
        $getVehicles->execute(array(
        ':filtername' => $concatName,
        ':filterbrand' => $concatBrand,
        ':filtermaxprice' => $filtermax_price
        ));
	} else {
		    //Used When No Preference With Colour, Wheels or Max_Price.
		$getVehicles = $db->prepare("SELECT vehicles_id, vehicles_name, vehicles_price, vehicles_picture, vehicles_color, vehicles_brand FROM vehicles 
			WHERE vehicles_name LIKE :filtername AND vehicles_brand LIKE :filterbrand GROUP BY vehicles_name"); 
         $concatName = "%{$filtername}%";
         $concatBrand = "%{$filterbrand}%";
        $getVehicles->execute(array(
        ':filtername' => $concatName,
        ':filterbrand' => $concatBrand
        )); 	
	}
   
 
    $vehicles = $getVehicles->fetchAll();
    foreach($vehicles as $vehicle){
		$vehicleId = $vehicle["vehicles_id"];
		$vehicleName = $vehicle["vehicles_name"];
		$vehiclePrice = $vehicle["vehicles_price"]; 
		$vehiclePicture = $vehicle["vehicles_picture"];
		$vehicleColour = $vehicle["vehicles_color"];
		$vehicleBrand = $vehicle["vehicles_brand"];
		
		array_push($id, $vehicleId);
		array_push($name, $vehicleName);
		array_push($price, number_format($vehiclePrice));
		array_push($picture, $vehiclePicture);
		array_push($color, $vehicleColour);
		array_push($brand, $vehicleBrand);
    }
   
   $arr = array('id'=>$id,'name'=>$name, 'max_price'=>$price, 'picture'=>$picture, 'colour'=>$color, 'brand'=>$brand);
   print_r(json_encode($arr));
   
?>

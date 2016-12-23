<?php
include 'includes/connect.php';
include 'includes/header.php';

setlocale(LC_MONETARY, 'en_GB');

//Make Sure Vehicle Id Has Been Specified
if(isset($_GET['id'])){
$vehicleId = $_GET['id'];	
} else if(isset($_POST['submitchanges'])) {
	$inputBrand = $_POST['inputBrand'];
	$inputName = $_POST['inputName'];
	$inputPrice = $_POST['inputPrice'];
	$inputHorsePower = $_POST['inputHorsePower'];
	$inputMaxSpeed = $_POST['inputMaxSpeed'];
	$vehicleId = $_POST['inputVehicleId'];
	
	$updateVehicles = $db->prepare('UPDATE vehicles SET vehicles_brand = :inputbrand, vehicles_name = :inputname, 
	vehicles_price = :inputprice, vehicles_horsepower = :inputhorsepower, vehicles_max_speed = :inputmaxspeed 
	WHERE vehicles_id = :givenid');
	$updateVehicles->bindValue(':inputbrand', $inputBrand);
	$updateVehicles->bindValue(':inputname', $inputName);
	$updateVehicles->bindValue(':inputprice', $inputPrice);
	$updateVehicles->bindValue(':inputhorsepower', $inputHorsePower);
	$updateVehicles->bindValue(':inputmaxspeed', $inputMaxSpeed);
	$updateVehicles->bindValue(':givenid', $vehicleId);
	$update = $updateVehicles->execute();
	if($update){
		$message = "<div class='success'>Data Has Been Updated</div>";
	} else {
		$message = "<div class='error'>There Was A Problem. Data Has Not Been Updated.</div>";
	}	
} else {
header('Location: vehicles.php');	
}

//Edit Specific Vehicle
if(isset($_GET['edit'])){
$editId = $_GET['edit'];	
}

$getVehicle = $db->prepare("SELECT * FROM vehicles 
			WHERE vehicles_id = :filterid");
$getVehicle->execute(array(
':filterid' => $vehicleId
));
if($getVehicle->rowCount() > 0){
	$data = $getVehicle->fetch(PDO::FETCH_ASSOC);
	$vehicleId = $data["vehicles_id"];
	$vehicleName = $data["vehicles_name"];
	$vehiclePrice = $data["vehicles_price"]; 
	$vehiclePicture = $data["vehicles_picture"];
	$vehicleColour = $data["vehicles_color"];
	$vehicleBrand = $data["vehicles_brand"];
	$vehicleHorsePower = $data["vehicles_horsepower"];
	$vehicleMaxSpeed = $data["vehicles_max_speed"];
}
$formattedPrice = number_format($vehiclePrice);

?>
<div id="content">
	<div id="vehicleProfile">
		<div class="textContainer">
			<h2>Features</h2>
				<?php if(isset($message)) {
					echo $message;
				} ?>
				<div class="header">

				<p>Name:</p>
				<p>Brand:</p>
				<p>Price:</p>
				<p>Horse Power:</p>
				<p>Max Speed:</p>
				</div>
				<div class="data">
				<?php
				if(!(isset($editId))){
				echo "<p>{$vehicleBrand}</p>";
				echo "<p>{$vehicleName}</p>";
				echo "<p>&pound{$formattedPrice}</p>";
				echo "<p>{$vehicleHorsePower} kW </p>";
				echo "<p>{$vehicleMaxSpeed} Mph</p>";
					if(isset($_SESSION['login']) && $myUser['rights'] == 1){
					echo "<a href='view_vehicles.php?id={$vehicleId}&edit={$vehicleId}'>Edit {$vehicleBrand} {$vehicleName}</a>";
					}
				} else {
				echo "<form id='editVehicle' method='POST' action='{$_SERVER['PHP_SELF']}'
				<p><input type='text' name='inputBrand' value='{$vehicleBrand}'></p>";	
				echo "<p><input type='text' name='inputName' value='{$vehicleName}'></p>";	
				echo "<p>&pound<input type='number' name='inputPrice' value='{$vehiclePrice}'></p>";	
				echo "<p><input type='number' name='inputHorsePower' value='{$vehicleHorsePower}'> kW</p>";	
				echo "<p><input type='number' name='inputMaxSpeed' value='{$vehicleMaxSpeed}'> Mph</p>
				<input type='hidden' name='inputVehicleId' value='{$vehicleId}'>
				<input type='submit' id='submitchanges' name='submitchanges' value='Submit Vehicle Edit'></form>";	
				}
				?>
				</div>				
<?php

echo "</div><img src='/vehicle_images/{$vehiclePicture}' />";
?>
	</div>

<?php
	
include 'includes/footer.php';
?>


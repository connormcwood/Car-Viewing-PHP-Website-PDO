<?php
include 'includes/connect.php';
include 'includes/header.php';

	if(isset($_SESSION['message']) && $_SESSION['message'] != ''){
	echo $_SESSION['message'];
	unset ($_SESSION['message']);
	}
	if(isset($_POST['editSettings'])){
		$restrictIpValue = $_POST['restrictIp'];
		$usersId = $myUser['userid'];
		if($restrictIpValue != $myUser['restrictIp']){
			//Value Is Different Update Table
			$updateDetails = $db->prepare("UPDATE members SET restrictIp = :restrictIpVal WHERE userid = :userid");
			$updateDetails->bindValue(':restrictIpVal', $restrictIpValue);
			$updateDetails->bindValue(':userid', $usersId);
			$objUpdate = $updateDetails->execute();	
			if($objUpdate){
				echo "<div class='success'><p>Your Settings Have Been Updated</p></div>";
			} else {
				//Doesnt
				echo "<div class='error'><p>There Was An Issue</p></div>"; 
			}
		
		}
	}
?>
<div id="content">
<div class="smallcontainer">
<div class="header"><h2>Account Features</h2></div>
<form id="accountSettings" action='<?php echo $_SERVER['PHP_SELF']; ?>' method='post'>
<p>Only Allow Registed IP To Be Able To Sign In (<?php echo $myUser['restrictIp']; ?>)
<select name='restrictIp'>
<option value='0'>No</option>
<option value='1'>Yes</option>
</select>
</p>
<input type='submit' name='editSettings' id='updateUser' value='Make Changes'>
</form>
</div>
<div class="smallcontainer">
<div class="header"><h2>About Us</h2></div>
<div class="content"><p> Welcome Blackpool Luxury Vehicles Ltd</p></div>
</div>
</div>
<?php
include 'includes/footer.php';
?>

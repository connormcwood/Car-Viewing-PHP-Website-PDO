<?php
include 'includes/connect.php';
include 'includes/header.php';

	if(isset($_SESSION['message']) && $_SESSION['message'] != ''){
	echo $_SESSION['message'];
	unset ($_SESSION['message']);
	}
?>
<div id="content">
<div class="smallcontainer">
<div class="header"><h2>About Us</h2></div>
<p> Welcome Blackpool Luxury Vehicles Ltd</p>
</div>
<div class="smallcontainer">
<div class="header"><h2>About Us</h2></div>
<div class="content"><p> Welcome Blackpool Luxury Vehicles Ltd</p></div>
</div>
</div>
<?php
include 'includes/footer.php';
?>

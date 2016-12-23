<div id="header">
<ul class="subnav">	
<li><img class="logo" alt="Tower Luxury Vehicles Logo" src="/images/towerluxuryvehicleswhite.png" /></li>
<li><a href="index.php"/>Home</a></li>
<li><a href="vehicles.php"/>Vehicles</a></li>
<?php
if(isset($_SESSION['login']) && $_SESSION['userid'] != '' && $myUser['rights'] == 1){
?>
<li><a href="administration.php"/>Administration</a></li>
<?php
}
if(isset($_SESSION['login']) && $_SESSION['userid'] != ''){
?>
<li><a href="myaccount.php"/><?php echo $myUser['username']; ?>'s Account</a></li>
<li><a href="logout.php"/>Logout</a></li>	
<?php
} else {
?>
<li><a href="login.php"/>Login</a></li>
<li><a href="register.php"/>Register</a></li>
<?php
}

?>
</ul>
</div>

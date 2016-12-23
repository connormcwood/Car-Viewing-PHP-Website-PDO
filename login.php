<?php
include 'includes/connect.php';
include 'includes/header.php';
if(isset($_POST['login'])){
		$username = $_POST['username'];
		$password = $_POST['password'];	

		$statement = $db->prepare('SELECT userid, username, password, regip, restrictIp FROM members WHERE username = :username');
		$statement->execute(array(
		':username'=>$username
		));
		$data = $statement->fetch(PDO::FETCH_ASSOC);		
		if($data == FALSE){
			$_SESSION['message'] = "<div class='error'><p>The Username or Password You Entered Was Incorrect.</p></div>";
		} else {
			$passVerify = password_verify($password, $data['password']);
			if($passVerify){				
				$retrieveIpVal = retrieveIpData();
				if(($data['restrictIp'] == 1) && ($data['regip'] != $retrieveIpVal)){
					//Restrict Ip Setting Is On But Users Ip Is Not The Same 
					echo "<div class='error'><p>There Was An Error With Your Settings</p></div>";
				} else {
				$_SESSION['login'] = true;
				$_SESSION['username'] = $data['username'];
				$_SESSION['userid'] = $data['userid'];
				$_SESSION['message'] = "Welcome {$data['username']}, You Have Been Logged In";
				header('Location: index.php');
				}
			} else {
				$_SESSION['message'] = "<div class='error'><p>The Username or Password You Entered Was Incorrect.</p></div>";
			}
		}
}


	if(isset($_SESSION['message']) && $_SESSION['message'] != ''){
	echo $_SESSION['message'];
	unset ($_SESSION['message']);
	}
?>
<script src="scripts/validation.js"> </script>
<div id="content">
	<div class="smallcontainer registration">
		<div class="header">
		<h2>Login</h2>
		</div>
		<div class="container">
		<form id="login" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
		<label for 'username'>Username: </label>
		<input type="text" id="username" name="username" placeholder="Username"/><br />
		<label for 'password'>Password: </label>
		<input type="password" name="password" placeholder="Password"/><br />
		<button type="submit" id="login" name="login">Login</button>
		</form>
		</div>
	</div>
	<div class="smallcontainer registration">
		<div class="header">
		<h2>Extra</h2>
		</div>
		<div class="container">
		<p> This </p>
		</div>
	</div>
</div>
<?php
include 'includes/footer.php';
?>

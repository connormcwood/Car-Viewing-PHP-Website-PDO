<?php
include_once 'includes/connect.php';
include 'includes/header.php';

	if(isset($_SESSION['message']) && $_SESSION['message'] != ''){
	echo $_SESSION['message'];
	unset ($_SESSION['message']);
	}
	
if(isset($_POST['submitted'])){
$advance = true;

$username = $_POST[ 'username' ];
$password = $_POST[ 'password' ];
$password2 = $_POST[ 'password2' ];
$first_name = $_POST[ 'first_name' ];
$surname = $_POST[ 'surname' ];
$address = $_POST[ 'address' ];
$email = $_POST[ 'email' ];


//Check To See If Password Is The Same, Isn't Empty And Matches The 
if($password != $password2 || empty($password) || (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,30}$/', $password))){
	$_SESSION['message'] += "<div class='error'><p>There Was An Issue With Your Password Field. Make Sure You Have One Number, Atleast One Character
	And A Length of Atleast 8</p></div>";
	$advance = false;
}
//Check Username
if(empty($username) || (preg_match("/([%\$#\*]+)/", $username) == true)){
	$_SESSION['message'] += "<div class='error'><p>There Was An Error With The Username Field</p></div>";
	$advance = false;
}
//Make Sure The Email Is Valid
if(filter_var($email, FILTER_VALIDATE_EMAIL) == false){
	$_SESSION['message'] += "<div class='error'><p>There Was An Error With The Email Field</p></div>";
	$advance = false;
}
//Confirms Surname Does Not Contain Numbers
if(preg_match("/([%\$#\*]+)/", $surname)){
	$_SESSION['message'] += "<div class='error'><p>There Was An Error With The Surname Field</p></div>";
	$advance = false;
}
//Confirm First Name Only Includes Letter. Uses PHP Function.
if((ctype_alpha($first_name) == false) || (preg_match("/([%\$#\*]+)/", $first_name))){
$_SESSION['message'] += "<div class='error'><p>There Was An Error With The First Name Field</p></div>";
	$advance = false;
}
echo $advance;
if($advance == true){
$sql = "INSERT INTO members ( username, password, first_name, surname, address, email, regip ) 
VALUES ( :username, :password, :first_name, :surname, :address, :email, :regip )";

$options = [
'cost' => 12
];
$hashedPassword = password_hash($password, PASSWORD_BCRYPT, $options);
$usersIp = retrieveIpData();
$query = $db->prepare( $sql );
$register = $query->execute( array( ':username'=>$username, ':password'=>$hashedPassword, 
':first_name'=>$first_name, ':surname'=>$surname, ':address'=>$address, ':email'=>$email, ':regip'=>$usersIp) );
if($register){
				//Log User In After Registration
				$statement = $db->prepare('SELECT userid, username, password FROM members WHERE username = :username');
				$statement->execute(array(
				':username'=>$username
				));
				$data = $statement->fetch(PDO::FETCH_ASSOC);		
				if($data == FALSE){
					$_SESSION['message'] = "<div class='error'><p>The Username or Password You Entered Was Incorrect.</p></div>";
				} else {
					$passVerify = password_verify($password, $data['password']);
				if($passVerify){
					$_SESSION['login'] = true;
					$_SESSION['username'] = $data['username'];
					$_SESSION['userid'] = $data['userid'];
					$_SESSION['message'] = "Welcome {$data['username']}, You Have Been Logged In";
					header('Location: index.php');
					} else {
					$_SESSION['message'] = "<div class='error'><p>The Username or Password You Entered Was Incorrect.</p></div>";
					}
				}	
			} else {
			//Failed Reload Page To Display Message Session.
			header('Location: register.php');
			}
	} else {
	//Advance Isn't True. Error With Input. Reload Display Session
	header('Location: register.php');
	}
}
?>
<script src="scripts/validation.js"> </script>
<script>
function checkUsernames(inputValue){
	console.log('data');
$.ajax({
        type: 'POST',
        dataType: "json", 
        data: {
            availablility:inputValue
            }, 
        url: 'scripts/usernameRetriever.php',
        success: function(data){
            console.log(data);
            availability=data.availability;
			implementUsernameFeature(availability, inputValue);
        },
        error: function(){
            alert('Problem With Data');
            console.log(data);
        }
    })
}
function hasWhiteSpace(input){
	return input.indexOf(' ') >= 0;
}
function implementUsernameFeature(isNameAvailable, inputValue){
	var inputBox = document.getElementById("username");
	var namesBox = document.getElementById("suggestedNames");
	//Condition Asks Whether It Is Availble
	inputBox.className = "";
	namesBox.innerHTML = "";	
	if(isNameAvailable == 0 && inputValue != ''){
			inputBox.className = "valid";
			namesBox.innerHTML = "<br /><div class='success'><p>Name Is Available!</p></div><br />";
	} else {
			inputBox.className = "invalid";
			namesBox.innerHTML = "<br /><div class='error'><p>Name Is Taken!</p></div><br />";
	}	

}
</script>
<div id="content">
	<div class="smallcontainer registration">
<div class="header"><h2>Registraiton</h2></div>
<div class="container">
<form id="registration" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
 <p><label for 'username'>Username: </label></p><br />
<input type="text" id="username" name="username" onblur="checkUsernames(this.value)" placeholder="Enter A Unique Username"/><div id="suggestedNames"></div>
  <p><label for 'password'>Password: </label></p><br />
  <input type="password" " id="password" name="password" />
  <p><label for 'password2'>Verify Password: </label></p><br />
  <input type="password"  id="password2" name="password2"/>
  <p><label for 'first_name'>First name: </label></p><br />
  <input type="text" name="first_name" placeholder="Enter Your Forename"/>
  <p><label for 'surname'>Surname: </label></p><br />
  <input type="text" name="surname" placeholder="Enter Your Surname"/>
  <p><label for 'address'>Address: </label></p><br />
  <input type="text" name="address" placeholder="Enter Your Address"/>
  <p><label for 'email'>Email: </label></p><br />
  <input type="email" name="email" placeholder="Enter A Valid Email Address"/>
  <button type="submit" id="submitted" name="submitted">Register</button><br />
</form>
</div>
</div>
<div class="smallcontainer">
<div class="header"><h2>Extra</h2></div>
<div class="content">

<p> Holder </p>
</div>

</div>
</div>
<?php
include 'includes/footer.php';
?>

<?php
include 'includes/connect.php';
include 'includes/header.php';

//Is User Logged In And Do They Have Correct Permissions To View Page
if(!(isset($_SESSION['login']) && $_SESSION['userid'] != '' && $myUser['rights'] == 1)){
				header('Location: index.php');
} else {
	if(isset($_GET['edit'])){
		$editUserId = $_GET['edit'];
	}
	if(isset($_GET['option'])){
		$editUserOption = $_GET['option'];
	}
	if(isset($_POST['updateUser'])){
				   $updatedUsername = $_POST['username'];
				   $updatedfirst_name = $_POST['first_name'];
				   $updatedsurname = $_POST['surname'];
				   $updatedaddress = $_POST['address'];
				   $updatedemail = $_POST['email'];
				   $updatedrights = $_POST['rights'];
				   $updatedregip = $_POST['regip'];
				   $updatedid = $_POST['id'];
		$updateUsersEdit = $db->prepare('UPDATE members SET username = :username, first_name = :firstname,
		surname = :surname, address = :address, email = :email, rights = :rights, regip = :regip WHERE userid = :userid');
		$updateUsersEdit->bindValue(':username', $updatedUsername);
		$updateUsersEdit->bindValue(':firstname', $updatedfirst_name);
		$updateUsersEdit->bindValue(':surname', $updatedsurname);
		$updateUsersEdit->bindValue(':address', $updatedaddress);
		$updateUsersEdit->bindValue(':email', $updatedemail);
		$updateUsersEdit->bindValue(':rights', $updatedrights);
		$updateUsersEdit->bindValue(':regip', $updatedregip);
		$updateUsersEdit->bindValue(':userid', $updatedid);
		$update = $updateUsersEdit->execute();
		if($update){
			//Valid
		} else {
			//Error
		}
	}
   $getUsers = $db->prepare("SELECT userid, username, email, rights FROM members"); 
   $getUsers->execute();
   $users = $getUsers->fetchAll();   
?>
<div id="content">
<div class="smallcontainer">
<div class="header"><h2>Member Accounts</h2></div>
<table id="userdata">
	<tr>
		<th>Username</th>
		<th>Email Address</th>
		<th>User's Rights</th>
		<th>Options</th>
	</tr>
	
<?php
   foreach($users as $user){
	   $userid = $user['userid'];
	   $username = $user['username'];
	   $email = $user['email'];
	   $rights = userStatusName($user['rights']);
	   
	   
	   echo "<tr><td>{$username}</td><td>{$email}</td><td>{$rights}</td><td>
	   <a href='administration.php?edit={$userid}&option=1'>Edit</a>
	   <a href='administration.php?edit={$userid}&option=2'>Remove</a>
	    <a href='administration.php?edit={$userid}&option=3'>Ban</a>
	   </td></tr>";
   }
?>
</table>
</div>
<div class="smallcontainer">
<div class="header"><h2>User Account Details</h2></div>
<div class="useredit">
	
<?php
	if(isset($editUserId) && $editUserId != ''){
		if($editUserOption == 1){
			//Edit
			   $getUser = $db->prepare("SELECT * FROM members where userid = :userid"); 
			   $getUser->execute(array(
			   ':userid' => $editUserId
			   ));
			   $editUser = $getUser->fetchAll();   
			   
			   foreach($editUser as $edit){
				   $retrievedUsername = $edit['username'];
				   $retrievedfirst_name = $edit['first_name'];
				   $retrievedsurname = $edit['surname'];
				   $retrievedaddress = $edit['address'];
				   $retrievedemail = $edit['email'];
				   $retrievedrights = $edit['rights'];
				   $retrievedregip = $edit['regip'];
				   
				   
				   echo "<form method ='post' action='{$_SERVER['PHP_SELF']}'>
				   <p>Username <input type='text' name='username' value='{$retrievedUsername}'></p>
				   <p>First Name <input type='text' name='first_name' value='{$retrievedfirst_name}'></p>
				   <p>Surname <input type='text' name='surname' value='{$retrievedsurname}'></p>
				   <p>Address <input type='text' name='address' value='{$retrievedaddress}'></p>
				   <p>Email Adddress <input type='text' name='email' value='{$retrievedemail}'></p>
				   <p>Users Rights <input type='text' name='rights' value='{$retrievedrights}'></p>
				   <p>Users Signed Up Ip <input name='regip' type='text' value='{$retrievedregip}'></p>
				   <input type='hidden' name='id' value='{$editUserId}'>
				   <input type='submit' id='updateUser' name='updateUser' value='Update' />
				   </form>";
			   }
		} else if($editUserOption == 2){
			//Remove
			$deleteUser = $db->prepare('DELETE from members WHERE userid = :userid');
			$deleteUser->bindValue(':userid', $editUserId);
			$objDelete = $deleteUser->execute();
			if($objDelete){
				//Delete User
				header('Location: administration.php'); //Refresh Page To See Results
			} else {
				//Failed
			}
		} else if($editUserOption == 3){
			$banRights = -1; //Anyone with -1 Is Classed As Banned
			$banUser = $db->prepare('UPDATE members SET rights = :rights WHERE userid = :userid');
			$banUser->bindValue(':rights', $banRights);
			$banUser->bindValue(':userid', $editUserId);
			$objBan = $banUser->execute();
				header('Location: administration.php'); //Refresh Page To See Results	
			if($objBan){
				//Banned User
			} else {
				//Hasn't Banned User
			}
		} else {
			
		}
	} else {
		echo "<p>This Area Is Used To Edit Account Details</p>";
	}

?></div>
</div>
</div>
<?php
}
include 'includes/footer.php';
?>

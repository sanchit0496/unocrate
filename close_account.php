<?php 
include("includes/header.php");
 
if (isset($_POST['cancel'])) {
	header("Location:settings.php");
}

if (isset($_POST['close_account'])) {
	$close_query = mysqli_query($con, "UPDATE users SET user_closed = 'yes' WHERE username = '$userLoggedIn'");
	session_destroy();
	header("Location:register.php");
}



 ?>

 <div class="main_column column">
 	<h4>Close Account</h4>
 	Are you sure that you want to close your account?<br><br>
 	Closing your account will hide your profile and all of your activities from the users.<br><br>
 	You can re-open your account anytime by just simply logging in using your email and password.<br><br>


 	<form action="close_account.php" method="POST">
 		<input type="submit" name="close_account" id="close_account" value="Yes, Close my Account!">
 	    <input type="submit" name="cancel" id="update_account" value="No Way!">
 	</form>

 </div>
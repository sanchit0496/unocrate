<?php 
include ("includes/header.php");
include("includes/form_handlers/settings_handler.php");
 ?>
<title>Account Settings</title>

<div class="main_column column">
	
	 <h4 style="padding: 20px;">Account Settings</h4>
	<?php 
	echo "<img style='height:250px;width:250px;padding:10px;margin-left:30%;' src='".$user['profile_pic'] . "' id = small_profile_pics'>";
	 ?>
	 <br>
	 <a href="upload.php" style=" display: block; border: 1px solid rebeccapurple; padding: 4px; text-align: center; margin-top: 25px; background-color: whitesmoke;">Upload New Profile Picture</a><br><br>

 	<h4 style="padding: 10px;">Modify the values and click 'Update Details'</h4>


	 <?php 

	 $user_data_query = mysqli_query($con, "SELECT first_name, last_name, email FROM users WHERE username = '$userLoggedIn'");
	 $row = mysqli_fetch_array($user_data_query);

	 $first_name = $row['first_name'];
	 $last_name = $row['last_name'];
	 $email = $row['email'];

	  ?>


	 <form action="settings.php" method="POST" style="padding: 20px;">
	 	First Name:<br> <input type="text" name="first_name" style="padding: 3px; margin-top: 5px;" value="<?php echo $first_name; ?>"><br><br>
	 	Last Name: <br><input type="text" name="last_name" style="padding: 3px; margin-top: 5px;" value="<?php echo $last_name; ?>"><br><br>
	 	Email: <br><input type="text" name="email" style="padding: 3px; margin-top: 5px;" value="<?php echo $email; ?>"><br><br>

	 	<?php echo $message; ?>

	 	<input type="submit" style=" background-color: whitesmoke; font-weight: 600; color: #563d7c; border: 1px solid rebeccapurple; padding: 4px; border-radius: 3px; margin-top: 20px; width: 100%; color: #563d7c;     cursor: hand;" name="update_details" id="save_details" value="Update Details"><br>
	 </form>

	 <h4 style="padding: 10px; margin-top: 50%;">Change Password</h4>
	 <form action="settings.php" method="POST" style="padding: 20px;">
	 Old Password: <br><input type="password" style="padding: 3px; margin-top: 5px;" name="old_password"><br><br>
	 New Password: <br><input type="password" style="padding: 3px; margin-top: 5px;" name="new_password_1"><br><br>
	 Enter the New Password Again:<br> <input type="password" style="padding: 3px; margin-top: 5px;" name="new_password_2"><br><br>

	 	<?php echo $password_message; ?>


	 <input type="submit" style=" background-color: whitesmoke; font-weight: 600; border: 1px solid rebeccapurple; padding: 4px; border-radius: 3px; margin-top: 20px; width: 100%; cursor: hand; color: #563d7c;" name="update_password" id="save_details" value="Update Password"><br>

	 </form>

	 <h4 style="padding: 20px; margin-top: 50%;">Close Account</h4>
	 <form action="settings.php" method="POST">
	 	<input type="submit" name="close_account" style="border: 2px solid #ea6b6b; padding: 4px; width: 100%; background-color: whitesmoke; cursor: hand; font-weight: 600; color: #ea6b6b;" id="close_account" value="Close Account">
	 </form>
</div>
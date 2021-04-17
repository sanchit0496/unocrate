  <?php 
include("includes/header.php");

#session_destroy();
$message_obj = new Message($con, $userLoggedIn);

if (isset($_GET['profile_username'])) {
	$username = $_GET['profile_username'];
	$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$username'");
	$user_array = mysqli_fetch_array($user_details_query);
	//Number of friends added
	$num_friends = (substr_count($user_array['friend_array'], ",")) -1; 
}

if(isset($_POST['remove_friend'])) {
	$user = new User($con, $userLoggedIn);
	$user->removeFriend($username);
}

if(isset($_POST['add_friend'])) {
	$user = new User($con, $userLoggedIn);
	$user->sendRequest($username);
}
if(isset($_POST['respond_request'])) {
	header("Location: requests.php");
}
if (isset($_POST['post_message'])) {
	if (isset($_POST['message_body'])) {
		$body = mysqli_real_escape_string($con, $_POST['message_body']);
		$date = date("Y-m-d H:i:s");
		$message_obj->sendMessage($username,$body,$date);
	}
  $link = '#profileTabs a[href="#messages_div"]';

	echo "<script>
			$(function(){
				$('" .$link ."').tab('show');
			});
		</script>";
}


?>



<!--<div class="wrapper>" (already in the header.php file) -->
<title><?php echo $user_array['first_name'] ." " . $user_array['last_name']; ?></title>
<style>
	.wrapper{
		margin-left: 65px;
		padding-left: 0px;
	}
</style>

<div class="profile_left">
	

	<img src="<?php echo $user_array['profile_pic']; ?>">
	<div class="profile_left_username"><?php echo $user_array['first_name'] ." " . $user_array['last_name']; ?></div>


	<div class="profile_info">
		<p><?php echo "Posts: ".$user_array['num_posts']; ?></p>
		<p><?php echo "Likes: ".$user_array['num_likes']; ?></p>
		<p><?php echo "Friends: ".$num_friends; ?></p>
		<p><?php echo "Date Joined: ".$user_array['date']; ?></p>
	</div>

	<form action="<?php echo $username; ?>" method="POST">
 			<?php 
 			$profile_user_obj = new User($con, $username); 
 			if($profile_user_obj->isClosed()) {
 				header("Location: user_closed.php");
 			}

 			$logged_in_user_obj = new User($con, $userLoggedIn); 

 			if($userLoggedIn != $username) {

 				if($logged_in_user_obj->isFriends($username)) {
 					echo '<input type="submit" name="remove_friend" class="danger" align="middle" value="Remove Friend"><br>';
 				}
 				else if ($logged_in_user_obj->didReceiveRequest($username)) {
 					echo '<input type="submit" name="respond_request" class="warning" align="middle" value="Respond to Request"><br>';
 				}
 				else if ($logged_in_user_obj->didSendRequest($username)) {
 					echo '<input type="submit" name="" class="default" value="Request Sent" align="middle"><br>';
 				}
 				else 
 					echo '<input type="submit" name="add_friend" class="success" align="middle" value="Add Friend"><br>';

 			}



 			?>
 		</form>


  <!-- Button to Open the Modal -->
 		<input type="submit" class="deep_blue" style="margin-top: 2px;background-color: #2980b9;" data-toggle="modal" data-target="#post_form" align="middle" value="Post Something"><br><br>



	<?php 

	if ($userLoggedIn!=$username) {
		echo '<div class="profile_info_bottom">';
		echo $logged_in_user_obj-> getMutualFriends($username) . " Mutual Friends Between You and " . $user_array['first_name'] ." " . $user_array['last_name'];
		echo '</div>';
	}

	?>


</div>  


<div class="main_column column">

<ul class="nav nav-tabs" role="tablist" id="profileTabs">
  <li class="nav-item">
    	<a class="nav-link active" href="#newsfeed_div" aria-controls="newsfeed_div" role="tab" data-toggle="tab">Newsfeed</a>
  </li>
  
  <li class="nav-item">
    	<a class="nav-link" href="#messages_div" aria-controls="messages_div" role="tab" data-toggle="tab">Messages</a>
  </li>
</ul>

<div class="tab-content">
	
	<div role="tabpanel" class="tab-pane active in" id="newsfeed_div">
		<div class="posts_area"> </div>
		<img id="loading" src="assets/images/icons/loading.gif">
	</div>

	<div role="tabpanel" class="tab-pane fade" id="messages_div">	

		<?php 
		$message_obj = new Message($con,$userLoggedIn);

		echo "<h4>You and <a href=' " . $username . " '>" . $profile_user_obj-> getFirstAndLastName() . "</a></h4><hr><br>";
		echo "<div class='loaded_messages' id='scroll_messages'>";
			echo $message_obj->getMessages($username);
		echo "</div>";
	 ?>


<div class="message_post">
	<form action="" method="POST">
		<textarea name='message_body' id='message_textarea' placeholder='Write your message here'></textarea>
		<input type='submit' name='post_message' class='info' id='message_submit' value='Send'>
	</form>
</div>



<script>
	var div = document.getElementById("scroll_messages");
	div.scrollTop = div.scrollHeight;
</script>

	</div>		
	</div>

</div>







<!-- The Modal -->
  <div class="modal fade" id="post_form" tabindex="-1" role="dialog" aria-labelledby="postModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" style="color: black;">Post to <?php echo $user_array['first_name'] ." " . $user_array['last_name']; ?></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <p style="color: black">Your post will be visible to <?php echo $user_array['first_name'] ." " . $user_array['last_name']; ?> and other Unocrate users!

          	<form class="profile_post" action="" method="POST">
      		<div class="form-group">
      			<textarea class="form-control" name="post_body"></textarea>
      			<input type="hidden" name="user_from" value="<?php echo $userLoggedIn; ?>">
      			<input type="hidden" name="user_to" value="<?php echo $username; ?>">
      		</div>
      	</form>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal" name="post_button" id="submit_profile_post">Post </button>
        </div>
        
      </div>
    </div>
  </div>




<script>
	var userLoggedIn = '<?php echo $userLoggedIn; ?>';
	var profileUsername = '<?php echo $username; ?>';

	$(document).ready(function() {

		$('#loading').show();

		//Original ajax request for loading first posts 
		$.ajax({
			url: "includes/handlers/ajax_load_profile_posts.php",
			type: "POST",
			data: "page=1&userLoggedIn=" + userLoggedIn + "&profileUsername=" + profileUsername,
			cache:false,

			success: function(data) {
				$('#loading').hide();
				$('.posts_area').html(data);
			}
		});

		$(window).scroll(function() {
			var height = $('.posts_area').height(); //Div containing posts
			var scroll_top = $(this).scrollTop();
			var page = $('.posts_area').find('.nextPage').val();
			var noMorePosts = $('.posts_area').find('.noMorePosts').val();

			if ((document.body.scrollHeight == document.body.scrollTop + window.innerHeight) && noMorePosts == 'false') {
				$('#loading').show();

				var ajaxReq = $.ajax({
					url: "includes/handlers/ajax_load_posts.php",
					type: "POST",
					data: "page=" + page + "&userLoggedIn=" + userLoggedIn + "&profileUsername=" + profileUsername,
					cache:false,

					success: function(response) {
						$('.posts_area').find('.nextPage').remove(); //Removes current .nextpage 
						$('.posts_area').find('.noMorePosts').remove(); //Removes current .nextpage 

						$('#loading').hide();
						$('.posts_area').append(response);
					}
				});

			} //End if 

			return false;

		}); //End (window).scroll(function())


	});

	</script>



</div>

</body>
</html>

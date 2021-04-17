<?php 
class notification {
	private $user_obj;
	private $con;

	public function __construct($con, $user){
		$this->con = $con;
		$this->user_obj = new User($con, $user);
	}


	public function getUnreadNumber(){
	$userLoggedIn = $this->user_obj->getUsername();
	$query = mysqli_query($this->con, "SELECT * FROM notifications WHERE viewed='no' AND user_to='$userLoggedIn'");
	return mysqli_num_rows($query);
	}


	public function getNotifications($data,$limit){


		$page = $data['page'];
		$userLoggedIn = $this->user_obj->getUsername();
		$return_string = "";

		if($page == 1)
			$start = 0;
		else 
			$start = ($page - 1) * $limit;

		$set_viewed_query = mysqli_query($this->con, "UPDATE notifications SET viewed='yes' WHERE user_to='$userLoggedIn'");

		$query = mysqli_query($this->con, "SELECT * FROM notifications WHERE user_to='$userLoggedIn' ORDER BY id DESC");

		if (mysqli_num_rows($query) == 0) {
			echo "You have no notifications";
		return;
		}

		$num_iterations = 0; //Number of messages checked 
		$count = 1; //Number of messages posted

		while ($row = mysqli_fetch_array($query)) {

			if($num_iterations++ < $start)
				continue;

			if($count > $limit)
				break;
			else 
				$count++;

			$user_from = $row['user_from'];
			$user_data_query = mysqli_query($this->con, "SELECT * FROM users WHERE username='$user_from'");
			$user_data = mysqli_fetch_array($user_data_query);

	//Timeframe
		$date_time_now = date("Y-m-d H:i:s");
		$start_date = new DateTime($row['datetime']); //Time of post
		$end_date = new DateTime($date_time_now); //Current time
		$interval = $start_date->diff($end_date); //Difference between dates 
		if($interval->y >= 1) {
			if($interval == 1)
				$time_message = $interval->y . " y"; //1 year ago
			else 
				$time_message = $interval->y . " y"; //1+ year ago
		}
		else if ($interval->m >= 1) {
			if($interval->d == 0) {
				$days = " ago";
			}
			else if($interval->d == 1) {
				$days = $interval->d . " d";
			}
			else {
				$days = $interval->d . " d";
			}


			if($interval->m == 1) {
				$time_message = $interval->m . " m". $days;
			}
			else {
				$time_message = $interval->m . " m". $days;
			}

		}
		else if($interval->d >= 1) {
			if($interval->d == 1) {
				$time_message = "Yesterday";
			}
			else {
				$time_message = $interval->d . " d";
			}
		}
		else if($interval->h >= 1) {
			if($interval->h == 1) {
				$time_message = $interval->h . " h";
			}
			else {
				$time_message = $interval->h . " h";
			}
		}
		else if($interval->i >= 1) {
			if($interval->i == 1) {
				$time_message = $interval->i . " m";
			}
			else {
				$time_message = $interval->i . " m";
			}
		}
		else {
			if($interval->s < 30) {
				$time_message = "Just now";
			}
			else {
				$time_message = $interval->s . " s";
			}
			}	


			$opened = $row['opened'];
			$style = ($row['opened'] == 'no') ? "background-color: #DDEDFF;" : "";

			$return_string .= "<a href='" .$row['link'] ."'>
						<div class='notificationsProfilePic'>
						<img src ='". $user_data['profile_pic'] . "'>
						</div>
						
						<div class='notification_info'>
						 
						" . $row['message'] . "<p class = 'timestamp_smaller' id='greymsgtime'> " 
						  .$time_message . "</p>" . "

						</div>
						
						</a>" . "<hr>";
		
		}


		//If posts were loaded
		if($count > $limit)
			$return_string .= "<input type='hidden' class='nextPageDropdownData' value='" . ($page + 1) . "'><input type='hidden' class='noMoreDropdownData' value='false'>";
		else 
			$return_string .= "<input type='hidden' class='noMoreDropdownData' value='true'> <p style='text-align: center;'>No more notifications to load!</p>";

		return $return_string;


	}

	public function insertNotification($post_id,$user_to,$type){

		$userLoggedIn = $this->user_obj->getUsername();
		$userLoggedInName = $this->user_obj->getFirstAndLastName();

		$date_time = date("Y-m-d H:i:s");

		switch ($type) {
			case 'comment':
				$message = $userLoggedIn . " commented on your post";
				break;
			
			case 'like':
				$message = $userLoggedIn . " liked your post";
				break;

			case 'profile':
				$message = $userLoggedIn . " posted on your profile";
				break;
				
			case 'comment_non_owner':
				$message = $userLoggedIn . " commented on a post you commented on";
				break;		
			case 'profile_comment':
				$message = $userLoggedIn . "commented on your post";
				break;
		}

		$link = "post.php?id=" . $post_id;
		$insert_query = mysqli_query($this->con,"INSERT INTO notifications VALUES('','$user_to','$userLoggedIn','$message','$link','$date_time','no','no')");
	}

}
?>

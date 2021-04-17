<?php


//Declaring variables to prevent errors
$fname= ""; //First Name
$lname= ""; //Last Name
$em= ""; //Email
$em2= ""; //Re-enter Email
$password= ""; //Password
$password2= ""; //Re-enter Password
$date= ""; //Date of the Registration
$error_array= array(); //Holds the error messages

if(isset($_POST["register_button"])){
   
	//Registration form values

    //First Name   
    $fname = strip_tags($_POST['reg_fname']); //Removes the HTML Tags
    $fname = str_replace(' ','', $fname); //Removes Spaces
    $fname = ucfirst(strtolower($fname)); // Uppercases the First Letter
    $_SESSION['reg_fname'] = $fname; //stores first name into session variable 

    //Second Name   
    $lname = strip_tags($_POST['reg_lname']);
    $lname = str_replace(' ','', $lname);
    $lname = ucfirst(strtolower($lname));
    $_SESSION['reg_lname'] = $lname;

    //Email   
    $em = strip_tags($_POST['reg_email']);
    $em = str_replace(' ','', $em);
    $em = ucfirst(strtolower($em));
    $_SESSION['reg_email'] = $em;

    //Email2   
    $em2 = strip_tags($_POST['reg_email2']);
    $em2 = str_replace(' ','', $em2);
    $em2 = ucfirst(strtolower($em2));
    $_SESSION['reg_email2'] = $em2;

    //Passwords
    $password = strip_tags($_POST['reg_password']);
    $password2 = strip_tags($_POST['reg_password2']);

    //Date of the Registration
    $date=date('Y-m-d'); //Shows the current date
    
    if($em == $em2){
        
        //Check if email is in valid format
        if(filter_var($em, FILTER_VALIDATE_EMAIL)){
            $em = filter_var($em, FILTER_VALIDATE_EMAIL);

        //Check if the email already exists
            $e_check = mysqli_query($con, "SELECT email FROM users WHERE email='$em'");

        //Count the number of rows returned, if comes out to be >0, then email already in use
            $num_rows = mysqli_num_rows($e_check);

            if($num_rows > 0 ){
                array_push($error_array, "Email Already In Use<br>");
            }
        }
        else{
            array_push($error_array, "Invalid Format<br>");
        }


    }else{
        array_push($error_array, "Emails do not match<br>");

    }    
 
    if(strlen($fname) > 25 || strlen($fname) < 2){
    array_push($error_array, "First Name Too Short<br>");
    }
    if(strlen($lname) > 25 || strlen($lname) < 2){
    array_push($error_array, "Last Name Too Short<br>");    
    }
    if($password != $password2){
    array_push($error_array, "Passwords do not match<br>");    
    
    }else{
    if(preg_match('/[^A-Za-z0-9]/', $password)){
        array_push($error_array, "Your password can only contain english characters<br>");    
    }
    }
    if(strlen($password) > 25 || strlen($password) < 2){
    array_push($error_array, "Your Password is Short<br>");    
    }


    if (empty($error_array)) {
        $password = md5($password); //Password Encryption

        //Generate username by concatenation
        $username = strtolower($fname. "_" . $lname);
        $check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username = '$username'");

        $i = 0;
        //if the username exists add number to username
        while (mysqli_num_rows($check_username_query) != 0) {
            $i++; //Add 1 to i
            $username = $fname. "_" . $i;
            $check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username = '$username'");
        }

        //Assigning the profile picture
         $rand = rand(1,16); //Random number between 1 and 16

        if($rand == 1){
            $profile_pic = "assets/images/profile_pics/defaults/head_deep_blue.png";
        }else if ($rand == 2) {
            $profile_pic = "assets/images/profile_pics/defaults/head_emerald.png";
        }else if ($rand == 3) {
            $profile_pic = "assets/images/profile_pics/defaults/head_alizarin.png";
        }else if ($rand == 4) {
            $profile_pic = "assets/images/profile_pics/defaults/head_amethyst.png";
        }else if ($rand == 5) {
            $profile_pic = "assets/images/profile_pics/defaults/head_belize_hole.png";
        }else if ($rand == 6) {
            $profile_pic = "assets/images/profile_pics/defaults/head_carrot.png";
        }else if ($rand == 7) {
            $profile_pic = "assets/images/profile_pics/defaults/head_green_sea.png";
        }else if ($rand == 8) {
            $profile_pic = "assets/images/profile_pics/defaults/head_nephritis.png";
        }else if ($rand == 9) {
            $profile_pic = "assets/images/profile_pics/defaults/head_pete_river.png";
        }else if ($rand == 10) {
            $profile_pic = "assets/images/profile_pics/defaults/head_pomegranate.png";
        }else if ($rand == 11) {
            $profile_pic = "assets/images/profile_pics/defaults/head_pumpkin.png";
        }else if ($rand == 12) {
            $profile_pic = "assets/images/profile_pics/defaults/head_red.png";
        }else if ($rand == 13) {
            $profile_pic = "assets/images/profile_pics/defaults/head_sun_flower.png";
        }else if ($rand == 14) {
            $profile_pic = "assets/images/profile_pics/defaults/head_turqoise.png";
        }else if ($rand == 15) {
            $profile_pic = "assets/images/profile_pics/defaults/head_wet_asphalt.png";
        }else if ($rand == 16) {
            $profile_pic = "assets/images/profile_pics/defaults/head_wisteria.png";
        }



        $query = mysqli_query($con, "INSERT INTO users VALUES ('', '$fname','$lname','$username','$em','$password','$date','$profile_pic','0','0','no',',')");
        

      array_push($error_array, "<span style = 'color:red;'>You're all set. Go ahead and log in</span><br>");

        //Clear the session variables
        $_SESSION['reg_fname'] = "";
        $_SESSION['reg_lname'] = "";
        $_SESSION['reg_email'] = "";
        $_SESSION['reg_email2'] = "";

        session_unset();

    }


} 

?>
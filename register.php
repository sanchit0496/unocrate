<?php  
require 'config/config.php';
require 'includes/form_handlers/register_handler.php';
require 'includes/form_handlers/login_handler.php';
?>


<html>
<head>
    <title>Unocrate</title>
    <link rel="stylesheet" type="text/css" href="assets/css/register_style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/register.js"></script>
    <script type="text/javascript" src="assets/js/particles.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
</head>

<body>
    <div class="wrapper">
    <div id="particles-js"> <!-- particles.js container --> 
    <script src="http://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script> 
    <script  src="assets/js/indexparticles.js"></script>

<div class="company"><p>U N O C R A T E</p></div>


            
        <div id="first">

            <form action="register.php" style="margin-top: 100%" method="POST">
                <input type="email" name="log_email" placeholder="Email Address" value = "<?php 
                if(isset($_SESSION['log_email'])){
                    echo $_SESSION['log_email'];
                }
                ?>" required><br>
                <input type="password" name="log_password" placeholder="Password"><br><br>
                <input type="submit" name="login_button" value="Login"><br><br>
                <a href="#second">Create an Account here!</a>
            
                <br><?php if(in_array("Email or Password Was Incorrect<br>", $error_array)){echo "Email or Password Was Incorrect<br>";}
                ?>
            </form>
        </div>



<div class="infosecond">

<div class="info"> 
<img  src="assets/images/backgrounds/unocrate.png">
<br>
<p class="siteinfo">

<div class="infoline"> <strong>Join Now!</strong> <br> Create an account for free. Get a unique personal web address.
Share posts, photographs, audio and video files. <br>    
</div>    
 


<div class="infoline"><strong>Private Messaging!</strong><br> The virtual extensions of real-world human interaction.<br>
</div>    


<div class="infoline"><strong>Trending Today!</strong><br> Determined by an algorithm that monitors the subjects and topics people are posting the most about.<br><br>
</div>    

<footer><a href="https://www.linkedin.com/in/sanchit0496/">&copy; All Rights Reserved</a>



</p>

</div>


        <div id="second">
            <form action="register.php" method="POST">
        <h3>Create a new account here!</h3><br>

                <input type="text" name="reg_fname" placeholder="First Name" value = "<?php 
                if(isset($_SESSION['reg_fname'])){
                    echo $_SESSION['reg_fname'];
                }
                ?>" required>
                <br>
                <?php if(in_array("First Name Too Short<br>", $error_array)){echo "First Name Too Short<br>";}?>
            
                <input type="text" name="reg_lname" placeholder="Last Name" value = "<?php 
                if(isset($_SESSION['reg_lname'])){
                    echo $_SESSION['reg_lname'];
                }
                ?>" required>
                <br>
                <?php if(in_array("Last Name Too Short<br>", $error_array)){echo "Last Name Too Short<br>";}?>

                <input type="email" name="reg_email" placeholder="Your Email" value = "<?php 
                if(isset($_SESSION['reg_email'])){
                    echo $_SESSION['reg_email'];
                }
                ?>" required>
                <br>

                <input type="email" name="reg_email2" placeholder="Confirm Email" value = "<?php 
                if(isset($_SESSION['reg_email2'])){
                    echo $_SESSION['reg_email2'];
                }
                ?>" required>
                <br>
                <?php if(in_array("Email Already In Use<br>", $error_array)){echo "Email already in use<br>";}
                else if(in_array("Invalid Format<br>", $error_array)){echo "Invalid Format<br>";}
                else if(in_array("Emails do not match<br>", $error_array)){echo "Emails do not match<br>";}?>


                <input type="password" name="reg_password" placeholder="Enter Password" required>
                <br>
                <input type="password" name="reg_password2" placeholder="Confirm Password" required>
                <br><br>
                <?php if(in_array("Passwords do not match<br>", $error_array)){echo "Passwords do not match<br>";}
                else if(in_array("Your password can only contain english characters<br>", $error_array)){echo "Your password can only contain english characters<br>";}
                else if(in_array("Your Password is Short<br>", $error_array)){echo "Your Password is Short<br>";}?>


                <input type="submit" name="register_button" value="Register">
                <br>

                <?php if(in_array("<span style = 'color:green;'>You're all set. Go ahead and log in</span><br>", $error_array)){
                    echo "<span style = 'color:red;'>You're all set. Go ahead and log in</span><br>";}
                    ?>

            </form>
                                <a href="first" style="display: block;text-align: center;">Already have an account? <br> Sign in here!</a>

        </div><!--End of registration box-->


</div>

        </div>
</footer>

    </div>

    </div>

</body>
</html>
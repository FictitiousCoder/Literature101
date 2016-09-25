<?php 
//register.php

require_once 'includes/global.inc.php';

// Initialize php variables used in the form
$username = "";
$password = "";
$password_confirm = "";
$email = "";
$error = "";

// Check to see that the form has been submitted.
if(isset($_POST['submit-form'])) { 

	// Retrieve the $_POST variables
	$username = $_POST['username'];
	$password = $_POST['password'];
	$password_confirm = $_POST['password-confirm'];
	$email = $_POST['email'];

	// Initialize variables for form validation
	$success = true;
	$userTools = new UserTools();
	
    /*Validate that the form was filled out correctly.
    Check for special characters in the name*/
    if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $username))
    {
	    $error = "Username must not contain special characters.<br/> \n\r";
	    $success = false;
    }
    
	// Check to see if user name already exists.
	if($userTools->checkUsernameExists($username))
	{
	    $error .= "That username is already taken.<br/> \n\r";
	    $success = false;
	}
    
    // Check to see if email already exists.
	if($userTools->checkEmailExists($email))
	{
	    $error .= "That e-mail is already registered.<br/> \n\r";
	    $success = false;
	}

	// Check to see if passwords match.
	if($password != $password_confirm) {
	    $error .= "Passwords do not match.<br/> \n\r";
	    $success = false;
	}

	if($success)
	{
	    // Prep the data for saving in a new user object
	    $data['username'] = $username;
	    $data['password'] = md5($password); //encrypt the password for storage
	    $data['email'] = $email;
	
	    // Create the new user object
	    $newUser = new User($data);
	
	    // Save the new user to the database
	    $newUser->save(true);
	
	    // Log them in
	    $userTools->login($username, $password);
        
        //$successMsg = "Thank you for registering!";
        //sleep(2); 
	    // Redirect them to a welcome page
	    header("Location: index.php");
	    
	}

}

//If the form wasn't submitted, or didn't validate then we show the registration form again
?>


<html>
<head>
	<title>Registration</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="formPageStyle.css" rel="stylesheet">
</head>
<body>
    <div class=userFormContainer>
        <h2 class="formHeader">New User</h2>
        <h3 class="formMsg"><?php echo ($error != "") ? $error : ""; ?></h3>
        <h3 class="formMsg" id="successMsg">Thanks you for registering!</h3>
        <form action="register.php" method="post" class="userForm">
        Username: <input type="text" value="<?php echo $username; ?>" name="username" /><br/>
        Password: <input type="password" value="<?php echo $password; ?>" name="password" /><br/>
        Password (confirm): <input type="password" value="<?php echo $password_confirm; ?>" name="password-confirm" /><br/>
        E-Mail: <input type="text" value="<?php echo $email; ?>" name="email" /><br/>
        <input type="submit" value="Register" name="submit-form" />
        </form>
    <a href="index.php" id="homeLink">Home</a>
    </div>

    
</body>
</html>
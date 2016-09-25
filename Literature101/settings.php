<?php 

require_once 'includes/global.inc.php';

// Check to see if they're logged in
if(!isset($_SESSION['logged_in'])) {
	header("Location: login.php");
}

// Get the user object from the session
$user = unserialize($_SESSION['user']);

// Initialize php variables used in the form
$email = $user->email;
$message = "";

// Check to see that the form has been submitted
if(isset($_POST['submit-settings'])) { 

    // Retrieve the $_POST variables
	$email = $_POST['email'];
    
    // Check to see if email already exists.
	if($userTools->checkEmailExists($email))
	{
	    $message = "That e-mail is already registered.<br/>";
	}
    else
    {
	$user->email = $email;
	$user->save();

	$message = "Settings Saved<br/>";
    }

}

/*If the form wasn't submitted, or didn't validate
then we show the registration form again*/
?>


<html>
<head>
	<title>Change Settings</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="formPageStyle.css" rel="stylesheet">
</head>
<body>
    <div class=userFormContainer>
        <h3 class="formMsg"> <?php echo ($message != "") ? $message: ""; ?> </h3>
        <form action="settings.php" method="post" class="userForm">
            E-Mail: <input type="text" value="<?php echo $email; ?>" name="email" /><br/>
            <input type="submit" value="Update" name="submit-settings" />
        </form>
        <a href="index.php" id="homeLink">Home</a>
    </div>
</body>
</html>
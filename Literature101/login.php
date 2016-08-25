<?php
//login.php

require_once 'includes/global.inc.php';

$error = "";
$username = "";
$password = "";

//check to see if they've submitted the login form
if(isset($_POST['submit-login'])) { 

	$username = $_POST['username'];
	$password = $_POST['password'];

	$userTools = new UserTools();
	if($userTools->login($username, $password)){ 
		//successful login, redirect them to a page
		header("Location: index.php");
	}else{
		$error = "Incorrect username or password. Please try again.";
	}
}
?>

<html>
<head>
	<title>Login</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/formPageStyle.css">
</head>
<body>
    <div class=userFormContainer>
        <h2 class="formHeader">Log In</h2>
        <h3 class="formMsg">
        <?php
        if($error != "")
        {
            echo $error."<br/>";
        }
        ?>
        </h3>
        <form action="login.php" method="post" class="userForm">
            Username: <input type="text" name="username" value="<?php echo $username; ?>" /><br/>
            Password: <input type="password" name="password" value="<?php echo $password; ?>" /><br/>
            <input type="submit" value="Login" name="submit-login" />
        </form>
        <a href="index.php" id="homeLink">Home</a>
        <a href="register.php" id="registerLink">Register</a>
    </div>
</body>
</html>
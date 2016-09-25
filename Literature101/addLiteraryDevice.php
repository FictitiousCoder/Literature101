<?php 
//addLiteraryDevice.php

require_once 'includes/global.inc.php';

//Initialize php variables used in the form
$name = "";
$category = "";
$article = "";
$error = "";


//Check to see that the form has been submitted
if(isset($_POST['device-form'])) { 

	//Retrieve the $_POST variables
	$name = $_POST['name'];
	$category = $_POST['category'];
	$article = $_POST['article'];

	//Initialize variables for form validation
	$success = true;
	$deviceTools = new DeviceTools();
	
	//Validate that the form was filled out correctly.
    //Begin by double-checking that the user is logged in and has editing-rights.
    $user = unserialize($_SESSION['user']);
    
    if($user->editor == false)
	{
	    $error = "You don't have the rights to edit/add content.<br/> \n\r";
	    $success = false;
	}
    
    //Check for special characters in the name
    if (preg_match('/[\'^£$%*()}{@#~?><>,|=_+¬-]/', $name))
    {
	    $error = "Device name must not contain special characters.<br/> \n\r";
	    $success = false;
    }
    
    $find = array("<div","/div>");
    
    //Check for special characters in the name
    if (preg_match($find, $article)) {
        $error = "Sorry, prohibited HTML tags was found in your article.<br/> \n\r";
	    $success = false;
    }

    
	//Check to see if device name already exists
	if($deviceTools->checkDeviceExists($name))
	{
	    $error .= "That literary device is already registered.<br/> \n\r";
	    $success = false;
	}


	if($success)
	{
	    //Prep the data for saving in a new device object
        
	    $data['name'] = str_replace(" ", "_", "$name");
	    $data['category'] = $category;
	    $data['article'] = html_entity_decode(htmlspecialchars_decode(str_replace("'", "''", $article)));
        $data['author'] = $user->username;
        
	    //mysql_real_escape_string($article);
	    //Create the new device object
	    $newDevice = new Device($data);
	
	    //Save the new device to the database
	    $newDevice->save(true);
	
	    //Redirect them to a main page
	    header("Location: index.php");
	}

}

//If the form wasn't submitted, or didn't validate
//then we show the registration form again
?>


<html>
<head>
	<title>New Device</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="formPageStyle.css" rel="stylesheet">
</head>
<body>
    <div class=userFormContainer id="deviceFormContainer">
        <h2 class="formHeader">New Device</h2>
        <h3 class="formMsg"> <?php echo ($error != "") ? $error : ""; ?> </h3>
        <form action="addLiteraryDevice.php" method="post" class="userForm">
            Device Name: <input type="text" value="<?php echo $name; ?>" name="name" /><br/>
            Category:<br />
            <select name="category">
            <option value="literary_techniques">Literary Techniques</option>
            <option value="literary_elements">Literary Elements</option>
            <option value="punctuation">Punctuation</option>
            <option value="videos">Video</option></select><br />
            Article: <textarea name="article" rows="20" cols="100"><?php echo $article;?></textarea>
            <input type="submit" value="Submit" name="device-form" />
	   </form>
       <a href="index.php" id="homeLink">Home</a>
    </div>
</body>
</html>